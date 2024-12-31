<?php
require_once __DIR__ . '/../models/model_user.php';
include_once __DIR__ .'/../views/view_header.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['pfp'])) {
        addPFP();
    }
    if (isset($_GET['action']) && $_GET['action'] == 'deletePFP') {
        removePFP();
    }
    if (isset($_GET['action']) && $_GET['action'] == 'deleteUser') {
        removeUser();
    }
    if (isset($_GET['action']) && $_GET['action'] == 'updatePWD') {
        changePassword();
    }
    if (isset($_GET['action']) && $_GET['action'] == 'updateLogin') {
        changeLogin();
    }
}

if (isset($_SESSION["id_user"])){
    $isUser = isUser();
    $isAdmin = isAdmin();


    include_once __DIR__ . '/../views/view_user.php';
    include_once __DIR__ . '/control_post.php';

    }

else{  
    
    $isUser = false;
    $isAdmin = false;

    include __DIR__ .'/../views/view_authentification.php';
    
    echo "<section>";
    echo "<article>";
    echo "<div class='tab'>";
    echo "<span class='cross'>&times;</span>";
    echo "<div class='gradient'></div>";
    echo "</div>";
    echo "<div class='content'>";
    echo "<h2>Vous devez être logué pour accéder à cette ressource !</h2>";
    echo "</div>";
    echo "</article>";
    echo "</section>";
}


include __DIR__ .'/../views/view_footer.php';
?>