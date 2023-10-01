<?php
    include 'library/vristo/header-main-auth.php';
    class IndexCommand implements Command {
    
    public function execute() {
        if($_GET['acao'] == 'logout'){
            require_once 'application/index/logout.inc.php';
        }		        
        $randon = md5(uniqid(time()));
?>

<div class="flex min-h-screen">
    <div class="w-1/2  min-h-screen hidden lg:flex flex-col items-center justify-center text-white dark:text-black p-4" style="background-image: url('application/images/bg-login.avif'); background-size: cover; background-position: center;">
        <div class="w-full mx-auto mb-12"><img src="application/images/logo-vortex-preta.png" alt="coming_soon" class="lg:max-w-[370px] xl:max-w-[500px] mx-auto" /></div>
        
    </div>
    <div class="w-full lg:w-1/2 relative flex justify-center items-center">
        <div class="max-w-[480px] p-5 md:p-10">
            <h2 class="font-bold text-3xl mb-3 text-white-dark">Entrar</h2>
            <p class="mb-7 text-white-dark">Entre com o seu e-mail e senha pra acessar</p>
            <form class="space-y-5" method="POST" action="?module=index&action=valida_senha" >
                <input type="hidden" name="postSession" value="<?php echo $randon; ?>" />

                <div>
                    <label for="email" class="text-white-dark">E-mail</label>
                    <input name="usuario" id="email" type="text" class="form-input" placeholder="Enter Email" />
                </div>
                <div>
                    <label for="password" class="text-white-dark">Senha</label>
                    <input name="senha" id="password" type="password" class="form-input" placeholder="Enter Password" />
                </div>
                <div>
                    <label class="cursor-pointer">
                        <input type="checkbox" class="form-checkbox" />
                        <span class="text-white-dark">Lembrar de mim</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary w-full">Entrar</button>
            </form>
            <div class="relative my-7 h-5 text-center before:w-full before:h-[1px] before:absolute before:inset-0 before:m-auto before:bg-[#ebedf2]  dark:before:bg-[#253b5c]">
                <div class="font-bold text-white-dark bg-[#fafafa] dark:bg-[#060818] px-2 relative z-[1] inline-block"> </div>
            </div>
            
            <p class="text-center text-white-dark">Esqueceu sua senha ? <a href="application/index/esqueceuSenha.php" class="text-primary font-bold hover:underline">Redefinir</a></p>
        </div>
    </div>
</div>

<?php
        }
    }
    include 'library/vristo/footer-main-auth.php'; 
?>
    