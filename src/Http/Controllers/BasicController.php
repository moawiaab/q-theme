<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBasicRequest;
use App\Http\Requests\UpdateBasicRequest;
use App\Http\Resources\BasicResource;
use App\Models\Basic;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class BasicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Basics/Index', [
            'basics' => BasicResource::collection(
                Basic::advancedFilter()
                    ->filter(FacadesRequest::only('trashed'))
                    ->paginate(request('rowsPerPage', 20))->withQueryString()
            )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Basics/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBasicRequest $request)
    {
        $data = ['user_id' => auth()->id(), 'account_id' => auth()->user()->account_id];

        Basic::create($request->validated() + $data);

        return Redirect::route('basics.index')->with('success', 'basic created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Basic $basic)
    {
        abort_if(Gate::denies('basic_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Basics/Show', [
            'basic' => new BasicResource($basic)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Basic $basic)
    {
        abort_if(Gate::denies('basic_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return Inertia::render('Basics/Edit', [
            'basic' => $basic,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBasicRequest $request, Basic $basic)
    {
        $basic->update($request->validated());
        return Redirect::route('basics.index')->with('success', 'basic created.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Basic $basic)
    {
        abort_if(Gate::denies('basic_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        if ($basic->deleted_at) {
            $basic->forceDelete();
        } else {
            $basic->delete();
        }
    }

    public function restore(Basic $basic)
    {
        abort_if(Gate::denies('basic_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $basic->restore();
    }
}
