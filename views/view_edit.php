<section>
    <article>
        <div class='tab'>
            <span class='cross'>&times;</span>
            <div class='gradient'></div>
        </div>
        <div class='content'>
            <h2><?php echo isset($post['id_post']) ? 'Modifier' : 'Créer'; ?> un billet</h2>
            <form
                action="/controllers/control_post.php?action=<?php echo isset($post['id_post']) ? 'editPost' : 'addPost'; ?>"
                method="post">
                <p class="txt-required">Tous les champs marqués d'une astérisque (*) sont obligatoires.</p>

                <label for="title">Titre*</label>
                <input type="text" name="title" id="title"
                    value="<?php echo isset($post['title']) ? $post['title'] : ''; ?>" required>

                <label for="content">Contenu*</label>
                <textarea name="content" id="content" rows="10" cols="50"
                    required><?php echo isset($post['content']) ? $post['content'] : ''; ?></textarea>

                <label for="img">Insérer une image</label>
                <input type="url" name="img" id="img" pattern="https?://.*" placeholder="Url de ton image"
                    value="<?php echo isset($post['img']) ? $post['img'] : ''; ?>">

                <input type="submit" value="<?php echo isset($post['id_post']) ? 'Modifier' : 'Créer'; ?>">

                <?php if (isset($post['id_post'])){
        echo "<input type='hidden' name='id_post' value='".$post['id_post']."'>";
    } ?>

            </form>
    </article>
</section>