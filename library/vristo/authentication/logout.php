<?php
include '../database/connection.php';
include 'authentication.class.php';

$auth = new Auth(null, null, $db);
$auth->logout();

header('Location: ' . BASE_THEME_URL . '/auth/cover-login.php');
exit();
