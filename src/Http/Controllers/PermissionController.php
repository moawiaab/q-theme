<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\Admin\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // dd('from user controller');
        return Inertia::render('Permissions/Index', [
            'permissions' => PermissionResource::collection(Permission::advancedFilter()
                ->filter(FacadesRequest::only('trashed'))
                ->paginate(request('rowsPerPage', 20)))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Permissions/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $data = [
            ['details' => " عرض " .   $request->details, 'title' => $request->title . "_access"],
            ['details' => " إنشاء " .  $request->details, 'title' => $request->title . "_create"],
            ['details' => " تعديل " .  $request->details, 'title' => $request->title . "_edit"],
            ['details' => " حذف " .    $request->details, 'title' => $request->title . "_delete"]
        ];


        $permission = Permission::insert($data);
        return Redirect::route('permissions.index')->with('success', 'User created.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Permissions/Show', [
            'permission' => new PermissionResource($permission)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Permissions/Edit', [
            'permission' =>  $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        return Redirect::route('permissions.index')->with('success', 'User created.');

  //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        if ($permission->deleted_at) {
            $permission->forceDelete();
        } else {
            $permission->delete();
        }
    }

    public function restore(Permission $permission)
    {
        // dd($permission);
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $permission->restore();
    }
}
