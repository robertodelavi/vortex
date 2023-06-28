<?php
$data = new DataManipulation();

include 'library/vristo/header-main.php';
require_once 'application/script/php/functions.php';
require_once 'application/' . $_GET['module'] . '/controller/' . $_GET['module'] . '_controller.php';
include 'library/vristo/footer-main.php';
