<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EBook;
use Illuminate\Http\Request;
use App\Mail\newUserPasswordMail;
use App\Models\LearningMaterial;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard()
    {
        $userCount = User::count();
        $EBookCount = EBook::count();
        $pdfCount = LearningMaterial::count();
        $ebooks = EBook::latest()->take(5)->get();
        return view('dashboard', compact(['userCount',  'EBookCount', 'pdfCount', 'ebooks']));
    }

    public function index()
    {
        $users = User::where('id', '>=', 2)->get();
        return view('admin.view', compact(['users']));
    }

    public function AdminEditPage($id)
    {
        $user = User::findOrFail($id);
        return view('admin.AdminEdit', compact(['user']));
    }

    public function AdminAdd()
    {
        return view('admin.Add');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'fullName' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:8', // Assuming you want to require a password for new users
        ]);

        $unhashedPassword = $request->password;
        $email = $request->email;
        $name = $request->fullName;

        // Create a new user record in the database
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'role' => $request->role,
            'password' => Hash::make($unhashedPassword), // Encrypting the password
        ]);

        Mail::to($email)->queue(new newUserPasswordMail($unhashedPassword, $email, $name));

        // Redirect to the desired route with a success message
        return redirect()->route('admin.view')->with('status', 'Created Successfully');
    }


    public function update(Request $request, $id)
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
