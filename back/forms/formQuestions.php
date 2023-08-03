<?php
$class='';
if(isset($_GET['case'])){
    if($_GET['case']=='loadQuestions'){
        $class = "prestationFormSection_display";
    }
    if($_GET['case']=='unloadQuestions'){
        $class = "prestationFormSection_display";
    }
}?>
<section class="prestationFormSection <?php echo $class ?>" id="prestationFormSection"   >
    <form action="back.php?action=questions&case=<?php if (isset($action_form)) {echo $action_form;} ?>" method="post" class="prestation__form" id="prestation_form" enctype="multipart/form-data">

        <div class="prestation__form_div">
            <h1 class="prestation__form_div_title">
                <?php
                if ($_GET['case'] == "loadQuestions"){
                    echo "Modifier une question";
                }
                if($_GET['case']=="unloadQuestions")
                    echo "Ajouter une question";
                ?>
            </h1>
            <i class="prestation__form_div_button fa-solid fa-xmark" id="closeButton"></i>

        </div>
        <label for="question_name" class="prestation__form_label">Question</label>
        <input type="text" name="question_name" id="question_name" class="prestation__form_input" placeholder="Question" value="<?php if (isset($_POST["question_name"])) {echo $_POST["question_name"];}?>">
        <label for="question_content" class="prestation__form_label">Réponse</label>
        <textarea name="question_content" id="question_content" class="prestation__form_textarea" placeholder="Réponse"><?php if (isset($_POST["question_content"])) {echo $_POST["question_content"];}?></textarea>
        <label for="visibility_question" class="prestation__form_label">Visibilité</label>
        <select name="visibility_question" id="visibility_question" class="prestation__form_select">
            <option class="prestation__form_select_option" value="1" <?php if((isset($visibility))&&( $visibility==1)){echo "selected";} ?>>Oui</option>
            <option class="prestation__form_select_option" value="2" <?php if((isset($visibility))&&( $visibility==2)){echo "selected";} ?>>Non</option>
        </select>
        <button class="prestation__form_btn" type="submit"> Enregistrer</button>
    </form>
</section>