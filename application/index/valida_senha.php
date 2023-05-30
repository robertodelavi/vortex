<?php
include 'library/vristo/header-main-auth.php';
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
        $idSession = $_POST['wf_idSession'];

        $login = new Login();
        $login->table = 'usuario';

        //echo $idSession;
        $result = $login->validateUser(array('usu_login' => $user, 'usu_senha' => $pass), $idSession);
        if ($result['login'] == 'Logado') {
            /*$sql = 'INSERT INTO usuario_acesso(usu_codigo) VALUES ('.$_SESSION['wf_userId'].')';
        	$data->executaSQL($sql);*/

            switch ($_SESSION['wf_userPermissao']) {
                case 1: //administrador
                    echo "<meta http-equiv='refresh' content='1;URL=?module=principal&acao=lista_principal'>";
                    break;
                case 2: //Vendas
                    echo "<meta http-equiv='refresh' content='1;URL=?module=principal&acao=lista_principal'>";
                    break;
                case 3: //Aux. ADM
                    echo "<meta http-equiv='refresh' content='1;URL=?module=principal&acao=lista_principal'>";
                    break;
                case 4: //Produtção
                    echo "<meta http-equiv='refresh' content='1;URL=?module=principal&acao=lista_principal'>";
                    break;
                case 5: //Almoxarifado
                case 6:
                case 7:
                case 8:
                case 10:
                    echo "<meta http-equiv='refresh' content='1;URL=?module=principal&acao=lista_principal'>";
                    break;
                case 9:
                    echo "<meta http-equiv='refresh' content='1;URL=?module=principal&acao=listacliente_principal'>";
                    break;
            }
        } else {
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