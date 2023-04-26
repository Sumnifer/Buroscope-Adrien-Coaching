<form action="back.php?action=sliders&case=<?php if (isset($action_form)){echo $action_form;}?>" method="post" enctype="multipart/form-data" class="slider__form">
    <label for="title_sliders" class="slider__form_label">Titre du sliders (obligatoire)</label>
    <input id="title_sliders" class="slider__form_input" placeholder="Titre [obligatoire]" type="text" name="title_sliders" value="<?php if(isset($_POST['title_sliders'])){echo $_POST['title_sliders'];} ?>">

    <label for="content_sliders" class="slider__form_label">Contenu texte du sliders (facultatif)</label>
    <textarea id="content_sliders" class="slider__form_textarea" placeholder="Contenu [facultatif]" name="content_sliders"><?php if(isset($_POST['content_sliders'])){echo $_POST['content_sliders'];} ?></textarea>

    <label for="img_sliders" class="slider__form_label">Illustration du sliders (obligatoire)</label>
    <input id="img_sliders" class="slider__form_input" type="file" name="img_sliders" value="">
    <?php if(isset($miniature)){echo $miniature;} ?>

    <label for="alt_sliders" class="slider__form_label">Alt du sliders (obligatoire)</label>
    <input id="alt_sliders" class="slider__form_input" placeholder="Alt du sliders [obligatoire]" type="text" name="alt_sliders" value="<?php if(isset($_POST['alt_sliders'])){echo $_POST['alt_sliders'];} ?>">

    <label class="slider__form_label">Visible</label>
    <div class="options" class="slider__form_label_div">
        <label for="visibility_sliders" class="slider__form_label_div_label">OUI</label>
        <select name="visibility_sliders" class="slider__form_label_div_label_select" id="visibility_sliders">
            <option class="slider__form_label_div_label_select_value" value="1">oui</option>
            <option class="slider__form_label_div_label_select_value" value="2">non</option>
        </select>
    </div>
    <input class="slider__form_input" type="submit" name="submit" value="ENREGISTRER">
</form>
