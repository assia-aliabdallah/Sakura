<?php
if (isset($post) && is_array($post)) {
    
    //Conversion de la date en français
    $date = new DateTime($post['date']);
    $jours = ['Sunday' => 'Dimanche', 'Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi', 'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi'];
    $mois = ['January' => 'Janvier', 'February' => 'Février', 'March' => 'Mars', 'April' => 'Avril', 'May' => 'Mai', 'June' => 'Juin', 'July' => 'Juillet', 'August' => 'Août', 'September' => 'Septembre', 'October' => 'Octobre', 'November' => 'Novembre', 'December' => 'Décembre'];

    //Affichage du billet
    echo "<section>";
    echo "<article>";
    echo "<div class='tab'>";
    echo "<span class='cross'>&times;</span>";
    echo "<div class='gradient'></div>";
    echo "</div>";
    echo "<div class='content'>";
    echo "<div class='top-info'>";
    echo "<div class='pfp'>";
    if (isset($_SESSION["id_user"])){
        $pfp = getUserPFP($post['id_user']);
        echo "<img src='../".$pfp."' alt=''>";
    } else {
        $pfp = getUserPFP($post['id_user']);
        echo "<img src='./".$pfp."' alt=''>";
    }
    echo "</div>";
    echo "<div>";
    echo "<span class='subtitle'>" . htmlspecialchars($post['login']) . "</span><br>";
    echo "<span>Publié le " . htmlspecialchars($jours[$date->format('l')] . ' ' . $date->format('d') . ' ' . $mois[$date->format('F')] . ' ' . $date->format('Y')) . "</span>";
    echo "</div>";
    echo "</div>";
    echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";

    if ($post['img'] != null){
    echo "<div class='img-container'>";
    echo "<img src='". $post['img'] ."' alt=''></div>";
    }
    
    echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
    if($isAdmin){
        echo "<a href='/controllers/control_user.php?action=edit&id_post=". $post['id_post'] ."'>Éditer </a>";
        echo "<a href='/controllers/control_post.php?action=delete&id_post=". $post['id_post'] ."'>Supprimer</a>";
        }
    echo "</div>";
    echo "</article>";

    //Affichage des commentaires du billet
    $commentCount = count($comments);
    echo "<div class='comments'>";
    echo "<h2>". $commentCount ." Commentaires</h2>";
    echo "<div class='comment'>";
    if (isset($comments) && is_array($comments)) {
        foreach ($comments as $comment) {
            echo "<div class='top-info'>";
            
                echo "<div class='pfp'>";
           

           if (isset($_SESSION["id_user"])){
                $pfp = getUserPFP($comment['id_user']);
                echo "<img src='../".$pfp."' alt=''>";
            }
            else {
                $pfp = getUserPFP($comment['id_user']);
                echo "<img src='./".$pfp."' alt=''>";
            }
            echo "</div>";
            echo "<div>";
            echo "<span class='subtitle'>" . htmlspecialchars($comment['login']) . "</span><br>";


            echo "<span>"  . htmlspecialchars(date('d.m.Y H:i', strtotime($comment['date']))) . "</span>";
            echo "<p>" . nl2br(htmlspecialchars($comment['content'])) . "</p>";
            if (($isUser && $comment['id_user'] == $_SESSION["id_user"]) || $isAdmin) {
            echo "<a href='/controllers/control_user.php?action=post&id_post=". $post['id_post'] . "&id_comment=". $comment['id_comment'] ."'>Éditer </a>";
            echo "<a href='/controllers/control_comment.php?action=delete&id_post=". $post['id_post'] . "&id_comment=". $comment['id_comment'] ."'>Supprimer</a>";
            }
            echo "</div>";
            echo "</div>";
        }
    }

    $content = "";
    $isEdit = false;
    if (isset($_GET['id_comment'])) {
        $isEdit = true;
        foreach ($comments as $comment) {
            if ($comment['id_comment'] == $_GET['id_comment']) {
                $content = htmlspecialchars($comment['content']);
                break;
            }
        }
    }

    echo "</div>";
    if ($isUser || $isAdmin){
    echo "<form class='form-comment' action='/controllers/control_comment.php?id_post=". $post['id_post'] . "' method='post'>";
    echo "<label for='content'>Laisser un commentaire</label>";
    echo "<textarea id='content' name='content' rows='2' cols='50' required>" 
    . $content. "</textarea>";
    if ($isEdit==false){
        echo "<input type='submit' name='action' value='Envoyer'>";
    }
    else {
        echo "<input type='hidden' name='id_comment' value='". $_GET['id_comment'] ."'>";
        echo "<input type='submit' name='action' value='Envoyer'>";
        echo "<input type='submit' name='action' value='Modifier'>";
    }
    echo "</form>";
    }
    echo "</div>";
    echo "</section>";
}
?>