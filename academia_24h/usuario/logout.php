<?php
// Arquivo responsável por terminar as sessões de navegação de forma segura
if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
}

session_unset();  
session_destroy();
// Encaminha o utilizador expulso de volta para a tela de login inicial
header("Location: login.php");
exit;
?>