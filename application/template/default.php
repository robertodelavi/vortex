<?php
$data = new DataManipulation();

echo '<p style="color: #FFF;">'.var_dump($_SESSION).'</p>';

include 'library/vristo/header-main.php';
require_once 'application/script/php/functions.php';
require_once 'application/' . $_GET['module'] . '/controller/' . $_GET['module'] . '_controller.php';
include 'library/vristo/footer-main.php';
