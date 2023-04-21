<form action="back.php?action=presentations&case=<?php if (isset($action_form)) {echo $action_form;} ?>" method="post" class="presentation__form" enctype="multipart/form-data">
    <label for="title_presentation" class="presentation__form_label">Titre</label>
    <input type="text" name="title_presentation" id="title_presentation" class="presentation__form_input" placeholder="Titre" value="<?php if (isset($_POST["title_presentation"])) {echo $_POST["title_presentation"];}?>">
    <label for="content_presentation" class="presentation__form_label">Contenu</label>
    <textarea name="content_presentation" id="content_presentation" class="presentation__form_textarea" placeholder="Contenu"><?php if (isset($_POST["content_presentation"])) {echo $_POST["content_presentation"];}?></textarea>
    <label for="img_presentation" class="presentation__form_label">Illustration</label>
    <input type="file" name="img_presentation" id="img_presentation" class="presentation__form_input" value="">
    <label for="alt_presentation" class="presentation__form_label">Attribut Alt</label>
    <input type="text" name="alt_presentation" id="alt_presentation" class="presentation__form_input" placeholder="Attribut" value="<?php if (isset($_POST['alt_presentation'])){echo $_POST['alt_presentation'];} ?>">
    <label for="direction_presentation" class="presentation__form_label">Emplacement de l'image</label>
    <select name="direction_presentation" id="direction_presentation" class="presentation__form_select">
        <option class="presentation__form_select_option" value="left">Gauche</option>
        <option class="presentation__form_select_option" value="right">Droite</option>
    </select>
    <button class="presentation__form_btn" type="submit"> Enregistrer</button>
</form>