<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Contracts\UserContract;
use App\Http\Requests\{SyncRolesAndPermissions, UserStore, UserUpdate};
use App\Http\Resources\Auth\{User, UserCollection};
use App\Repositories\Eloquent\Criteria\EagerLoad;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends MainController
{

    /**
     * @var UserContract
     */
    protected $userContract;

    /**
     * PermissionController constructor.
     *
     * @param UserContract $userContract
     */
    public function __construct(UserContract $userContract)
    {
        $this->userContract = $userContract;

        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->response->success(
            new UserCollection($this->userContract
                ->withCriteria([
                    new EagerLoad(['roles', 'permissions']),
                ])
                ->paginate(request('perPage', 15))
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStore $request
     *
     * @return JsonResponse
     */
    public function store(UserStore $request)
    {
        return $this->response->success(
            new User($this->userContract->store($request->only('name', 'email', 'password')))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        return $this->response->success(
            new User($this->userContract
                ->withCriteria(
                    new EagerLoad(['roles', 'permissions'])
                )
                ->show($id)
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdate $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UserUpdate $request, $id)
    {
        if ($request->filled('password')) {
            $this->userContract->update($request->only('name', 'email', 'password'), $id);

        } else {
            $this->userContract->update($request->only('name', 'email'), $id);
        }

        return $this->response->success(
            new User($this->userContract->show($id))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->userContract->destroy($id);

        return $this->response->success([
            'message' => 'User deleted successfully.'
        ]);
    }

    /**
     * @param SyncRolesAndPermissions $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function syncRolesAndPermissions(SyncRolesAndPermissions $request, $id)
    {
        $user = $this->userContract->show($id);
        $user->syncRoles($request->input('roles', []));
        $user->syncPermissions($request->input('permissions', []));

        return $this->response->success([
            'message' => 'User Roles & Permissions synced successfully.'
        ]);
    }

}
