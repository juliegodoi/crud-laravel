// Alertas personalizados usando SweetAlert2
function exibirAlerta(tipoAlerta) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-secondary"
    },
    buttonsStyling: false
  });

  let alertConfig = {};

  switch (tipoAlerta) {
    case 'success_cadastro':
      alertConfig = {
        title: "Usuário cadastrado!",
        text: "O usuário foi cadastrado com sucesso.",
        icon: "success",
        confirmButtonColor: "OK"
      };
      break;
    case 'success_atualizado':
      alertConfig = {
        title: "Usuário atualizado!",
        text: "O usuário foi atualizado com sucesso.",
        icon: "success"
      };
      break;
    case 'success_excluido':
      alertConfig = {
        title: "Usuário excluído!",
        text: "O usuário foi excluído com sucesso.",
        icon: "success"
      };
      break;
    case 'error_duplicado':
      alertConfig = {
        title: "E-mail duplicado!",
        text: "Já existe um usuário com esse e-mail cadastrado.",
        icon: "warning"
      };
      break;
    default:
      return;
  }

  swalWithBootstrapButtons.fire({
    title: alertConfig.title,
    text: alertConfig.text,
    icon: alertConfig.icon,
    confirmButtonText: "OK"
  });
}

// Verifica se tem um alerta no localStorage
if (localStorage.getItem('showAlert')) {
  // Exibe o alerta com o tipo armazenado e remove o item do localStorage
  exibirAlerta(localStorage.getItem('showAlert'));
  localStorage.removeItem('showAlert');
}

// Token CSRF para requisições AJAX
var csrfToken = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': csrfToken
  }
});

// URLs das rotas definidas
$.getJSON('/api/routes', function(routes) {

  // Evento para adicionar usuário
  $('#adicionar-form').on('submit', function(event) {
    event.preventDefault(); // Impede o comportamento padrão de envio do formulário

    $.ajax({
        url: routes.createUser,
        type: 'post',
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
              // Se a resposta for true, armazena o alerta de sucesso e recarrega a página
                localStorage.setItem('showAlert', 'success_cadastro');
                location.reload();
            } else {
              // Se for false (e-mail duplicado), armazena o alerta de aviso e recarrega a página
                localStorage.setItem('showAlert', 'error_duplicado');
                location.reload();
            }
        }
    });
  });

  // Evento para exibir os dados do usuário específico no formulário ao clicar em editar
  $(document).on('click', '.btn-editar', function() {
    const idUsuario = $(this).data('user-id'); // Pega o ID do usuário

    $.ajax({
        url: routes.updateUser.replace('dummy', idUsuario),
        type: 'get',
        success: function(data) {
          // Preenche o formulário de alteração com os dados do usuário
            $('#alterar-form input[name="id"]').val(data.id);
            $('#alterar-form input[name="nome"]').val(data.nome);
            $('#alterar-form input[name="email"]').val(data.email);
            $('#alterar-form input[name="telefone"]').val(data.telefone);
        }
    });
  });

  // Evento para alterar usuário
  $('#alterar-form').on('submit', function(event) {
    event.preventDefault();

    const idUsuario = $('#alterar-form input[name="id"]').val();

    $.ajax({
        url: routes.updateUser.replace('dummy', idUsuario),
        type: 'put',
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
              // Se a resposta for true, armazena o alerta de sucesso e recarrega a página
              localStorage.setItem('showAlert', 'success_atualizado');
                location.reload();
            } else {
              // Se for false (e-mail duplicado), armazena o alerta de aviso e recarrega a página
              localStorage.setItem('showAlert', 'error_duplicado');
                location.reload();
            }
        }
    });
  });

  // Evento para excluir usuário específico ao clicar em excluir
  $(document).on('click', '.btn-excluir', function() {
    // Pega o ID do usuário
    const idUsuario = $(this).data('user-id');

    // Exibe alerta personalizado para confirmação
    Swal.fire({
      title: "Excluir usuário",
      text: "Essa informação não poderá ser recuperada, deseja excluir mesmo assim?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#198754",
      cancelButtonColor: "#DC3545",
      confirmButtonText: "Sim",
      cancelButtonText: "Não"
    }).then((result) => {
      // Se for confimado, armazena o alerta de sucesso e recarrega a página
      if (result.isConfirmed) {
        $.ajax({
          url: routes.deleteUser.replace('dummy', idUsuario),
          type: 'delete',
          success: function() {
            localStorage.setItem('showAlert', 'success_excluido');
            location.reload();
          }
        });
      }
    });
  });

});

