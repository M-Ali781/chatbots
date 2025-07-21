@extends('layouts.contentNavbarLayout')

@section('title', 'Modifier un Utilisateur')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Modifier l'utilisateur</h4>

    <div class="card mb-4">
      <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="password" class="form-control">
          </div>

          <button type="submit" class="btn btn-primary">Enregistrer</button>
          <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
      </div>
    </div>
  </div>
@endsection
