<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\StorePermissionRequest;
use App\Http\Requests\Admin\UpdatePermissionRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $permissions = Permission::paginate(5);

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Permission::create($request->validated());

        return redirect()->route('admin.permissions.index')->with('message', "Successfully Created !");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request,Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->update($request->validated());

        return redirect()->route('admin.permissions.index')->with('message', 'Successfully updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('message', 'Successfully deleted !');
    }
}
