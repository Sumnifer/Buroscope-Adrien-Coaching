
<form action="back.php?action=pages&case=<?php if (isset($action_form)) {echo $action_form;} ?>" method="post" class="pages__form" enctype="multipart/form-data">
  <h1 class="pages__form_title"><?php if(isset($form_title)){echo $form_title;}?></h1>

    <div class="pages__form_container">
        <label for="" class="pages__form_container_label">Afficher le slider</label>
        <div class="pages__form_container_bloc">
            <label for="sliderYes" class="pages__form_container_bloc_label">Oui</label>
            <input type="radio" name="slider" id="sliderYes" value="1" <?php if(isset($visibility_slider) && $visibility_slider === 1 ){echo "checked"; } ?> class="pages__form_container_bloc_input">
        </div>
        <div class="pages__form_container_bloc">
            <label for="sliderNo" class="pages__form_container_bloc_label">Non</label>
            <input type="radio" name="slider" id="sliderNo" value="2" <?php if(isset($visibility_slider) && $visibility_slider === 2 ){echo "checked"; } ?> class="pages__form_container_bloc_input">
        </div>
    </div>
    <div class="pages__form_container">
        <label for="" class="pages__form_container_label">Afficher les préstations</label>
        <div class="pages__form_container_bloc">
            <label for="prestationsYes" class="pages__form_container_bloc_label">Oui</label>
            <input type="radio" name="prestations" id="prestationsYes" value="1" <?php if(isset($visibility_prestations)&& $visibility_prestations === 1 ){echo "checked"; } ?> class="pages__form_container_bloc_input">
        </div>
        <div class="pages__form_container_bloc">
            <label for="prestationsNo" class="pages__form_container_bloc_label">Non</label>
            <input type="radio" name="prestations" id="prestationsNo" value="2" <?php if(isset($_GET['id_pages'])&& $_GET['id_pages'] == 10 ){echo "disabled "; } ?><?php if(isset($visibility_prestations)&& $visibility_prestations === 2 ){echo "checked"; } ?> class="pages__form_container_bloc_input">
        </div>
    </div>
    <button type="submit" class="pages__form_cta">Enregistrer <i class="fa-solid fa-save page__form_cta_icon"></i></button>
</form>
