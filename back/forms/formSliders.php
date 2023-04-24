<form action="back.php?action=sliders&case=<?php if (isset($action_form)){echo $action_form;}?>" method="post" enctype="multipart/form-data">
    <label for="title_sliders">Titre du sliders (obligatoire)</label>
    <input id="title_sliders" class="" placeholder="Titre [obligatoire]" type="text" name="title_sliders" value="<?php if(isset($_POST['title_sliders'])){echo $_POST['title_sliders'];} ?>">

    <label for="content_sliders">Contenu texte du sliders (facultatif)</label>
    <textarea id="content_sliders" placeholder="Contenu [facultatif]" name="content_sliders"><?php if(isset($_POST['content_sliders'])){echo $_POST['content_sliders'];} ?></textarea>

    <label for="image">Illustration du sliders (obligatoire)</label>
    <input id="image" class="" type="file" name="img_sliders" value="">
    <?php if(isset($miniature)){echo $miniature;} ?>

    <label for="alt_sliders">Alt du sliders (obligatoire)</label>
    <input id="alt_sliders" class="" placeholder="Alt du sliders [obligatoire]" type="text" name="alt_sliders" value="<?php if(isset($_POST['alt_sliders'])){echo $_POST['alt_sliders'];} ?>">

    <label>Visible</label>
    <div class="options">
        <label for="visibility_sliders">OUI</label>
        <select name="visibility_sliders" id="visibility_sliders">
            <option value="1">oui</option>
            <option value="2">non</option>
        </select>
    </div>
    <input type="submit" name="submit" value="ENREGISTRER">
</form>
