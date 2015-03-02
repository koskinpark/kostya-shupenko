<?php

$_SESSION['number_page'] = '/hello';
$form_block = hello_block_form();
$form = form_render($form_block);
print $form;
?>