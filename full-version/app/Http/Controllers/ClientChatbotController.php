<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatbot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ClientChatbotController extends Controller
{
  public function dashboard($id)
  {
    if (auth()->id() != $id) {
      abort(403);
    }
    $user = auth()->user();
    return view('content.chatbots.dashboard', compact('user'));
  }

  public function index($id)
  {
    if (auth()->id() != $id) {
      abort(403);
    }
    $chatbots = Chatbot::where('user_id', auth()->id())->get();
    return view('content.chatbots.index', compact('chatbots'));
  }

  public function create($id)
  {
    if (auth()->id() != $id) {
      abort(403, 'Accès interdit à ce dashboard.');
    }
    return view('content.chatbots.create', compact('id'));
  }

  public function destroy($id, $chatbotId)
  {
    $chatbot = Chatbot::where('id', $chatbotId)
      ->where('user_id', $id)
      ->firstOrFail();
    if ($chatbot->pdf_path) {
      Storage::disk('public')->delete($chatbot->pdf_path);
    }
    $chatbot->delete();
    return redirect()->route('client.chatbots.index', ['id' => $id])
      ->with('success', 'Le chatbot a été supprimé avec succès.');
  }

  public function store(Request $request, $id)
  {
    if (auth()->id() != $id) {
      return back()->with('error', 'Erreur : tentative d’accès interdit.');
    }

    try {
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'pdf' => 'required|file|mimes:pdf|max:10240',
      ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return back()->with('error', 'Erreur de validation : ' . $e->getMessage());
    }

    try {
      if (!$request->hasFile('pdf')) {
        return back()->with('error', 'Le fichier PDF est manquant.');
      }
      $pdf = $request->file('pdf');
      if (!$pdf->isValid()) {
        return back()->with('error', 'Le fichier PDF est corrompu ou non valide.');
      }
      $path = $pdf->store('chatbots', 'public');
      Chatbot::create([
        'user_id' => auth()->id(),
        'name' => $validated['name'],
        'type' => $validated['type'],
        'pdf_path' => $path,
      ]);
      return redirect()->route('client.chatbots.index', ['id' => auth()->id()])
        ->with('success', 'Le Chatbot a été créé avec succès.');
    } catch (Exception $e) {
      Log::error('Erreur lors de la création du chatbot : ' . $e->getMessage());
      return back()->with('error', 'Une erreur est survenue lors de la création du chatbot : ' . $e->getMessage());
    }
  }

  public function chatWithBot(Request $request, $chatbotId)
  {
    $chatbot = \App\Models\Chatbot::where('user_id', auth()->id())->findOrFail($chatbotId);
    $userMessage = $request->input('message');

    $response = Http::withOptions([
      'verify' => 'C:/xampp/php/extras/ssl/cacert.pem',
    ])->withHeaders([
      'Authorization' => 'Bearer ' . env('COHERE_API_KEY'),
      'Content-Type' => 'application/json',
    ])->post('https://api.cohere.ai/v1/chat', [
      'model' => 'command-r-plus',
      'message' => $userMessage,
      'chat_history' => [],
    ]);

    if ($response->successful()) {
      $botReply = $response->json('text') ?? "Je n'ai pas compris votre question.";
      return response()->json(['reply' => $botReply]);
    }

    return response()->json(['reply' => "Erreur API Cohere : " . $response->body()]);
  }



  public function show($chatbotId)
  {
    $chatbot = \App\Models\Chatbot::where('user_id', auth()->id())->findOrFail($chatbotId);
    return view('content.chatbots.show', compact('chatbot'));
  }










}
