<?php 
include '../database/connection.php';
include 'authentication.class.php';

$urlLogin = '../auth/cover-login.php';

// Inicia a sessão
// session_start();

// Verifica se recebeu os dados do formulário de login com method post
if (isset($_POST['login']) && isset($_POST['senha'])) {

    // Criando uma instância da classe Auth com usuário e senha
    $auth = new Auth($_POST['login'], $_POST['senha'], $db);

    // Fazendo login
    if ($auth->login()) {
        // Inicia a sessão e armazena o ID do usuário
        $_SESSION['user_id'] = $auth->getUserID();
        header('Location: '.BASE_THEME_URL);
        exit();
    } else {
        header('Location: '.$urlLogin.'?error=invalidlogin');
        exit();
    }

} else if (isset($_GET['error']) && $_GET['error'] == 'invalidlogin') {
    // Verifica se houve erro de login e exibe mensagem correspondente
    echo "Usuário ou senha inválidos.";
    // Destrói a sessão do usuário
    session_destroy();
}
