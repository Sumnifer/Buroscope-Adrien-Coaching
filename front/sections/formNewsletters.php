<?php session_start();?>

<form action="<?php if (isset($form_action)){echo $form_action;} ?>">
<input type='email' name='email_newsletters' id='email_newsletters' class='reseau__container_items_newsletter_input'>
<button type='submit' class='reseau__container_items_newsletter_cta'>s’abonner</button>
</form>
