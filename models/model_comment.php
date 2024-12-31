<?php
function addComment(){
    /**
     * Ajoute un commentaire à la base de données.
     *
     * @return void
     */
    $db=dbConnect(); 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $content = $_POST['content'];
    $id_post = $_GET['id_post'];
    $id_user = $_SESSION['id_user'];
    $sql = "INSERT INTO comments (content, id_post, id_user) VALUES (:content, :id_post, :id_user)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
}

function editComment(){
    /**
     * Modifie un commentaire dans la base de données.
     *
     * @return void
     */
    $db=dbConnect();
    $id_comment = $_POST['id_comment'];
    $content = $_POST['content'];
    $sql = "UPDATE comments SET content = :content WHERE id_comment = :id_comment";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
    $stmt->execute();
}

function removeComment(){
    /**
     * Supprime un commentaire de la base de données.
     *
     * @return void
     */
    $db=dbConnect();
    $id_comment = $_GET['id_comment'];

    $sql = "DELETE FROM comments WHERE id_comment = :id_comment";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
    $stmt->execute();
}
?>