<?php

namespace App\Policies;

use App\Models\DataSource;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DataSourcePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DataSource  $dataSource
     * @return Response|bool
     */
    public function view(User $user, DataSource $dataSource)
    {
        return $user->id === $dataSource->dataBase->user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DataSource  $dataSource
     * @return Response|bool
     */
    public function update(User $user, DataSource $dataSource)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DataSource  $dataSource
     * @return Response|bool
     */
    public function delete(User $user, DataSource $dataSource)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DataSource  $dataSource
     * @return Response|bool
     */
    public function restore(User $user, DataSource $dataSource)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DataSource  $dataSource
     * @return Response|bool
     */
    public function forceDelete(User $user, DataSource $dataSource)
    {
        //
    }
}
