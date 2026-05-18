<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return Role::with('users')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'label' => 'nullable|string',
        ]);

        $role = Role::create($data);
        return response()->json($role, 201);
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'label' => 'nullable|string',
        ]);

        $role->update($data);
        return $role->fresh();
    }

    public function destroy(Role $role)
    {
        $role->users()->detach();
        $role->delete();
        return response()->noContent();
    }

    public function assignUsers(Request $request, Role $role)
    {
        $data = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $role->users()->sync($data['user_ids']);
        return $role->load('users');
    }
}
