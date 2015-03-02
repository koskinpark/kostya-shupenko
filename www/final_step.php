<?php

if (!empty($_POST)) {
  if (!empty($_POST['step_to_main_page'])) {
    user_goto('/hello');
  }
  elseif (!empty($_POST['step_to_step_1'])) {
    user_goto('/step/1');
  }
}
else {
  if (empty($_SESSION["upload_excel_new_file"])) {
    set_message('Вы не загрузили файл списками Фамилий/Имён', 'error');
    user_goto('/step/1');
  }
  else {
    $_SESSION['number_page'] = '/congratulations';
    $form_block = final_step_block_form();
    $form = form_render($form_block);
    print $form;
    print '<script>document.location = "/download";</script>';
  }
}
?>