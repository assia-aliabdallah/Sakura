<?php
require_once __DIR__ . '/../models/model_post.php';

//Si l'utilisateur souhaite ajouter ou éditer un post dans la base de données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action']) && $_GET['action'] == 'addPost') {
        if (isset($_POST['title']) && isset($_POST['content'])) {
            addPost();
        }
    } 
    if (isset($_GET['action']) && $_GET['action'] == 'editPost') {
        if (isset($_POST['title']) && isset($_POST['content'])) {
            editPost();
        }
    }
}

list($posts, $totalPages, $page) = showAllPost();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Si l'utilisateur souhaite ajouter un post
    if (isset($_GET['action']) && $_GET['action'] == 'add') {
        include __DIR__ . '/../views/view_edit.php';
    }

    //Si l'utilisateur souhaite afficher un post
    elseif (isset($_GET['action']) && $_GET['action'] == 'post') {
        $post = showPost();
        $comments = getComments();
        if ($post) {
            include __DIR__ . '/../views/view_post.php';
        }
    }

    //Si l'utilisateur souhaite éditer un post
    elseif (isset($_GET['action']) && $_GET['action'] == 'edit') {
        if (isset( $_GET['id_post'])) {
            $post = showPost();
        }
        if ($post) {
            include __DIR__ . '/../views/view_edit.php';
        }
    }

    //Si l'utilisateur souhaite supprimer un post
    elseif (isset($_GET['action']) && $_GET['action'] == 'delete') {
        if (isset($_GET['id_post'])) {
            removePost();
            header('Location: control_user.php');
            exit();
        }
    }

    else{
        include __DIR__ . '/../views/view_allPost.php';
    }
}
?>