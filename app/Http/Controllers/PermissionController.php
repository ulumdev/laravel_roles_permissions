<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // Method will show the permissions page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('permissions.index', compact('permissions'));
    }

    // Method will show the create permission page
    public function create()
    {
        return view('permissions.create');
    }

    // Method will store the new permission to the database
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);

        if ($validator->passes()) {
            Permission::create([
                'name' => $request->name,
            ]);
            return redirect()->route('permissions.index')
                ->with('success', 'Permission created successfully!');
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    // Method will show the edit permission page
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    // Method will update the permission in the database
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,' . $id,
        ]);

        if ($validator->passes()) {
            $permission = Permission::findOrFail($id);
            $permission->update([
                'name' => $request->name,
            ]);
            return redirect()->route('permissions.index')
                ->with('success', 'Permission updated successfully!');
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

        $permission = Permission::findOrFail($id);

        if ($permission == null) {
            session()->flash('error', 'Permission not found!');
            return response()->json([
                'status' => false,
            ]);
        }

        $permission->delete();
        session()->flash('success', 'Permission deleted successfully!');
        return response()->json([
            'status' => true,
        ]);
    }
}
