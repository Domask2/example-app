<?php

namespace App\Services\Magic;

use App\Http\Resources\DataSourceFieldsResource;
use App\Models\DataBase;
use App\Models\DataSource;
use App\Models\Magic\MagicEntity;
use App\Repositories\DataBaseRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MagicService
{
    /**
     * @param $db_key
     * @param $ds_key
     * @return mixed
     */
    static function index($db_key, $ds_key)
    {
        /**
         * DS могут прилетать с префиксом нужно его убирать.
         * Т.к. префикс нужен только для фронта.
         */
        $prefix = '';
        $arrDb = explode('-', $db_key);
        if (count($arrDb) > 1) {
            $prefix = $arrDb[0] . '-';
            $db_key = $arrDb[1];
        }

        $dbRepository = new DataBaseRepository();
        $db = $dbRepository->findByKey($db_key);
        /** @var DataSource $ds */
        $ds = DataSource::with('dataSourceFields')
            ->where('data_base_id', $db->id)
            ->where('key', $ds_key)->first();

        if (is_null($ds))
            return [];

        if ($ds['type'] === 'FUNCTION') {
            /** нужно выполнить хранимую функцию  */
            try {
                Config::set("database.connections.udb", $ds->dataBase->toArray());
                $user_id = auth()->user()->id;

                $arr_request = json_encode(request()->toArray());
                $sql = 'select * from ' . $ds['key'] . "($user_id, '$arr_request')";
                $original = DB::connection('udb')->select($sql);

                $columns = [];
                foreach ($original[0] as $key => $val) {
                    $columns[] = [
                        'title' => $key,
                        'dataindex' => $key,
                        'key' => $key,
                        'visible' => true,
                        'pk' => null,
                        'type' => 'string'
                    ];
                }

                $return = [];
                $return['data'] = $original;
                $return['columns'] = $columns;
                $return['key'] = $db->key . '/' . $ds->key;
                $return['description'] = $ds->description;
                $return['type'] = $ds->type;
                $return['crud'] = $ds->crud;
                $return['title'] = $ds->title;
            } catch (Exception $e) {
                dd($e);
            }
        } else {
            /** Создалим магическую сущность */
            $magicEntity = self::getMagicEntity($ds);
            /**
             * Если нет доступа, то вернется пустой массив.
             */
            if (!$magicEntity) return [];

            /** Получим параметры реквеста */
            $search = isset(request()->__search) ? request()->__search : '';
            $filter = isset(request()->__filter) ? request()->__filter : '';
            $curPage = isset(request()->__cur_page) ? request()->__cur_page : 0;
            $perPage = isset(request()->__per_page) ? request()->__per_page : 0;
            $orderBy = isset(request()->__order_by) ? request()->__order_by : false;
            $orderByDesc = isset(request()->__order_by_desc) ? request()->__order_by_desc : false;

            $offset = $perPage * $curPage - $perPage;

            if (!empty($filter)) {
                $magicEntity = self::magicWhere($magicEntity, $filter);
            }

            if (!empty($search)) {
                $magicEntity = self::magicSearch($magicEntity, $search, $ds);
            }

            /**
             * Получим список подключенных полей.
             * Пройдем по оригинальному массиву $original и зададим фильтр для каждого элемена по подключенным полям.
             * Добавим к результату описание подключенных полей.
             * Добавим секцию 'items' с описанием полей таблицы.
             */
            $visible_fields = self::getVisibleFields($ds);

            function getOrderBy($originalResult, $orderByArray) {
                foreach ($orderByArray as $value) {
                    $index = strpos($value, '-');
                    if($index === false) {
                        $originalResult->orderBy($value, 'asc');
                    } else {
                        $value = str_replace('-','', $value);
                        $originalResult->orderBy($value, 'desc');
                    }
                }
                return $originalResult;
            }

            if ($curPage !== 0) {
                $count = $magicEntity->count();
                if ($orderBy) {
                    $orderByArray = explode(',', $orderBy);
                    $originalResult = $magicEntity->limit($perPage)->offset($offset);
                    $original = getOrderBy($originalResult, $orderByArray)->get();
                } else
                    $original = $magicEntity->limit($perPage)->offset($offset)->get();
            } else {
                $count = $magicEntity->limit(1000)->count();
                if ($orderBy) {
                    $orderByArray = explode(',', $orderBy);
                    $originalResult = $magicEntity->limit(1000);
                    $original = getOrderBy($originalResult, $orderByArray)->get();
                }
                else
                    $original = $magicEntity->limit(1000)->get();
            }

            $parsed = [];
            foreach ($original as $item) {
                $item = $item->only($visible_fields);
                if (!isset($item['key']))
                    $item['key'] = Str::random();

                $parsed[] = $item;
            }

            $return = [];
            $return['data'] = $parsed;
            $return['columns'] = DataSourceFieldsResource::collection($ds->dataSourceFields);
            $return['key'] = $prefix . $db->key . '/' . $ds->key;
            $return['description'] = $ds->description;
            $return['type'] = $ds->type;
            $return['crud'] = $ds->crud;
            $return['title'] = $ds->title;
            $return['count'] = $count;
            /** -------------------------------------------------- */
        }

        return $return;
    }

    /**
     * @param $db_key
     * @param $ds_key
     * @return array
     */
    public function store($db_key, $ds_key)
    {
        /** @var DataBase $db */
        $db = DataBase::where('key', $db_key)->first();

        /** Получим DataSource (table/view) по его ключу (имени) */
        /** @var DataSource $ds */
        $ds = DataSource::with('dataSourceFields')
            ->where('data_base_id', $db->id)
            ->where('key', $ds_key)->first();

        /** Создалим магическую сущность */
        /** @var MagicEntity $magicEntity */
        $magicEntity = self::getMagicEntity($ds);
        /**
         * Если нет доступа, то вернется пустой массив.
         */
        if (!$magicEntity) return [];

        $data = request()->toArray();
        unset($data['__method']);


        return $magicEntity->create($data['__data']);
    }

    static function getDsByKeys($db_key, $ds_key)
    {
        $db = DataBase::where('key', $db_key)->first();
        return DataSource::with('dataSourceFields')
            ->where('data_base_id', $db->id)
            ->where('key', $ds_key)->first();
    }

    /**
     * @param $db_key
     * @param $ds_key
     * @return bool
     */
    public function update($db_key, $ds_key)
    {
        /** @var DataSource $ds */
        $ds = self::getDsByKeys($db_key, $ds_key);
        $magicEntity = self::getMagicEntity($ds);
        if (!$magicEntity) return false;

        $data = request()->toArray();
        $magicEntity = self::magicWhere($magicEntity, $data['__filter']);

        if (count($magicEntity->get()) > 0) {
            unset($data['__filter']);
            unset($data['__method']);

            return $magicEntity->update($data['__data']);
        }

        return false;
    }

    /**
     * @param $db_key
     * @param $ds_key
     * @return bool
     */
    public function destroy($db_key, $ds_key)
    {
        /** @var DataSource $ds */
        $ds = self::getDsByKeys($db_key, $ds_key);
        $magicEntity = self::getMagicEntity($ds);
        if (!$magicEntity) return false;

        $data = request()->toArray();
        $magicEntity = self::magicWhere($magicEntity, $data['__filter']);
        if (count($magicEntity->get())) {
            $magicEntity->delete();
            return true;
        }

        return false;
    }

    /**
     * @param $db_key
     * @param $ds_key
     * @return bool
     */
    public function execute($db_key, $ds_key)
    {
        $user = auth() ? auth()->user() : '';
        $dbRepository = new DataBaseRepository();
        $db = $dbRepository->findByKey($db_key);
        $ds = DataSource::where('data_base_id', $db->id)
            ->where('key', $ds_key)->first();

        Config::set("database.connections.udb", $ds->dataBase->toArray());
        /**
         * Получим список параметров процедуры из самой базы
         */
        $procedureParams = self::getRoutineParams($ds);
        /**
         * Первый параметр будет всегда роль пользователя.
         * Все хранимки должны быть на это рассчитаны
         */
        $params = [];
        $arrParams = [];
        $dataRequest = request()->__data;

        $dataRequest['user_id'] = $user->getAuthIdentifier();
        if ($ds->type === 'PROCEDURE') {
            /**
             * Нужно выставить параметры в правильном порядке.
             * Для это получим параметры для этой функции из DB и перебрав их проставим значения полученные от фронта
             */
            foreach ($procedureParams as $param) {
                $params[] = '?';
                /**
                 * в процедуре все параметры начинаются с __ для того чтобы не пересекались их названия с колонками
                 * уберем первые два подчеркивания для названия параметра, чтобы найти его значение в переданных данных
                 * для ВСЕХ параметров функции должны быть переданы значения
                 */
                $key = substr($param['parameter_name'], 2);
                switch ($param['data_type']) {
                    case 'bigint':
                        $arrParams[] = $dataRequest[$key];
                        break;
                    case 'jsonb':
                        $arrParams[] = json_encode($dataRequest[$key]);
                        break;
                    default:
                    {
                        $arrParams[] = addslashes($dataRequest[$key]);
                    }
                }
            }
            $sql = 'call ' . $ds['key'] . '(' . implode(',', $params) . ')';
            return DB::connection('udb')->statement($sql, $arrParams);
        } elseif ($ds->type === 'FUNCTION') {
            $user_id = $user->id;
            $obj = json_encode($dataRequest['obj']);
            $sql = 'select * from ' . $ds['key'] . "($user_id, '$obj')";
            return DB::connection('udb')->select(DB::raw($sql));
        }

        return false;
    }

    /**
     * @param DataSource $ds
     * @return MagicEntity|bool
     */
    static function getMagicEntity(DataSource $ds)
    {
        /**
         * Создаем магическую сущность и сетим ей table $ds->key - там лежит имя таблицы или view
         * Устанавливаем конфиг подключения к базе данных.
         * -- информацию берем у DataSource->dataBase
         */
        $dsa = $ds->dataSourceAccesses;
        $table = $ds->key;

        /**
         * Проверяем доступ.
         * Пройдемся по массиву $dsa
         * Там содержатся разрешения для разные ролей и ссылки на таблицу для каждой роли.
         * Если массив пустой, то таблица берется по ключу DataSourсe и доступ есть у всех.
         */
        if (count($dsa) !== 0) {
            $user = auth()->user();
            $urole = 'user';
            if ($user)
                $urole = auth()->user()->role;
            $access = false;

            foreach ($dsa as $item)
                if ($item->role === $urole) {
                    $access = true;
                    $table = $item->source_name;
                } elseif ($item->role === 'all')
                    $access = true;

            if (!$access)
                return false;
        }

        return self::getEntity($ds->dataBase, $table);
    }


    static function getEntity(DataBase $dataBase, $table)
    {
        $magicEntity = new MagicEntity();
        $magicEntity->setTable($table);
        Config::set("database.connections.udb", $dataBase->toArray());
        $magicEntity->setConnection('udb');

        return $magicEntity;
    }

    static function getVisibleFields(DataSource $ds)
    {
        $ret = [];
        foreach ($ds->dataSourceFields as $field)
            $ret[] = $field->key;

        return $ret;
    }

    /**
     * @param MagicEntity $entity
     * @param $filter
     * @return mixed
     */
    static function magicWhere(MagicEntity $entity, $filter)
    {
        if (empty($filter))
            return $entity;

        $filter_array = explode(',', $filter);
        $qb = $entity->where(function (Builder $query) {
            return $query;
        });

        foreach ($filter_array as $item) {
            $operator = self::getOperator($item);
            $arr = explode($operator, $item);
            $field = $arr[0];
            $values = explode("|", $arr[1]);

            $qb->where(function (Builder $query) use ($field, $operator, $values) {
                switch ($operator) {
                    case '__is_null__':
                        $query->whereNull($field);
                        break;
                    case '__is_not_null__':
                        $query->whereNotNull($field);
                        break;
                    case '__like__':
                        $query->where($field, 'like', "%" . $values[0] . "%");
                        break;

                    default:
                        $query->where($field, $operator, $values[0]);
                }

                for ($i = 1; $i < count($values); $i++)
                    $query->orWhere($field, $operator, $values[$i]);
            });
        }

        return $qb;
    }

    /**
     * @param MagicEntity $entity
     * @param $filter
     * @return mixed
     */
    static function magicSearch(MagicEntity $entity, $search, DataSource $ds)
    {
        $fields = $ds->dataSourceFields()->where('search', true)->get()->toArray();

        $arrSearch = explode(' ', $search);

        $qb = $entity->where(function (Builder $query) {
            return $query;
        });

        foreach ($arrSearch as $searchValue) {
            $qb->where(function (Builder $query) use ($fields, $searchValue) {
                foreach ($fields as $item) {
                    $query->orWhereRaw("LOWER(CAST(" . $item['key'] . " as varchar)) like ? ", ["%" . trim(mb_strtolower($searchValue)) . "%"]);
                }
            });
        }

        return $qb;
    }

    /**
     * @param $item
     * @return bool|string
     */
    static function getOperator($item)
    {
        $operator = count(explode('__is_not_null__', $item)) - 1 ? '__is_not_null__' : false;
        $operator = count(explode('__is_null__', $item)) - 1 ? '__is_null__' : $operator;
        $operator = count(explode('__like__', $item)) - 1 ? '__like__' : $operator;
        $operator = count(explode('>=', $item)) - 1 && !$operator ? '>=' : $operator;
        $operator = count(explode('<=', $item)) - 1 && !$operator ? '<=' : $operator;
        $operator = count(explode('!=', $item)) - 1 && !$operator ? '!=' : $operator;
        $operator = count(explode('>', $item)) - 1 && !$operator ? '>' : $operator;
        $operator = count(explode('<', $item)) - 1 && !$operator ? '<' : $operator;
        $operator = count(explode('=', $item)) - 1 && !$operator ? '=' : $operator;

        return $operator;
    }

    /**
     * @param DataBase $dataBase
     * @return MagicEntity[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTables(DataBase $dataBase)
    {
        $magicEntity = self::getEntity($dataBase, 'information_schema.tables');
        return $magicEntity->where('table_schema', $dataBase->schema)->orderBy('table_name')->get();
    }

    /**
     * @param DataBase $dataBase
     * @return MagicEntity[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRoutines(DataBase $dataBase)
    {
        $magicEntity = self::getEntity($dataBase, 'information_schema.routines');
        $routines = $magicEntity->where('routines.specific_schema', $dataBase->schema)->get();

        return $routines;
    }

    /**
     * @param DataSource $dataSource
     * @return mixed
     */
    static function getRoutineParams(DataSource $dataSource)
    {
        $dataBase = $dataSource->dataBase;
        $magicEntity = self::getEntity($dataBase, 'information_schema.parameters');
        return $magicEntity
            ->where('specific_name', 'like', $dataSource->key . '_%')
            ->orderBy('ordinal_position')
            ->get();
    }

    /**
     * @param DataSource $dataSource
     * @return string
     */
    public function getRoutineDefinition(DataSource $dataSource)
    {
        $dataBase = $dataSource->dataBase;
        $magicEntity = self::getEntity($dataBase, 'information_schema.routines');
        $definition = $magicEntity
            ->where('routine_schema', $dataBase->schema)
            ->where('routine_name', $dataSource->key)->get()[0];

        $definition->definition = $definition->routine_definition;
        return $definition;
    }

    /**
     * @param DataSource $dataSource
     * @return mixed
     */
    public function getFields(DataSource $dataSource)
    {
        $dataBase = $dataSource->dataBase;
        $magicEntity = self::getEntity($dataBase, 'information_schema.columns');
        return $magicEntity
            ->where('table_schema', $dataBase->schema)
            ->where('table_name', $dataSource->key)
            ->orderBy('table_name')->get();
    }

    public function getTableViewDefinition(DataSource $dataSource)
    {
        $dataBase = $dataSource->dataBase;
        $magicEntity = self::getEntity($dataBase, 'information_schema.views');
        $definition = $magicEntity
            ->where('table_schema', $dataBase->schema)
            ->where('table_name', $dataSource->key)->get()[0];

        $definition->definition = $definition->routine_definition;
        return $definition;
    }
}
