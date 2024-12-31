<?php
function traitelogin(){
    /**
     * Vérifie les informations de connexion de l'utilisateur et le connecte s'il est inscrit.
     *
     * @return void Redirige l'utilisateur vers la page view_user.php quand l'utilisateur est connecté ou vers la page de connexion avec un message d'erreur.
     */
    $db=dbConnect();
    $login = $_POST['login'];
    $pwd = $_POST['pwd'];
    $sql = "SELECT * FROM users WHERE login = :login";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':login', $_POST["login"], PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user || !password_verify($pwd, $user['pwd'])) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        $newUrl = (strpos($previousPage, 'error=invalid') === false) 
            ? $previousPage . ((strpos($previousPage, '?') === false) ? '?' : '&') . "error=invalid" 
            : $previousPage;
        header("Location: $newUrl");
        exit();
    }
    
    $_SESSION["id_user"] = $user['id_user'];
    $_SESSION["login"] = $user['login'];
    header("Location: ../controllers/control_user.php");
    exit();
}

if (!function_exists('loginAlreadyExist')) {
    function loginAlreadyExist($login){
    /**
     * Vérifie si un login existe déjà dans la base de données.
     * 
     * return bool true si le login existe déjà, false sinon.
     */

    $db = dbConnect();
    $sql = 'SELECT COUNT(*) FROM users WHERE LOWER(login) = LOWER(:login)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        return true;
    }
    return false;
    }
}

function traiteinscription(){
    /**
     * Ajoute un utilisateur à la base de données.
     *
     * @return void Redirige l'utilisateur vers la page view_user.php quand l'utilisateur est inscrit.
     */
    $db=dbConnect();
    $login = $_POST['log-reg'];
    $pwd = $_POST['pwd-reg'];
    $mdp = password_hash($pwd, PASSWORD_DEFAULT);

    if (empty($login) || strlen($login) < 5 || strlen($login) > 20 || !preg_match('/^[a-zA-Z0-9-_]+$/', $login)) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        $newUrl = (strpos($previousPage, 'error-login=not-compliant') === false) 
            ? $previousPage . ((strpos($previousPage, '?') === false) ? '?' : '&') . "error-login=not-compliant" 
            : $previousPage;
        header("Location: $newUrl");
        exit();
    }

    elseif (empty($pwd) || strlen($pwd) < 8 || !preg_match('/[a-z]/', $pwd) || !preg_match('/[A-Z]/', $pwd) || !preg_match('/[0-9]/', $pwd) || !preg_match('/[\W_]/', $pwd)) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        $newUrl = (strpos($previousPage, 'error-password=not-compliant') === false) 
            ? $previousPage . ((strpos($previousPage, '?') === false) ? '?' : '&') . "error-password=not-compliant" 
            : $previousPage;
        header("Location: $newUrl");
        exit();
    }
    

    elseif (loginAlreadyExist($login)) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        $newUrl = (strpos($previousPage, 'error-login=invalid') === false) 
            ? $previousPage . ((strpos($previousPage, '?') === false) ? '?' : '&') . "error-login=invalid" 
            : $previousPage;
        header("Location: $newUrl");
        exit();
    }

    try {
        $db->beginTransaction();
        $sql = "INSERT INTO users (login, pwd) VALUES (:login, :mdp)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $stmt->execute();

        $user_id = $db->lastInsertId();

        $sql1 = "INSERT INTO users_roles (id_user, id_role) VALUES (:id_user, 2)";
        $stmt1 = $db->prepare($sql1); 
        $stmt1->bindParam(':id_user', $user_id, PDO::PARAM_INT);
        $stmt1->execute();

        $db->commit();
    }
    catch (Exception $e) {
        $db->rollBack();
        echo "Failed: " . $e->getMessage();
    }

    $sql = "SELECT * FROM users WHERE login = :login";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
            $_SESSION["id_user"] = $user['id_user'];
            $_SESSION["login"] = $user['login'];
            header("Location: ../controllers/control_user.php");
            exit();   
    }
}

function deconnexion(){
    /**
     * Déconnecte l'utilisateur.
     *
     * @return void
     */
    session_start();
    $SESSION=array();
    session_destroy();
}
?>