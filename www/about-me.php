<?php

if (!empty($_POST['back_step'])) {
  $goto = $_SESSION['number_page'];
  unset($_SESSION['number_page']);
  user_goto($goto);
}
$form_block = about_me_block_form();
$form = form_render($form_block);
print $form;

?>