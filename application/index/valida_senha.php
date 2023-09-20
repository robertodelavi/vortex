<?php
include 'library/vristo/header-main-auth.php';
include 'library/DataManipulation.php';
$data = new DataManipulation();
?>

<!-- Loading -->
<div class="flex justify-center items-center h-screen">
    <div class="flex flex-col items-center">
        <span class="animate-spin border-4 border-primary border-l-transparent rounded-full w-12 h-12 mb-5"></span>
        <p class="text-white-dark">Estamos preparando tudo para você...</p>
    </div>
</div>

<?php
session_start();

class Valida_SenhaCommand implements Command
{
    public function execute()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $user = addslashes($_POST['usuario']);
        $pass = addslashes($_POST['senha']);
        $postSession = $_POST['postSession'];

        $login = new Login();
        $login->tableAuth = 'sisusuarios';
        $login->table = 'sisusuarios';

        // Autentica usuário
        $resultAuth = $login->authenticateUser(array('usu_email' => $user, 'usu_senha' => $pass), $postSession);
        if($resultAuth['login'] == 'Autenticado' && $resultAuth['emp_bd'] != null){
            // Loga usuário
            $result = $login->validateUser(
                array(
                    'emp_bd'      => $resultAuth['emp_bd'], 
                    'emp_bd_host' => $resultAuth['emp_bd_host'], 
                    'emp_bd_user' => $resultAuth['emp_bd_user'], 
                    'emp_bd_pass' => $resultAuth['emp_bd_pass'], 
                    'emp_nome'    => $resultAuth['emp_nome'], 
                    'emp_cidade'  => $resultAuth['emp_cidade'], 
                    'emp_estado'  => $resultAuth['emp_estado']
                ), 
                array(
                    'usu_email' => $user
                    // , 
                    // 'usu_senha' => $pass
                ), $postSession);
                
            if ($result['login'] == 'Logado') {
                //* Logado com sucesso    
                echo "<meta http-equiv='refresh' content='1;URL=?module=home'>";
            } else {
                echo "<meta http-equiv='refresh' content='0;URL=?module=index&erro=2'>";
            }
        }else{
            // Erro ao autenticar usuário
            echo "<meta http-equiv='refresh' content='0;URL=?module=index&erro=1'>";
        }
    }
}
?>
<style>
    .h-screen {
        height: 100vh;
    }
</style>
</body>

</html>

<?php
include 'library/vristo/footer-main-auth.php';
?>