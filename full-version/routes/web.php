<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientChatbotController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\CustomAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Route::prefix('admin')->group(function () {
  Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
  Route::post('/login', [AdminAuthController::class, 'login']);
});




Route::prefix('admin')->middleware('auth:admin')->group(function () {
  Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
  Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
  Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});



Route::get('/', [CustomAuthController::class, 'showLoginSignup'])->name('login');

Route::post('/', [CustomAuthController::class, 'handleLoginSignup'])->name('login-signup.post');

Route::prefix('admin')->middleware('auth:admin')->group(function () {
  Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
  Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
  Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
  Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
  Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
  Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
  Route::get('/statistiques', [AdminUserController::class, 'statistiques'])->name('admin.users.statistics');

});




Route::middleware(['auth'])->group(function () {
  Route::get('/client/{id}/dashboard', [ClientChatbotController::class, 'dashboard'])->name('client.dashboard.with.id');
  Route::get('/client/{id}/chatbots', [ClientChatbotController::class, 'index'])->name('client.chatbots.index');
  Route::get('/client/{id}/chatbots/create', [ClientChatbotController::class, 'create'])->name('client.chatbots.create');
  Route::post('/client/{id}/chatbots/store', [ClientChatbotController::class, 'store'])->name('client.chatbots.store');
});
Route::delete('/client/{id}/chatbots/{chatbot}', [ClientChatbotController::class, 'destroy'])->name('client.chatbots.destroy');
Route::get('/client/chatbots/{chatbot}', [ClientChatbotController::class, 'show'])->name('client.chatbots.show');
Route::post('/client/chatbot/{chatbot}/chat', [ClientChatbotController::class, 'chatWithBot'])->name('client.chatbots.chat');












Route::post('/logout', function () {
  Auth::logout();
  return redirect()->route('admin.login');
})->name('logout');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
