
<form action="back.php?action=pages&case=<?php if (isset($action_form)) {echo $action_form;} ?>" method="post" class="pages__form" enctype="multipart/form-data">
  <label for="title_pages" class="pages__form_label">Titre</label>
  <input type="text" name="title_pages" id="title_pages" class="pages__form_input" value="<?php if(isset($_POST["title_pages"])) {echo $_POST["title_pages"];} ?>" placeholder="Titre">
  <button class="pages__form_btn" type="submit"> Enregistrer</button>
</form>
