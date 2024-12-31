<?php
function isAdmin(){
    /**
     * Vérifie si l'utilisateur est un administrateur.
     * 
     * @return bool true si l'utilisateur est un administrateur, false sinon
     */
    $db=dbConnect();
    $id_user=$_SESSION['id_user'];
    $sql = 'SELECT users_roles.id_role FROM users_roles WHERE users_roles.id_user = :id_user';
    $stmt=$db->prepare($sql);
    $stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $stmt->execute();
    $result=$stmt->fetch();
    return $result['id_role'] == '1';
}

function isUser(){
    /**
     * Vérifie si l'utilisateur est un utilisateur.
     * 
     * @return bool true si l'utilisateur est un utilisateur, false sinon
     */
    $db=dbConnect();
    $id_user=$_SESSION['id_user'];
    $sql = 'SELECT users_roles.id_role FROM users_roles WHERE users_roles.id_user = :id_user';
    $stmt=$db->prepare($sql);
    $stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $stmt->execute();
    $result=$stmt->fetch();
    return $result['id_role'] == '2';
}

function addPFP(){
    /**
     * Ajoute une photo de profil à un utilisateur.
     * 
     * @return void
     */
    $db=dbConnect();
    $id_user=$_SESSION['id_user'];

    if (isset($_FILES['pfp'])) {
        $content_dir = __DIR__ .'/../images/pfp/';
        if(isset($_FILES['pfp'])){
            $tmp_file = $_FILES['pfp']['tmp_name'];
            $name = $_FILES['pfp']['name'];
            $size = $_FILES['pfp']['size'];
            $error = $_FILES['pfp']['error'];
        }

        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));
        $maxSize = 2000000;
        $allowedExtensions = ['jpg', 'jpeg', 'gif'];

        if (!in_array($extension, $allowedExtensions)){
            header("Location: control_user.php?error=invalid_extension");
            exit;
        }
        elseif ($size > $maxSize){
            header("Location: control_user.php?error=invalid_size");
            exit;
        }
        elseif ($error != 0){
            header("Location: control_user.php?error=upload_error");
            exit;
        }
        else{
            $name = $id_user . '.' . $extension;
            if( !is_uploaded_file($tmp_file) )
            {
            header("Location: control_user.php?error=upload_error");
            exit();   
            }

            if( !move_uploaded_file($tmp_file, $content_dir . '/'  . $name) )
            {
            header("Location: control_user.php?error=upload_error");
            exit();   
            }

        $path = 'images/pfp/' . $name;
        $sql = 'UPDATE users SET pfp = :pfp WHERE id_user = :id_user';
        $stmt=$db->prepare($sql);  
        $stmt->bindParam(':pfp',$path,PDO::PARAM_STR);
        $stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
        $stmt->execute();

        header("Location: control_user.php?success=upload_success");  
    }
    }
}

function removePFP(){
    /**
     * Supprime la photo de profil d'un utilisateur.
     * 
     * @return void
     */

    $db=dbConnect();
    $id_user=$_SESSION['id_user'];

    $sql = 'SELECT pfp FROM users WHERE id_user = :id_user';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && !empty($result['pfp'])) {
        $filePath = __DIR__ . '/../' . $result['pfp'];

        if (file_exists($filePath)) {
            unlink($filePath); 
        }
    }

    $sql = 'UPDATE users SET pfp = NULL WHERE id_user = :id_user';
    $stmt=$db->prepare($sql);  
    $stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $stmt->execute();
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();    
}

function removeUser(){
    /**
     * Supprime un utilisateur de la base de données.
     * 
     * @return void
     */
    $db=dbConnect();
    $id_user=$_SESSION['id_user'];

    $sql = 'SELECT pfp FROM users WHERE id_user = :id_user';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && !empty($result['pfp'])) {
        $filePath = __DIR__ . '/../' . $result['pfp'];

        if (file_exists($filePath)) {
            unlink($filePath); 
        }
    }

    $sql = 'DELETE FROM posts WHERE id_user = :id_user';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    $sql = 'DELETE FROM comments WHERE id_user = :id_user';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

   $sql = 'DELETE FROM users_roles WHERE id_user = :id_user';
   $stmt = $db->prepare($sql);
   $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
   $stmt->execute();

   $sql = 'DELETE FROM users WHERE id_user = :id_user';
   $stmt = $db->prepare($sql);
   $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
   $stmt->execute();

   session_start();
   $SESSION=array();
   session_destroy();

    header("Location: ../index.php?success-user=delete");
    exit();
}

