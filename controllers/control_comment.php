<?php
require_once __DIR__ . '/../models/model_comment.php';

//Si l'utilisateur souhaite ajouter ou éditer un commentaire dans la base de données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'Envoyer') {
        if (isset($_POST['content']) && isset($_GET['id_post'])) {
            addComment(); 
            header('Location: control_user.php?action=post&id_post='.$_GET['id_post']);   
            exit();   
        }
    } 
    if (isset($_POST['action']) && $_POST['action'] == 'Modifier') {
        if (isset($_POST['content']) && isset($_POST['id_comment'])) {
            editComment();
            header('Location: control_user.php?action=post&id_post='.$_GET['id_post']);
            exit();   
        }
    }
}

//Si l'utilisateur souhaite supprimer un commentaire dans la base de données
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        if (isset($_GET['id_comment'])) {
            removeComment();
            header('Location: control_user.php?action=post&id_post='.$_GET['id_post']);
            exit();   
        }
    }
}
?>