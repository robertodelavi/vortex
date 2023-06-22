<?php 
    include 'authentication/authentication.class.php';
?>

<header :class="{'dark' : $store.app.semidark && $store.app.menu === 'horizontal'}">
    <div class="shadow-sm">
        <?php include 'application/incs/topBar.php' ?>
        <!-- horizontal menu -->
        <?php include 'application/incs/menuHorizontal.php' ?>        
    </div>
</header>
