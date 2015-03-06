<?php
if (empty($_SESSION["upload_excel_new_file"])) {
  set_message('Вы не загрузили файл списками Фамилий/Имён', 'error');
  user_goto('/step/1');
}
else {
  if (!empty($_POST)) {
    $logins = $_POST;
    unset($logins['next_step']);
    $_SESSION["logins_step"] = $logins;
    user_goto('/step/4');
  }
}
$_SESSION['number_page'] = '/step/3';
$form_block = logins_step_block_form();
$form = form_render($form_block);
print $form;


?>