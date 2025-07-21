<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
  public function index(Request $request)
  {
    $query = User::query();

    if ($request->filled('search')) {
      $search = $request->input('search');
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')
          ->orWhere('email', 'like', '%' . $search . '%');
      });
    }

    $sortField = $request->get('sort_field', 'name');
    $sortDirection = $request->get('sort', 'asc');

    $query->orderBy($sortField, $sortDirection);

    $users = $query->paginate(10);

    return view('content.index.admin-index', compact('users', 'sortField', 'sortDirection'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6',
    ]);

    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur ajouté avec succès.');
  }

  public function destroy(User $user)
  {
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
  }

  public function update(Request $request, User $user)
  {
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email,' . $user->id,
      'password' => 'nullable|min:6',
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];

    if (!empty($validated['password'])) {
      $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
  }

  public function edit(User $user)
  {
    return view('content.index.edit', compact('user'));
  }

  public function statistiques()
  {
    $totalUsers = \App\Models\User::count();
    $usersByMonth = \App\Models\User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
      ->groupBy('month')
      ->orderBy('month')
      ->get();


    return view('content.index.statistics', compact('totalUsers', 'usersByMonth'));
  }


}
