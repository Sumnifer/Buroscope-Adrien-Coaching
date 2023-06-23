<?php
$class='';
if(isset($_GET['case'])){
    if($_GET['case']=='loadSliders'){
        $class = "sliderFormSection_display";
    }
    if($_GET['case']=='unloadSliders'){
        $class = "sliderFormSection_display";
    }
}?>
<section class="sliderFormSection <?php echo $class ?>" id="sliderFormSection"   >

<form action="back.php?action=sliders&case=<?php if (isset($action_form)){echo $action_form;}?>" method="post" enctype="multipart/form-data" class="slider__form">
    <h1 class="slider__form__title">
        <?php
        if ($_GET['case'] == "loadSliders"){
            echo "Modifier une Slide";
        }
        if($_GET['case']=="unloadSliders")
            echo "Ajouter une Slide";
        ?>
    </h1>
    <i class="slider__form__icon fa-solid fa-xmark" id="closeButton"></i>
    <label for="title_sliders" class="slider__form_title">Titre du Sliders (obligatoire)</label>
    <input id="title_sliders" class="slider__form_input" placeholder="Titre [obligatoire]" type="text" name="title_sliders" value="<?php if(isset($_POST['title_sliders'])){echo $_POST['title_sliders'];} ?>">

    <label for="content_sliders" class="slider__form_content">Contenu texte du sliders (facultatif)</label>
    <textarea id="content_sliders" class="slider__form_textarea" placeholder="Contenu [facultatif]" name="content_sliders"><?php if(isset($_POST['content_sliders'])){echo $_POST['content_sliders'];} ?></textarea>

    <label for="img_sliders" class="slider__form_illustation">Illustration du sliders (obligatoire)</label>
    <input id="img_sliders" class="slider__form_input" type="file" name="img_sliders" value="">
    <?php if(isset($miniature)){echo $miniature;} ?>

    <label for="alt_sliders" class="slider__form_alt">Alt du sliders (obligatoire)</label>
    <input id="alt_sliders" class="slider__form_input" placeholder="Alt du sliders [obligatoire]" type="text" name="alt_sliders" value="<?php if(isset($_POST['alt_sliders'])){echo $_POST['alt_sliders'];} ?>">

    <label class="slider__form_visible">Visible</label>
    <div  class="slider__form_div">
        <select name="visibility_sliders" class="slider__form_div_select" id="visibility_sliders">
            <option class="slider__form_label_div_select_value" value="1">Oui</option>
            <option class="slider__form_label_div_select_value" value="2">Non</option>
        </select>
    </div>
    <input class="slider__form_btn" type="submit" name="submit" value="ENREGISTRER">
</form>
</section>
