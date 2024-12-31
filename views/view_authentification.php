<div class='content'>
    <div class="carousel-track">
        <div class=" slide slide_a">
            <div class="pfp">
                <?php
                    $url = $_SERVER['REQUEST_URI'];
                    if (strpos($url, 'controllers') !== false) {
                        echo "<img src='../images/sakura_logo.svg' alt=''>";
                    } else {
                        echo "<img src='./images/sakura_logo.svg' alt=''>";
                    }
                    ?>
            </div>
            <h1>Sakura</h1>
            <?php
                if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
                        echo"<div class='error-message'>";
                        echo "<p class='error-text'>Le mot de passe ou le login est incorrect.</p>";
                        echo"</div>";
                    }

                if (isset($_GET['error-password']) && $_GET['error-password'] == 'not-compliant') {
                    echo"<div class='error-message'>";
                    echo "<p class='error-text'>Le mot de passe doit comporter au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.</p>";
                    echo"</div>";
                }

                if (isset($_GET['success-user']) == 'delete') {
                    echo"<div class='success-message'>";
                    echo "<p class='success-text'>Le compte a bien été supprimé.</p>";
                    echo"</div>";
                }

                if (isset($_GET['error-login'])) {
                    echo "<div class='error-message'>";
                    switch ($_GET['error-login']) {

                        case 'invalid':
                            echo "<p class='error-text'>Le login est déjà utilisé.</p>";
                            break;
                        case 'not-compliant':
                            echo "<p class='error-text'>Le login doit être rempli, comporter entre 5 et 20 caractères, et ne contenir que des lettres, chiffres, tirets ou underscores.</p>";
                            break;
                        }
                        echo "</div>";

                } elseif (isset($_GET['success-login'])) {
                    echo "<div class='success-message'>";
                    switch ($_GET['success-login']) {
                        case 'update':
                            echo "<p class='success-text'>Le login a été modifié avec succès.</p>";
                            break;
                    }
                    echo "</div>";
                }
                ?>
            <form action="/controllers/control_authentification.php?action=login" method="post">
                <legend>Connexion</legend>
                <p class="txt-required">Tous les champs du formulaire sont obligatoires.</p>
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required title="Veuillez remplir ce champ.">

                <!-- mot de passe avec oeil pour cacher !-->
                <label for="mot_de_passe">Mot de passe</label>
                <div class="pwd-container">
                    <input type="password" id="pwd" name="pwd" required title="Veuillez remplir ce champ.">
                    <div class="toggle-pwd"></div>
                </div>

                <input type="submit" value="Connexion">
            </form>

            <form action="/controllers/control_authentification.php?action=signup" method="post">
                <legend>Inscription</legend>
                <p class="txt-required">Tous les champs du formulaire sont obligatoires.</p>
                <label for="log-reg">Login</label>
                <input type="text" id="log-reg" name="log-reg" required title="Veuillez remplir ce champ.">

                <label for="pwd-reg">Mot de passe</label>
                <div class="pwd-container">
                    <input type="password" id="pwd-reg" name="pwd-reg" required title="Veuillez remplir ce champ.">
                    <div class="toggle-pwd"></div>
                </div>

                <input type="submit" value="Inscription">
            </form>
        </div>
    </div>
</div>
</aside>