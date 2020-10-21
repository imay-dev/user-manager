<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\PermissionContract;
use App\Http\Requests\{PermissionStore, PermissionUpdate};
use App\Http\Resources\{Permission, PermissionCollection};
use App\Repositories\Eloquent\Criteria\EagerLoad;

/**
 * Class PermissionController
 * @package App\Http\Controllers
 */
class PermissionController extends MainController
{

    /**
     * @var PermissionContract
     */
    protected $permissionContract;

    /**
     * PermissionController constructor.
     *
     * @param PermissionContract $permissionContract
     */
    public function __construct(PermissionContract $permissionContract)
    {
        $this->permissionContract = $permissionContract;

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
            new PermissionCollection($this->permissionContract
                ->withCriteria([
                    new EagerLoad(['roles', 'users']),
                ])
                ->paginate(request('perPage', 15))
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionStore $request
     *
     * @return JsonResponse
     */
    public function store(PermissionStore $request)
    {
        return $this->response->success(
            new Permission($this->permissionContract->store($request->only('name', 'guard_name')))
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
            new Permission($this->permissionContract
                ->withCriteria([
                    new EagerLoad(['roles', 'users']),
                ])
                ->show($id)
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionUpdate $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(PermissionUpdate $request, $id)
    {
        $this->permissionContract->update($request->only('name', 'guard_name'), $id);

        return $this->response->success(
            new Permission($this->permissionContract->show($id))
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
        $this->permissionContract->destroy($id);

        return $this->response->success([
            'message' => 'Permission deleted successfully.'
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function syncRoles(Request $request, $id)
    {
        $permission = $this->permissionContract->show($id);

        $permission->syncRoles($request->input('roles', []));

        return $this->response->success([
            'message' => 'Permissions Role synced successfully.'
        ]);
    }
}
