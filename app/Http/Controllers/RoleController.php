<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:create roles', only: ['create', 'store']),
            new Middleware('permission:edit roles', only: ['edit', 'update']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }

    //Method will show the roles page
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->paginate(10)->withQueryString();
        return view('roles.index', [
            'roles' => $roles,
        ]);
    }

    // Method will show the create role page
    public function create()
    {
        $permissions  = Permission::orderBy('name', 'asc')->get();
        return view('roles.create', [
            'permissions' => $permissions,
        ]);
    }

    // Method will store the new role to the database
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);

        if ($validator->passes()) {
            // dd($request->all());
            $role = Role::create([
                'name' => $request->name,
            ]);

            if (!empty($request->permissions)) {
                foreach ($request->permissions as $value) {
                    $role->givePermissionTo($value);
                }
            }

            return redirect()->route('roles.index')
                ->with('success', 'Role created successfully!');
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    // Method will show the edit permission page
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'hasPermissions' => $hasPermissions,
        ]);
    }

    // Method will update the permission in the database
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:roles,name,' . $id,
        ]);

        if ($validator->passes()) {
            $role = Role::findOrFail($id);
            $role->update([
                'name' => $request->name,
            ]);
            if (!empty($request->permissions)) {
                $role->syncPermissions($request->permissions);
            } else {
                $role->syncPermissions([]);
            }
            return redirect()->route('roles.index')
                ->with('success', 'Role updated successfully!');
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    // Method will show the delete permission in the database
    public function destroy(Request $request)
    {
        $id = $request->id;

        $role = Role::findOrFail($id);

        if ($role == null) {
            session()->flash('error', 'Role not found!');
            return response()->json([
                'status' => false,
            ]);
        }

        $role->delete();
        session()->flash('success', 'Role deleted successfully!');
        return response()->json([
            'status' => true,
        ]);
    }
}
