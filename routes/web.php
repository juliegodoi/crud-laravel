<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Define as rotas para as ações
Route::get('/', [UserController::class, 'read']);
Route::post('/', [UserController::class, 'create'])->name('users.create');
Route::match(['get', 'put'], '/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/{id}', [UserController::class, 'delete'])->name('users.delete');

// Define uma rota para obter URLs das rotas e usar no arquivo JS para as requisições
Route::get('/api/routes', function() {
  return response()->json([
      'createUser' => route('users.create'),
      'updateUser' => route('users.update', ['id' => 'dummy']),
      'deleteUser' => route('users.delete', ['id' => 'dummy']),
  ]);
});