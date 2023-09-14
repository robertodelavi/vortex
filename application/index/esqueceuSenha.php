<?php
    include '../../library/vristo/header-main-auth.php';
            
?>

<div class="flex min-h-screen">
    <div class="bg-gradient-to-t from-[#ff1361bf] to-[#44107A] w-1/2  min-h-screen hidden lg:flex flex-col items-center justify-center text-white dark:text-black p-4">
        <div class="w-full mx-auto mb-5"><img src="<?php echo BASE_THEME_URL; ?>/assets/images/auth-cover.svg" alt="coming_soon" class="lg:max-w-[370px] xl:max-w-[500px] mx-auto" /></div>
        <h3 class="text-3xl font-bold mb-4 text-center">Join the community of expert developers</h3>
        <p>It is easy to setup with great customer experience. Start your 7-day free trial</p>
    </div>
    <div class="w-full lg:w-1/2 relative flex justify-center items-center ">
        <div class="max-w-[480px] p-5 md:p-10 w-full">
            <h2 class="font-bold text-3xl mb-3 text-white-dark">Redefinir Senha</h2>
            <p class="mb-7 text-white-dark">Informe seu e-mail pra redefinir sua senha</p>
            <form class="space-y-5" @submit.prevent="window.location='/'">
                <div>
                    <label for="email" class="text-white-dark">E-mail</label>
                    <input id="email" type="email" class="form-input" placeholder="Seu E-mail" />
                </div>
                <button type="submit" class="btn btn-primary w-full">Redefinir</button>
            </form>
            <p class="text-center text-white-dark mt-6">Acessar sua conta ? <a href="<?php echo BASE_URL; ?>" class="text-primary font-bold hover:underline">Acessar</a></p>
        </div>
    </div>
</div>

<?php     
    include '../../library/vristo/footer-main-auth.php'; 
?>
    