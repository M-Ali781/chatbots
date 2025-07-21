@extends('layouts.contentNavbarLayout1')

@section('title', 'Tableau de bord Client')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="text-center mb-5">
      <h2 class="fw-bold py-3">Bienvenue {{ $user->name }} 🎉</h2>
      <p class="text-muted fs-5">
        Gérez facilement vos chatbots, créez-en de nouveaux et suivez vos données en un seul endroit.
      </p>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-5 mb-4">
        <div class="card h-100 shadow-lg border-0">
          <div class="card-body d-flex flex-column justify-content-between text-center">
            <h4 class="card-title mb-3">📂 Voir mes Chatbots</h4>
            <p class="card-text text-muted">
              Retrouvez la liste de tous vos chatbots déjà créés, consultez leurs fichiers PDF ou ajoutez de nouvelles données.
            </p>
            <a href="{{ route('client.chatbots.index', ['id' => auth()->id()]) }}" class="btn btn-primary mt-3">
              📄 Consulter mes Chatbots
            </a>
          </div>
        </div>
      </div>

      <div class="col-md-5 mb-4">
        <div class="card h-100 shadow-lg border-0">
          <div class="card-body d-flex flex-column justify-content-between text-center">
            <h4 class="card-title mb-3">➕ Créer un nouveau Chatbot</h4>
            <p class="card-text text-muted">
              Lancez rapidement la création d'un nouveau chatbot en complétant un formulaire et en téléchargeant un fichier PDF.
            </p>
            <a href="{{ route('client.chatbots.create', ['id' => auth()->id()]) }}" class="btn btn-outline-primary mt-3">
              ➕ Nouveau Chatbot
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
