<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.view', compact(['users']));
    }

    public function AdminEditPage($id)
    {
        $user = User::findOrFail($id);
        return view('admin.AdminEdit', compact(['user']));
    }

    public function store(Request $request, $id)
    {

        $request->validate([
            'fullName' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->fullName,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.view')->with('status', 'Updated Successfully');

    }

    public function destroy($id)
    {

        $user = User::findOrFail($id);

        $user->delete();
        return redirect()->back()->with('status', 'User Deleted Successfully');

    }
}
