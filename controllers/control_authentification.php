<?php
session_start();
require_once __DIR__ .'/../models/model_authentification.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Si l'action est login
    if (isset($_GET['action']) && $_GET['action'] == 'login'){
        if (isset($_POST['login']) && isset($_POST['pwd'])) {
            traitelogin();
        }
    }

    // Si l'action est signup
    elseif (isset($_GET['action']) && $_GET['action'] == 'signup') {
        if (isset($_POST['log-reg']) && isset($_POST['pwd-reg'])) {
            traiteinscription();
            
        }
    }

    //Si l'action est logout
    elseif (isset($_GET['action']) && $_GET['action'] == 'logout'){
        deconnexion();
        header('location:../index.php');
        exit();   
    }
}
?>