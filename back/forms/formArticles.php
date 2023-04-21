<?php $connexion = connexion(); ?>
<form action="back.php?action=articles&case=<?php if (isset($action_form)) {echo $action_form;} ?>" method="post" class="articles_form" enctype="multipart/form-data">
    <label class="articles_form_label" for="title_articles">Titre</label>
    <input class="articles_form_input" type="text" name="title_articles" id="title_articles" value="<?php if (
        isset($_POST["title_articles"])
    ) {
        echo $_POST["title_articles"];
    } ?>" placeholder="Titre">

    <label class="articles_form_label" for="content_articles">Contenu</label>
    <textarea class="articles_form_textarea" name="content_articles" id="content_articles" placeholder="Contenu"><?php if (
        isset($_POST["content_articles"])
    ) {
        echo $_POST["content_articles"];
    } ?></textarea>

    <label class="articles_form_label" for="page_articles">Page</label>
    <select class="articles_form_select" name="page_articles" id="page_articles">
        <option value="choose">Séléctionnez une page</option>
        <?php
        $request = "SELECT * FROM pages";
        $result = mysqli_query($connexion, $request);
        while ($rows = mysqli_fetch_object($result)) {
            echo "<option>" . $rows->title_pages . "</option>";
        }
        ?>
    </select>
    <label class="articles_form_label" for="img_articles" >Insérer une Image ?</label>
    <input class="articles_form_input" type="file" name="img_articles" id="img_articles">

    <label class="articles_form_label" for="visibility_articles">Visibilité</label>


  <div class="articles_form_div">
    <label for="visibility_articles_div_input"> Oui </label>
    <input class="articles_form_div_input" type="radio" name="visibility_articles" id="visibility_articles">
    <label for="visibility_articles"> Non </label>
    <input class="articles_form_radio" type="radio" name="visibility_articles" id="visibility_articles">
  </div>
    <button class="articles_form_btn"  type="submit"> Enregistrer</button>

</form>