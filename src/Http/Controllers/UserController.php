<?php

namespace Moawiaab\QTheme\Http\Controllers;

use App\Http\Controllers\Controller;
use Moawiaab\QTheme\Http\Requests\StoreUserRequest;
use Moawiaab\QTheme\Http\Requests\UpdateUserRequest;
use Moawiaab\QTheme\Http\Resources\Admin\UserResource;
use Moawiaab\QTheme\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('from user controller');
        return Inertia::render('Users/Index', [
            'users' => UserResource::collection(
                User::advancedFilter()
                    ->when(auth()->user()->account_id === 1, function ($q) {
                        $q->whereIn('account_id', Account::where('status', 1)->pluck('id'));
                    })->when(auth()->user()->account_id != 1, function ($q) {
                        $q->where('account_id', auth()->user()->account_id);
                    })
                    ->filter(FacadesRequest::only('trashed'))
                    ->paginate(request('rowsPerPage', 20))->withQueryString()
            ),
            'roles' =>
            auth()
                ->user()
                ->account
                ->roles()->get(['id', 'title']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Users/Create', [
            'roles' =>
            auth()
                ->user()
                ->account
                ->roles()->get(['id', 'title']),
            'type' => [
                [
                    'id' => 1,
                    'title' => 'مشرف',
                ],
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $pass = ['password' => Hash::make($request->password)];

        User::create([
            'name' => $request->name,
            'role_id' => 3,
            'account_id' => 1,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        // $user = auth()->user()->account->users()->create($request->validated() + $pass);
        // $user->update($pass);
        return Redirect::route('users.index')->with('success', 'User created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Users/Show', [
            'user' => new UserResource($user)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Users/Edit', [
            'user' => $user,
            'roles' =>
            auth()
                ->user()
                ->account
                ->roles()->get(['id', 'title']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return Redirect::route('users.index')->with('success', 'User created.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        if ($user->deleted_at) {
            $user->forceDelete();
        } else {
            $user->delete();
        }
    }

    public function restore(User $user)
    {
        // dd($user);
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $user->restore();
    }
}
