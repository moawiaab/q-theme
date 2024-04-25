<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Models\Account;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // dd('from user controller');
        return Inertia::render('Roles/Index', [
            'roles'  => RoleResource::collection(
                Role::with(['permissions', 'users'])->advancedFilter()
                ->when(auth()->user()->account_id === 1, function ($q) {
                    $q->whereIn('account_id', Account::where('status', 1)->pluck('id'));
                })->when(auth()->user()->account_id != 1, function ($q) {
                    $q->where('account_id', auth()->user()->account_id);
                })
                    ->filter(FacadesRequest::only('trashed'))
                    ->paginate(request('rowsPerPage', 10))
            )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Roles/Create', [
            'permissions' => Permission::where('id', '>', 1)->when(auth()->user()->account_id != 1, function ($q) {
                $q->where('status', 1);
            })->get(['id as value', 'details as label']),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role =  auth()
            ->user()
            ->account
            ->roles()->create($request->validated());
        $role->permissions()->sync($request->permissions);
        $role->permissions()->syncWithoutDetaching(1);
        return Redirect::route('roles.index')->with('success', 'User created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Roles/Show', [
            'role' => new RoleResource($role),
            'permissions' => $role->permissions->transform(fn ($pram) => [
                'id' => $pram->id,
                'name' => $pram->details,
            ]),
            'users' => $role->users->transform(fn ($pram) => [
                'id' => $pram->id,
                'name' => $pram->name,
            ])

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Roles/Edit', [
            'role' => $role,
            'permissions' => Permission::when(auth()->user()->account_id != 1, function ($q) {
                $q->where('status', 1);
            })->get(['id as value', 'details as label']),
            'roles' => $role->permissions->transform(fn ($role) => $role->id),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        if (is_numeric($request->permissions[0]) != null) {
            $role->permissions()->sync($request->permissions);
            $role->permissions()->syncWithoutDetaching(1);
        }
        return Redirect::route('roles.index')->with('success', 'Role created.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        if ($role->deleted_at) {
            $role->forceDelete();
        } else {
            $role->delete();
        }
    }

    public function restore(Role $role)
    {
        // dd($user);
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $role->restore();
    }
}
