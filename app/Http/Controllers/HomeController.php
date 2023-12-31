<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function login() 
    {
        return view('auth.login');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->authorize('view', User::class);
        return view('admin.index', [
            'users' => User::select('name', 'login', 'role', 'password')->get()]);
    }

    public function create() {
        $this->authorize('create', User::class);
        return view('auth.register');
    }

     /**
     * Remove the specified user from storage.
     */
    public function delete(User $user)
    {
        $user->delete();
        return to_route('users')->with('success', 'L\'utilisateur a été bien supprimé');
    }
}
