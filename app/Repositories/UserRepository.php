<?php


namespace App\Repositories;

use App\Models\User as Model;

/**
 * Class DataBaseRepository
 * @package App\Repositories
 */
class UserRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->entity()->find($id);
    }

    /**
     * @return mixed
     */
    public function getAllUsers()
    {
        $columns = ['id', 'name', 'role', 'email', 'projects_roles'];

        $users = $this->entity()->all();
        return $users;
    }
}
