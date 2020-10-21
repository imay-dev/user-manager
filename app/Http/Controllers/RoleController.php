<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\PermissionContract;
use App\Contracts\RoleContract;
use App\Http\Requests\{RoleStore, RoleUpdate};
use App\Http\Resources\{Role, RoleCollection};
use App\Repositories\Eloquent\Criteria\EagerLoad;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends MainController
{

    /**
     * @var PermissionContract
     */
    protected $roleContract;

    /**
     * PermissionController constructor.
     *
     * @param RoleContract $roleContract
     */
    public function __construct(RoleContract $roleContract)
    {
        $this->roleContract = $roleContract;
        $this->middleware('auth:api');
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
            new RoleCollection($this->roleContract
                ->withCriteria([
                    new EagerLoad(['permissions', 'users']),
                ])
                ->paginate(request('perPage', 15))
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleStore $request
     *
     * @return JsonResponse
     */
    public function store(RoleStore $request)
    {
        return $this->response->success(
            new Role($this->roleContract->store($request->only('name', 'guard_name')))
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
            new Role($this->roleContract
                ->withCriteria([
                    new EagerLoad(['permissions', 'users']),
                ])
                ->show($id)
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleUpdate $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(RoleUpdate $request, $id)
    {
        $this->roleContract->update($request->only('name', 'guard_name'), $id);

        return $this->response->success(
            new Role($this->roleContract->show($id))
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
        $this->roleContract->destroy($id);

        return $this->response->success([
            'message' => 'Role deleted successfully.'
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function syncPermissions(Request $request, $id)
    {
        $role = $this->roleContract->show($id);

        $role->syncPermissions($request->input('permissions', []));

        return $this->response->success([
            'message' => 'Role Permissions synced successfully.'
        ]);
    }
}
