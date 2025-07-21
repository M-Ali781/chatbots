@extends('layouts.contentNavbarLayout1')

@section('title', 'Créer un Chatbot')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="text-center mb-5">
      <h2 class="fw-bold">Création de votre Chatbot 🤖</h2>
      <p class="text-muted fs-5">Remplissez ce formulaire pour créer un nouveau chatbot avec un PDF.</p>
    </div>

    {{-- ✅ Messages de succès, d'erreur et de validation --}}
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">
        <form action="{{ route('client.chatbots.store', ['id' => auth()->id()]) }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="mb-4">
            <label for="name" class="form-label">Nom du Chatbot</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
          </div>

          <div class="mb-4">
            <label for="type" class="form-label">Type de Chatbot</label>
            <select class="form-select" id="type" name="type" required>
              <option value="">Sélectionnez un type</option>
              <option value="FAQ" {{ old('type') == 'FAQ' ? 'selected' : '' }}>FAQ</option>
              <option value="Service Client" {{ old('type') == 'Service Client' ? 'selected' : '' }}>Service Client</option>
              <option value="Assistant Personnel" {{ old('type') == 'Assistant Personnel' ? 'selected' : '' }}>Assistant Personnel</option>
              <option value="Commercial" {{ old('type') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
              <option value="Ressources Humaines" {{ old('type') == 'Ressources Humaines' ? 'selected' : '' }}>Ressources Humaines</option>
              <option value="Support Technique" {{ old('type') == 'Support Technique' ? 'selected' : '' }}>Support Technique</option>
              <option value="Vente en Ligne" {{ old('type') == 'Vente en Ligne' ? 'selected' : '' }}>Vente en Ligne</option>
              <option value="Réservation" {{ old('type') == 'Réservation' ? 'selected' : '' }}>Réservation</option>
              <option value="Conseiller Financier" {{ old('type') == 'Conseiller Financier' ? 'selected' : '' }}>Conseiller Financier</option>
              <option value="Accompagnement Juridique" {{ old('type') == 'Accompagnement Juridique' ? 'selected' : '' }}>Accompagnement Juridique</option>
            </select>
          </div>

          <div class="mb-4">
            <label for="pdf" class="form-label">Télécharger un PDF</label>
            <input class="form-control" type="file" id="pdf" name="pdf" accept=".pdf" required>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary">Créer le Chatbot</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
