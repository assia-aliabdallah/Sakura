 <div class='content'>
     <div class="carousel-track">
         <div class="slide slide_a">
             <div class='pfp pfp-user trigger' data-target="modal1">
                 <?php
                $pfp = getUserPFP($_SESSION['id_user']);
                ?>
                 <img src='../<?php echo $pfp; ?>' alt='Supprimer la photo  de profil'>
             </div>

             <h1><?php echo $_SESSION['login']; ?></h1>

             <?php
                    if (isset($_GET['error-pwd']) == 'invalid') {
                        echo"<div class='error-message'>";
                        echo "<p class='error-text'>L'ancien mot de passe est incorrect.</p>";
                        echo"</div>";
                    } elseif (isset($_GET['success-pwd']) == 'update') {
                        echo"<div class='success-message'>";
                        echo "<p class='success-text'>Le mot de passe a été modifié avec succès.</p>";
                        echo"</div>";
                    }

                    if (isset($_GET['error-password']) && $_GET['error-password'] == 'not-compliant') {
                        echo"<div class='error-message'>";
                        echo "<p class='error-text'>Le mot de passe doit comporter au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.</p>";
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


                    if (isset($_GET['error'])) {
                        echo "<div class='error-message'>";

                        switch ($_GET['error']) {
                            case 'invalid_extension':
                                echo "<p class='error-text'>L'extension du fichier n'est pas autorisée. Veuillez utiliser un fichier JPG, JPEG ou GIF.</p>";
                                break;

                            case 'invalid_size':
                                echo "<p class='error-text'>Le fichier est trop volumineux. La taille maximale autorisée est de 2 Mo.</p>";
                                break;

                            case 'upload_error':
                                echo "<p class='error-text'>Une erreur est survenue lors du téléversement. Veuillez réessayer.</p>";
                                break;

                            default:
                                echo "<p class='error-text'>Une erreur est survenue lors du téléversement. Veuillez réessayer.</p>";
                                break;
                        }

                        echo "</div>";
                    } elseif (isset($_GET['success'])) {
                        echo "<div class='success-message'>";
                        echo "<p class='success-text'>Le fichier a été téléversé avec succès !</p>";
                        echo "</div>";
                    }

                ?>

             <form action="/controllers/control_user.php" method="post" enctype="multipart/form-data">
                 <input type="file" name="pfp" id="pfp" required>
                 <div class="upload">
                     <input type="submit" value="Téléverser" class="upload-btn">
                     <div class="upload-icon">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-upload">
                             <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                             <polyline points="17 8 12 3 7 8"></polyline>
                             <line x1="12" y1="3" x2="12" y2="15"></line>
                         </svg>
                     </div>
                 </div>
                 <p class="txt-required">L'image doit être au format jpeg ou gif et ne doit pas dépasser 2 Mo.</p>
             </form>
         </div>
         <div class="slide slide_b">
             <h1>Paramètres</h1>
             <form action="/controllers/control_user.php?action=updateLogin" method="post">
                 <legend>Modifier son login</legend>
                 <p class="txt-required">Tous les champs du formulaire sont obligatoires.</p>

                 <label for="new-login">Nouveau login</label>
                 <input type="text" id="new-login" name="new-login" required="" title="Veuillez remplir ce champ.">

                 <input type="submit" value="Modifier">
             </form>

             <form action="/controllers/control_user.php?action=updatePWD" method="post">
                 <legend>Modifier son mot de passe</legend>
                 <p class="txt-required">Tous les champs du formulaire sont obligatoires.</p>

                 <label for="old-pwd">Ancien mot de passe</label>
                 <div class="pwd-container">
                     <input type="password" id="old-pwd" name="old-pwd" required="" title="Veuillez remplir ce champ.">
                     <div class="toggle-pwd"></div>
                 </div>

                 <label for="new-pwd">Nouveau mot de passe</label>
                 <div class="pwd-container">
                     <input type="password" id="new-pwd" name="new-pwd" required="" title="Veuillez remplir ce champ.">
                     <div class="toggle-pwd"></div>
                 </div>

                 <input type="submit" value="Modifier">
             </form>

             <form action="/controllers/control_user.php?action=deleteUser" method="post">
                 <legend>Supprimer son compte</legend>
                 <p class="txt-required">Attention, cette action est irréversible. Vous perdrez toutes vos données et
                     ne pourrez pas les
                     récupérer après suppression de votre compte.</p>
                 <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                 <input type="submit" value="Supprimer">
             </form>
         </div>
     </div>
 </div>

 <div class="aside-navigation">
     <a href="#" id="user">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-user">
             <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
             <circle cx="12" cy="7" r="4"></circle>
         </svg>
     </a>
     <?php
        if($isAdmin){
        echo "<a href='?action=add'>";
        echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-plus-square'><rect x='3' y='3' width='18' height='18' rx='2' ry='2'></rect><line x1='12' y1='8' x2='12' y2='16'></line><line x1='8' y1='12' x2='16' y2='12'></line></svg>";
        echo "</a>";
        }
        ?>
     <a href="#" id="settings">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-sliders">
             <line x1="4" y1="21" x2="4" y2="14"></line>
             <line x1="4" y1="10" x2="4" y2="3"></line>
             <line x1="12" y1="21" x2="12" y2="12"></line>
             <line x1="12" y1="8" x2="12" y2="3"></line>
             <line x1="20" y1="21" x2="20" y2="16"></line>
             <line x1="20" y1="12" x2="20" y2="3"></line>
             <line x1="1" y1="14" x2="7" y2="14"></line>
             <line x1="9" y1="8" x2="15" y2="8"></line>
             <line x1="17" y1="16" x2="23" y2="16"></line>
         </svg>
     </a>
     <form action="/controllers/control_authentification.php?action=logout" method="post">
         <button type="submit" style="background: none; border: none; cursor: pointer;">
             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-log-out">
                 <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                 <polyline points="16 17 21 12 16 7"></polyline>
                 <line x1="21" y1="12" x2="9" y2="12"></line>
             </svg>
         </button>
     </form>
 </div>
 </aside>

 <div id="modal1" class="modal">
     <div class="modal-container">
         <div class='tab'>
             <span class='cross modal-btn'>&times;</span>
             <div class='gradient'></div>
         </div>
         <div class="modal-content">
             <h2>Souhaitez-vous supprimer votre photo de profil ?</h2>
             <p>Votre photo de profil sera remplacée par l'image par défaut après suppression. Vous pourrez en ajouter
                 une nouvelle à tout moment.</p>
             <form action="/controllers/control_user.php?action=deletePFP" method="post">
                 <input type="submit" value="Supprimer">
             </form>
         </div>
     </div>
 </div>