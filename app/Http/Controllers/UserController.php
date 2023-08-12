<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->authorize(User::class);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
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
