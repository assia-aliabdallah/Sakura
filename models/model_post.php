<?php
function addPost(){
    /**
     * Ajoute un post à la base de données.
     *
     * @return void Redirige l'utilisateur vers la page control_post.php du post nouvellement créé.
     */
    $db=dbConnect(); 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $title = $_POST['title'];
    $content = $_POST['content'];
    $id_user = $_SESSION['id_user'];
    $img = !empty($_POST['img']) ? $_POST['img'] : null;
    $sql = "INSERT INTO posts (title, content, id_user, img) VALUES (:title, :content, :id_user, :img)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindParam(':img', $img, PDO::PARAM_STR);
    $stmt->execute();
    header('Location: ../controllers/control_user.php?action=post&id_post='.$db->lastInsertId());
    exit();
}

function showAllPost(){
    /**
     * Récupère tous les posts de la base de données.
     *
     * @return array Tableau contenant tous les posts.
     */
    $db=dbConnect();
    $limit=3;
    $page=isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset=($page-1)*$limit;
    $sql = "SELECT posts.*, users.login FROM posts JOIN users ON posts.id_user = users.id_user JOIN users_roles ON users.id_user = users_roles.id_user WHERE users_roles.id_role = 1 ORDER BY posts.date DESC LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalPosts = $db->query("SELECT COUNT(*) FROM posts")->fetchColumn();
    $totalPages = ceil($totalPosts / $limit);

    return [$posts, $totalPages, $page];
}

function editPost(){
    /**
     * Modifie un post dans la base de données.
     *
     * @return void Redirige l'utilisateur vers la page view_post.php du post modifié.
     */
    $db=dbConnect();
    $id_post = $_POST['id_post'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $img = !empty($_POST['img']) ? $_POST['img'] : null;
    $sql = "UPDATE posts SET title = :title, content = :content, img = :img WHERE id_post = :id_post";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
    $stmt->bindParam(':img', $img, PDO::PARAM_STR);
    $stmt->execute();
    header('Location: ../controllers/control_user.php?action=post&id_post='.$id_post);
    exit();
}

function getPostById($id_post){
    /**
     * Récupère un post dans la base de données.
     *
     * @param int $id_post Identifiant du post
     * @return array Tableau contenant les informations du post
     */
    $db=dbConnect();
    $sql = "SELECT posts.*, users.login FROM posts JOIN users ON posts.id_user = users.id_user WHERE posts.id_post = :id_post";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getComments(){
    /**
     * Récupère tous les commentaires d'un post.
     *
     * @return array Tableau contenant tous les commentaires.
     */
    $db=dbConnect();
    $id_post = $_GET['id_post'];
    $sql = "SELECT comments.*, users.login FROM comments JOIN users ON comments.id_user = users.id_user WHERE id_post = :id_post";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $comments;
}

function showPost(){
    /**
     * Récupère un post dans la base de données en fonction de l'identifiant passé en paramètre de l'URL.
     *
     * @return array Tableau contenant les informations du post
     */
    if (isset($_GET['id_post']) && is_numeric($_GET['id_post'])) {
        $id_post = (int) $_GET['id_post'];
        return getPostById($id_post);
    } else {
        return null;
    }
}

function removePost(){
    /**
     * Supprime un post de la base de données.
     *
     * @return void
     */
    $db=dbConnect();
    $id_post = $_GET['id_post'];
    $sql = "DELETE FROM posts WHERE id_post = :id_post"; //DELETE ON CASCADE donc pas besoin de supprimer les commentaires
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
    $stmt->execute();
}
?>