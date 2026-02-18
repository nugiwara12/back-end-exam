<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('role-management.index');
    }

    public function userDetails(Request $request)
    {
        $user = auth()->user();

        return response()->json([
            'status' => true,
            'users' => [[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'status' => $user->status,
            ]],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 1,
                'total' => 1,
            ]
        ]);
    }

    public function AddUser(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|email|unique:users,email',
            'phone' => 'bail|required|string|regex:/^09\d{9}$/',
            'role' => 'bail|required|in:admin,organizer,customer',
            'password' => 'bail|required|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
            ]
        ], 201);
    }

    public function UpdateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Merge missing request fields with existing DB values
        $request->merge([
            'name' => $request->name ?: $user->name,
            'email' => $request->email ?: $user->email,
            'phone' => $request->phone ?: $user->phone,
            'role' => $request->role ?: $user->role,
        ]);

        $rules = [
            'name' => 'bail|required|string|max:255',
            'email' => "bail|required|email|unique:users,email,{$id}",
            'phone' => 'bail|required|string|regex:/^09\d{9}$/',
            'role' => 'bail|required|in:admin,organizer,customer',
            'password' => 'nullable|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Update fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
            ]
        ], 200);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        $user->status = 0;
        $user->save();

        return response()->json(['status' => true, 'message' => 'User deleted (deactivated) successfully.']);
    }

    public function restoreUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        $user->status = 1;
        $user->save();

        return response()->json(['status' => true, 'message' => 'User restored successfully.']);
    }
}
