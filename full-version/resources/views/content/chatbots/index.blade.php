@extends('layouts.contentNavbarLayout1')

@php
  use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Mes Chatbots')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="text-center mb-5">
      <h2 class="fw-bold">Mes Chatbots 🤖</h2>
      <p class="text-muted fs-5">Voici la liste des chatbots que vous avez créés.</p>
    </div>

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
      <div class="table-responsive text-nowrap">
        <table class="table table-hover align-middle">
          <thead class="table-light">
          <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Créé le</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          @forelse($chatbots as $chatbot)
            <tr>
              <td class="fw-semibold">{{ $chatbot->name }}</td>
              <td>{{ $chatbot->type }}</td>
              <td>{{ $chatbot->created_at->format('d/m/Y') }}</td>
              <td>
                <a href="{{ route('client.chatbots.show', ['chatbot' => $chatbot->id]) }}" class="btn btn-outline-primary btn-sm me-2">
                  🚀 Accéder
                </a>

                <form action="{{ route('client.chatbots.destroy', ['id' => auth()->id(), 'chatbot' => $chatbot->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce chatbot ?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-outline-danger btn-sm">
                    🗑 Supprimer
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-muted">Aucun chatbot créé pour le moment.</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
