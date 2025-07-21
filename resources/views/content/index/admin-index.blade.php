@extends('layouts.contentNavbarLayout')

@section('title', 'Gestion des Utilisateurs')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Gestion des Utilisateurs</h4>

    <!-- Bouton "Filtrer" avec Dropdown -->
    <div class="dropdown mb-4">
      <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        Filtrer
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="{{ route('admin.users.index', array_merge(request()->query(), ['sort_field' => 'name', 'sort' => 'asc'])) }}">Nom A → Z</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.users.index', array_merge(request()->query(), ['sort_field' => 'name', 'sort' => 'desc'])) }}">Nom Z → A</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.users.index', array_merge(request()->query(), ['sort_field' => 'id', 'sort' => 'asc'])) }}">ID ↑</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.users.index', array_merge(request()->query(), ['sort_field' => 'id', 'sort' => 'desc'])) }}">ID ↓</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.users.index', array_merge(request()->query(), ['sort_field' => 'created_at', 'sort' => 'desc'])) }}">Plus récent</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.users.index', array_merge(request()->query(), ['sort_field' => 'created_at', 'sort' => 'asc'])) }}">Plus ancien</a></li>
      </ul>
    </div>

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou email" value="{{ request('search') }}">
        <button class="btn btn-outline-primary" type="submit">Rechercher</button>
      </div>
    </form>

    <div class="card">
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Date de création</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody class="table-border-bottom-0">
          @foreach($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at->format('d/m/Y') }}</td>
              <td class="d-flex gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                </form>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>

        <div class="d-flex justify-content-center m-3">
          {!! $users->appends([
              'search' => request('search'),
              'sort' => request('sort'),
              'sort_field' => request('sort_field')
          ])->links('pagination::bootstrap-5') !!}
        </div>
      </div>
    </div>
  </div>
@endsection
