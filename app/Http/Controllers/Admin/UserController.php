<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            // Mapping string role names from view to role_id if necessary, 
            // but let's assume the view sends 'admin' or 'utilisateur' and we check relationship or field.
            // If the user table has a 'role_id' and we want to filter by role name:
            $roleName = $request->role;
            $query->whereHas('role', function($q) use ($roleName) {
                $q->where('nom', 'like', "%{$roleName}%");
            });
        }

        $users = $query->with('role')->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // validation + création user à implémenter
    }
}
