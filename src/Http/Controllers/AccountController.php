<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\Admin\AccountResource;
use App\Models\Account;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // dd('from user controller');
        return Inertia::render('Accounts/Index', [
            'accounts' => AccountResource::collection(Account::advancedFilter()
            ->filter(FacadesRequest::only('trashed'))
            ->paginate(request('rowsPerPage', 20)))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('account_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Accounts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request)
    {
        $account = new Account();
        $account->name    = $request->br_name;
        $account->details = $request->details;
        $account->phone   = $request->phone;
        $account->status  = 1;

        if ($account->save()) {
            $account->users()->create($request->validated() + ['role_id' =>  2, 'status' => 4]);
        }
        return Redirect::route('accounts.index')->with('success', 'User created.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        abort_if(Gate::denies('account_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Accounts/Show', [
            'account' => new AccountResource($account)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Account $account)
    {
        abort_if(Gate::denies('account_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Accounts/Edit', [
            'account' => $account
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        $account->update($request->validated());
        return Redirect::route('accounts.index')->with('success', 'User created.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
