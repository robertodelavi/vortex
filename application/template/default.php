<?php
include 'library/vristo/header-main.php';
include 'application/incs/validateUser.inc.php';
require_once 'application/' . $_GET['module'] . '/controller/' . $_GET['module'] . '_controller.php';
include 'library/vristo/footer-main.php';

// JavaScript
echo '<script src="application/script/js/system.js"></script>';