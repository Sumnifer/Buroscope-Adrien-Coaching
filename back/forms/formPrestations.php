<?php
$class='';
if(isset($_GET['case'])){
    if($_GET['case']=='loadPrestations'){
        $class = "prestationFormSection_display";
    }
    if($_GET['case']=='unloadPrestations'){
        $class = "prestationFormSection_display";
    }
}?>
<section class="prestationFormSection <?php echo $class ?>" id="prestationFormSection"   >
    <form action="back.php?action=prestations&case=<?php if (isset($action_form)) {echo $action_form;} ?>" method="post" class="prestation__form" id="prestation_form" enctype="multipart/form-data">

        <div class="prestation__form_div">
            <h1 class="prestation__form_div_title">
                <?php
                if ($_GET['case'] == "loadPrestations"){
                    echo "Modifier une prestation";
                }
                if($_GET['case']=="unloadPrestations")
                    echo "Ajouter une prestation";
                ?>
            </h1>
            <i class="prestation__form_div_button fa-solid fa-xmark" id="closeButton"></i>

        </div>
        <label for="title_prestations" class="prestation__form_label">Titre</label>
        <input type="text" name="title_prestations" id="title_prestations" class="prestation__form_input" placeholder="Titre" value="<?php if (isset($_POST["title_prestations"])) {echo $_POST["title_prestations"];}?>">
        <label for="content_prestations" class="prestation__form_label">Contenu</label>
        <textarea name="content_prestations" id="content_prestations" class="prestation__form_textarea" placeholder="Contenu"><?php if (isset($_POST["content_prestations"])) {echo $_POST["content_prestations"];}?></textarea>
        <label for="price_prestations" class="prestation__form_label">Tarifs</label>
        <input type="number" name="price_prestations" id="price_prestations" class="prestation__form_input" value="<?php if (isset($_POST['price_prestations'])){echo $_POST['price_prestations'];} ?>">
        <label for="visibility_prestations" class="prestation__form_label">Visibilité</label>
        <select name="visibility_prestations" id="visibility_prestations" class="prestation__form_select">
            <option class="prestation__form_select_option" value="1" <?php if((isset($visibility))&&( $visibility==1)){echo "selected";} ?>>Oui</option>
            <option class="prestation__form_select_option" value="2" <?php if((isset($visibility))&&( $visibility==2)){echo "selected";} ?>>Non</option>
        </select>
        <button class="prestation__form_btn" type="submit"> Enregistrer</button>
    </form>
</section>