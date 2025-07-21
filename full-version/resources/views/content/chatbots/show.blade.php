@extends('layouts.contentNavbarLayout1')

@section('title', 'Chatbot')

@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script>
    // 🔥 Ceci est indispensable !
    const chatbotId = {{ $chatbot->id }};
  </script>

  <div class="container-xxl flex-grow-1 container-p-y">
    <h2 class="fw-bold mb-4">Chatbot Cohere API</h2>

    <div class="card shadow-sm mb-4" style="height: 600px; display: flex; flex-direction: column;">
      <div class="card-header bg-white">
        <h5 class="mb-0">💬 Discussion avec le chatbot</h5>
      </div>
      <div id="chatbox" class="card-body overflow-auto" style="flex-grow: 1; background-color: #f7f7f7;">
        <div class="text-muted small text-center">Pose ta question ci-dessous ⬇️</div>
      </div>
      <div class="card-footer bg-white">
        <form id="chat-form" class="d-flex gap-2">
          <input type="text" id="user-input" name="message" class="form-control" placeholder="Pose ta question..." required autocomplete="off">
          <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.getElementById('chat-form').addEventListener('submit', function(e) {
      e.preventDefault();
      const chatbox = document.getElementById('chatbox');
      const userInput = document.getElementById('user-input');
      const userMessage = userInput.value.trim();

      if (!userMessage) return;

      const userMsgElement = document.createElement('div');
      userMsgElement.classList.add('p-2', 'my-2', 'rounded', 'bg-primary', 'text-white', 'w-75', 'ms-auto');
      userMsgElement.textContent = userMessage;
      chatbox.appendChild(userMsgElement);

      userInput.value = '';
      chatbox.scrollTop = chatbox.scrollHeight;

      fetch(`/client/chatbot/${chatbotId}/chat`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: userMessage })
      })


        .then(response => response.json())
        .then(data => {
          const botMsgElement = document.createElement('div');
          botMsgElement.classList.add('p-2', 'my-2', 'rounded', 'bg-light', 'border', 'w-75');

          if (data.message) {
            botMsgElement.textContent = '🤖 : ' + data.message;
          } else if (data.error) {
            botMsgElement.textContent = '🤖 : ' + data.error;
          } else {
            botMsgElement.textContent = '🤖 : Je n\'ai pas compris votre question.';
          }

          chatbox.appendChild(botMsgElement);
          chatbox.scrollTop = chatbox.scrollHeight;
        })
        .catch(error => {
          const botMsgElement = document.createElement('div');
          botMsgElement.classList.add('p-2', 'my-2', 'rounded', 'bg-danger', 'text-white', 'w-75');
          botMsgElement.textContent = '🤖 : Erreur de connexion au serveur.';
          chatbox.appendChild(botMsgElement);
          chatbox.scrollTop = chatbox.scrollHeight;
        });
    });
  </script>
@endpush
