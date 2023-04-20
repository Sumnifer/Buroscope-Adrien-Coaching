<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
  />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="../../assets/css/styles.css" />
  <link rel="stylesheet" href="../../assets/css/FontAwesome.css" />
  <title>Contactez nous !</title>
</head>
<?php include "header.php" ?>


<section class="contact_body">
<div class="contact_body_container">
  <form action="" class="contact_body_container_form">
    <h1 class="contact_body_container_form_title">Contactez moi !</h1>
    <label for="email" class="contact_body_container_form_label"></label>
    <input name="email" id="email" type="email" class="contact_body_container_form_input" placeholder="Confirmation email">
    <label for="message" class="contact_body_container_form_label"></label>
      <textarea name="messsage" id="messsage" placeholder="Message..." class="contact_body_container_form_textarea"></textarea>
    <button type="submit" class="contact_body_container_form_button"> ENVOYER </button>
  </form>
</div>
</section>


<?php include "footer.php" ?>

