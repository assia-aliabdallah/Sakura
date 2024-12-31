<section>
    <?php
if (isset($posts) && is_array($posts) && count($posts) > 0) {
    foreach ($posts as $post) {

        //Conversion de la date en français
        $date = new DateTime($post['date']);
        $jours = ['Sunday' => 'Dimanche', 'Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi', 'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi'];
        $mois = ['January' => 'Janvier', 'February' => 'Février', 'March' => 'Mars', 'April' => 'Avril', 'May' => 'Mai', 'June' => 'Juin', 'July' => 'Juillet', 'August' => 'Août', 'September' => 'Septembre', 'October' => 'Octobre', 'November' => 'Novembre', 'December' => 'Décembre'];

        //Affichage du billet
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
        echo "<a href='?action=post&id_post=" . $post['id_post'] . "' class='subtitle'>" . htmlspecialchars($post['login']) . "</a><br>";
        echo "<a href='?action=post&id_post=" . $post['id_post'] . "' class='time'>Publié le " . htmlspecialchars($jours[$date->format('l')] . ' ' . $date->format('d') . ' ' . $mois[$date->format('F')] . ' ' . $date->format('Y')) . "</a>";
        echo "</div>";
        echo "</div>";
        echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";

        if ($post['img'] != null){
            echo "<div class='img-container'>";
            echo "<img src='". $post['img'] ."' alt=''></div>";
            }

        echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
        echo "<a href='?action=post&id_post=" . $post['id_post'] . "'>Voir les commentaires</a>";
        echo "</div>";
        echo "</article>";
    }

    //Pagination
    echo "<div class='pagination'>";
    if (isset($totalPages) && $totalPages > 0) {
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                echo "<span class='current-page'>$i</span>";
            } else {
                echo "<a href='?page=$i'>$i</a>";
            }
        }
    }
    echo "</div>";
} else {

    echo "<article>";
    echo "<div class='tab'>";
    echo "<span class='cross'>&times;</span>";
    echo "<div class='gradient'></div>";
    echo "</div>";
    echo "<div class='content'>";
    echo "<h2>Aucun billet à afficher</h2>";
    echo "</div>";
    echo "</article>";

}
?>
</section>