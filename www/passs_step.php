<?php
if (empty($_SESSION["upload_excel_new_file"])) {
  set_message('Вы не загрузили файл списками Фамилий/Имён', 'error');
  user_goto('/step/1');
}
else {
  if (!empty($_POST)) {
    $passwords = $_POST;
    unset($passwords['next_step']);
    $_SESSION["passwords_step"] = $passwords;
    user_goto('/congratulations');
  }
}
$_SESSION['number_page'] = '/step/4';
$form_block = passwords_step_block_form();
$form = form_render($form_block);
print $form;

?>