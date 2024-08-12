<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Método para listar usuários
    public function read()
    {
        // Ordena os usuarios pelo campo id em ordem decrescente
        // e pagina a lista com 10 usuários por página
        $users = User::orderBy('id', 'desc')->paginate(10);
        // Retorna a view passando a lista de usuários
        return view('index', compact('users'));
    }

    // Método para criar usuário
    public function create(Request $request)
    {
        // Verifica se já existe um usuário com o mesmo e-mail no banco
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            // Se o e-mail já existe, retorna uma resposta de falha JSON
            return response()->json(['success' => false]);
        }

        // Valida os dados da requisição
        $validatedData = $request->validate([
            'nome' => 'required|string|max:155',
            'email' => 'required|email|unique:users,email',
            'telefone' => 'nullable|regex:/^[0-9]{8,11}$/',
        ]);

        // Cria um novo usuário com os dados validados
        User::create($validatedData);
        
        // Retorna uma resposta de sucesso JSON
        return response()->json(['success' => true]);
    }

    // Método para atualizar usuário
    public function update(Request $request, $id)
    {
        // Se o método da requisição for GET, retorna os dados do usuário especificado pelo ID
        if ($request->isMethod('get')) {
            $user = User::findOrFail($id);
            return response()->json($user);
        }

        // Se o método da requisição for PUT, atualiza o usuário
        if ($request->isMethod('put')) {

            // Verifica se já existe um usuário com o mesmo e-mail, exceto o usuário atual
            $existingUser = User::where('email', $request->email)->where('id', '!=', $id)->first();
            // Se o e-mail já existe, retorna uma resposta de falha JSON
            if ($existingUser) {
                return response()->json(['success' => false]);
            }

            // Valida os dados da requisição
            $validatedData = $request->validate([
                'nome' => 'required|string|max:155',
                'email' => 'required|email|unique:users,email,'.$id,
                'telefone' => 'nullable|regex:/^[0-9]{8,11}$/',
            ]);

            // Pega o usuário pelo ID e atualiza com os dados validados
            $user = User::findOrFail($id);
            $user->update($validatedData);

            // Retorna uma resposta de sucesso JSON
            return response()->json(['success' => true]);
        }
    }

    // Método para deletar usuário
    public function delete($id)
    {
        // Pega o usuário pelo ID e remove do banco
        $user = User::findOrFail($id);
        $user->delete();

        // Retorna uma resposta de sucesso JSON
        return response()->json(['success' => true]);
    }

}