function getUserPFP($id_user = null) {
    /**
     * Récupère le chemin de la photo de profil d'un utilisateur.
     * 
     * @param int|null $id_user Identifiant de l'utilisateur
     * @return string Chemin de la photo de profil
     */

    $db = dbConnect();
    $path = 'images/sakura_logo.svg';
    if ($id_user !== null){
    $sql = "SELECT pfp FROM users WHERE id_user = :id_user";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && !empty($user['pfp'])) {
        $path = $user['pfp'];
    }
    }
    return $path;
}

function changePassword(){
    /**
    * Fonction pour changer le mot de passe d'un utilisateur
    * 
    * @return void
    */

    $db = dbConnect();
    $id_user = $_SESSION['id_user'];
    $old_pwd = $_POST['old-pwd'];
    $new_pwd = $_POST['new-pwd'];

    if (empty($new_pwd) || strlen($new_pwd) < 8 || !preg_match('/[a-z]/', $new_pwd) || !preg_match('/[A-Z]/', $new_pwd) || !preg_match('/[0-9]/', $new_pwd) || !preg_match('/[\W_]/', $new_pwd)) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        $newUrl = (strpos($previousPage, 'error-password=not-compliant') === false) 
            ? $previousPage . ((strpos($previousPage, '?') === false) ? '?' : '&') . "error-password=not-compliant" 
            : $previousPage;
        header("Location: $newUrl");
        exit();
    }

    $sql = 'SELECT pwd FROM users WHERE id_user = :id_user';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($old_pwd, $user['pwd'])) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        $newUrl = (strpos($previousPage, 'error-pwd=invalid') === false) 
            ? $previousPage . ((strpos($previousPage, '?') === false) ? '?' : '&') . "error-pwd=invalid" 
            : $previousPage;
        header("Location: $newUrl");
        exit();
    }

    $new_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);

    $sql = 'UPDATE users SET pwd = :new_pwd WHERE id_user = :id_user';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':new_pwd', $new_pwd, PDO::PARAM_STR);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    $previousPage = $_SERVER['HTTP_REFERER'];
    $newUrl = (strpos($previousPage, 'success-pwd=update') === false) 
        ? $previousPage . ((strpos($previousPage, '?') === false) ? '?' : '&') . "success-pwd=update" 
        : $previousPage;
    header("Location: $newUrl");
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

function changeLogin(){
    /**
     * Fonction pour changer le login d'un utilisateur
     * 
     * @return void
     */

    $db=dbConnect();
    $id_user=$_SESSION['id_user'];
    $new_login=$_POST['new-login'];

    if (empty($new_login) || strlen($new_login) < 5 || strlen($new_login) > 20 || !preg_match('/^[a-zA-Z0-9-_]+$/', $new_login)) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        $newUrl = (strpos($previousPage, 'error-login=not-compliant') === false) 
            ? $previousPage . ((strpos($previousPage, '?') === false) ? '?' : '&') . "error-login=not-compliant" 
            : $previousPage;
        header("Location: $newUrl");
        exit();
    }

    elseif (loginAlreadyExist($new_login)) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        $newUrl = (strpos($previousPage, 'error-login=invalid') === false) 
            ? $previousPage . ((strpos($previousPage, '?') === false) ? '?' : '&') . "error-login=invalid" 
            : $previousPage;
        header("Location: $newUrl");
        exit();
    }

    $sql = 'UPDATE users SET login = :new_login WHERE id_user = :id_user';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindParam(':new_login', $new_login, PDO::PARAM_STR);
    $stmt->execute();

    $_SESSION['login'] = $new_login; 

    $previousPage = $_SERVER['HTTP_REFERER'];
    $newUrl = (strpos($previousPage, 'success-login=update') === false) 
        ? $previousPage . ((strpos($previousPage, '?') === false) ? '?' : '&') . "success-login=update" 
        : $previousPage;
    header("Location: $newUrl");
    exit();
}
?>