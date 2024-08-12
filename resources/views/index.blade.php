<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD LARAVEL</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">
  <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
</head>
<body class="d-flex flex-column min-vh-100 bg-secondary-subtle">
  <nav class="navbar navbar-light bg-light border-bottom border-secondary-subtle">
    <div class="container">
      <a class="navbar-brand fs-3" href="#">CRUD</a>
      <div class="d-flex align-items-center">
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-3"></i>
            Admin
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
            <li>
              <a class="dropdown-item" href="#">
                Sair
                <i class="bi bi-power"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow">
          <div class="card-header text-dark">
            <h4 class="mb-0">Usuários</h4>
            <p class="mb-0">Listagem de Usuários</p>
          </div>
          <div class="card-body p-5 pt-4">
            <div class="d-flex justify-content-start mb-3">
              <button class="btn btn-success focus-ring focus-ring-success text-uppercase" data-bs-toggle="modal" data-bs-target="#adicionarUsuarioModal" title="Cadastrar"><i class="bi bi-plus-lg"></i> Novo usuário</button>
            </div>
            <!-- Tabela de Usuários -->
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($users->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">Nenhum registro encontrado.</td>
                    </tr>
                  @else
                    @foreach ($users as $user)
                    <tr>
                      <td>{{$user->nome}}</td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->telefone}}</td>
                      <td>
                        <button class='btn btn-secondary focus-ring focus-ring-secondary btn-sm btn-editar' title='Editar' data-user-id="{{ $user->id }}" data-bs-toggle='modal' data-bs-target='#alterarUsuarioModal'> <i class='bi bi-pencil-fill'></i> </button>
                        <button class='btn btn-danger focus-ring focus-ring-danger btn-sm mt-1 mt-md-0 btn-excluir' title='Excluir' data-user-id="{{ $user->id }}"> <i class='bi bi-trash-fill'></i> </button>
                      </td>
                    </tr>
                    @endforeach
                  @endif
                <tbody>
              </table>
              <!-- Paginação -->
              <div class="pe-2">
                {{ $users->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Adicionar Usuário -->
  <div class="modal fade" id="adicionarUsuarioModal" tabindex="-1" aria-labelledby="adicionarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title mx-auto text-capitalize" id="adicionarUsuarioModalLabel">adicionar usuário</h5>
        </div>
        <div class="modal-body">
          <form id="adicionar-form">
            @csrf
            <div class="mb-3">
              <label class="form-label">Nome</label>
              <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" placeholder="Digite o nome" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Digite o email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Telefone</label>
              <input type="text" name="telefone" class="form-control" pattern="[0-9]{8,11}" value="{{ old('telefone') }}" placeholder="Digite o telefone">
              <small class="text-secondary">(Somente números de 8 a 11 digitos)</small>
            </div>
            <div class="d-flex justify-content-end gap-2">
              <button type="button" class="btn btn-secondary focus-ring focus-ring-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary focus-ring focus-ring-primary">Cadastrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Alterar Usuário -->
  <div class="modal fade" id="alterarUsuarioModal" tabindex="-1" aria-labelledby="alterarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title mx-auto text-capitalize" id="alterarUsuarioModalLabel">alterar usuário</h5>
        </div>
        <div class="modal-body">
          <form id="alterar-form">
            <input type="hidden" name="id" id="user-id">
            <div class="mb-3">
              <label class="form-label">Nome</label>
              <input type="text" name="nome" class="form-control" placeholder="Digite o nome" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" placeholder="Digite o email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Telefone</label>
              <input type="text" name="telefone" class="form-control" pattern="[0-9]{8,11}" placeholder="Digite o telefone">
              <small class="text-secondary">(Somente números de 8 a 11 digitos)</small>
            </div>
            <div class="d-flex justify-content-end gap-2">
              <button type="button" class="btn btn-secondary focus-ring focus-ring-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary focus-ring focus-ring-primary">Alterar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <footer class="container mt-auto container text-center pb-4 pt-2">
    <hr class="border border-secondary-subtle opacity-50">
    <p class="text-body-tertiary mb-0"> &copy; <a href="https://github.com/juliegodoi" class="text-decoration-none">juliegodoi</a> 2024 </p>
  </footer>

  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>