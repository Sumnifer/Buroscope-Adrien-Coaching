<?php
$class='';
if(isset($_GET['case'])){
 if($_GET['case']=='loadPresentations'){
     $class = "presentationFormSection_display";
    }
 if($_GET['case']=='unloadPresentations'){
     $class = "presentationFormSection_display";
 }
}?>
<section class="presentationFormSection <?php echo $class ?>" id="presentationFormSection"   >
<form action="back.php?action=presentations&case=<?php if (isset($action_form)) {echo $action_form;} ?>" method="post" class="presentation__form" id="presentation_form" enctype="multipart/form-data">

    <div class="presentation__form_div">
        <h1 class="presentation__form_div_title">
            <?php
            if ($_GET['case'] == "loadPresentations"){
                echo "Modifier une presentation";
            }
            if($_GET['case']=="unloadPresentations")
                echo "Ajouter une presentation";
                ?>
            </h1>
    <i class="presentation__form_div_button fa-solid fa-xmark" id="closeButton"></i>

    </div>
    <label for="title_presentations" class="presentation__form_label">Titre</label>
    <input type="text" name="title_presentations" id="title_presentations" class="presentation__form_input" placeholder="Titre" value="<?php if (isset($_POST["title_presentations"])) {echo $_POST["title_presentations"];}?>">
    <label for="content_presentations" class="presentation__form_label">Contenu</label>
    <textarea name="content_presentations" id="content_presentations" class="presentation__form_textarea" placeholder="Contenu"><?php if (isset($_POST["content_presentations"])) {echo $_POST["content_presentations"];}?></textarea>
    <label for="img_presentations" class="presentation__form_label">Illustration</label>
    <input type="file" name="img_presentations" id="img_presentations" class="presentation__form_input" value="">
    <label for="alt_presentations" class="presentation__form_label">Attribut Alt</label>
    <input type="text" name="alt_presentations" id="alt_presentations" class="presentation__form_input" placeholder="Attribut" value="<?php if (isset($_POST['alt_presentations'])){echo $_POST['alt_presentations'];} ?>">
    <label for="direction_presentations" class="presentation__form_label">Emplacement de l'image</label>
    <select name="direction_presentations" id="direction_presentations" class="presentation__form_select">
        <option class="presentation__form_select_option" value="left" <?php if((isset($direction))&&( $direction=="left")){echo "selected";} ?>>Gauche</option>
        <option class="presentation__form_select_option" value="right"<?php if((isset($direction))&&( $direction=="right")){echo "selected";} ?>>Droite</option>
    </select>
    <label for="visibility_presentations" class="presentation__form_label">Visibilité</label>
    <select name="visibility_presentations" id="visibility_presentations" class="presentation__form_select">
        <option class="presentation__form_select_option" value="1" <?php if((isset($visibility))&&( $visibility==1)){echo "selected";} ?>>Oui</option>
        <option class="presentation__form_select_option" value="2" <?php if((isset($visibility))&&( $visibility==2)){echo "selected";} ?>>Non</option>
    </select>
    <button class="presentation__form_btn" type="submit"> Enregistrer</button>
</form>
</section>