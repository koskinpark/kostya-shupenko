<?php
if (empty($_SESSION["upload_excel_new_file"])) {
  set_message('Вы не загрузили файл списками Фамилий/Имён', 'error');
  user_goto('/step/1');
}
else {
var_dump($_FILES);
  if (!empty($_POST)) {
    if (!empty($_FILES["myvoc"]["tmp_name"])) {
      move_uploaded_file($_FILES["myvoc"]["tmp_name"], './files/tmp/' . $_FILES["myvoc"]["name"]);
      $voc_file_excel = './files/tmp/' . $_FILES["myvoc"]["name"];
      PHPExcel_Settings::setLocale('ru');
      $_SESSION["voc_excel_new_file"] = $voc_file_excel;
      $_SESSION["voc_filename"] = $_FILES["myvoc"]["name"];
      unset( $_SESSION["voc_step"]);
     // user_goto('/step/3');
    }
    else {
      unset($voc['next_step']);
      unset( $_SESSION["voc_excel_new_file"]);
      unset( $_SESSION["voc_filename"]);

      $_SESSION["voc_step"] = array('choose_vocabulary' => 'server_voc');
      //user_goto('/step/3');
    }
  }
  $_SESSION['number_page'] = '/step/2';
  print '<div>' . linq('/files/examples/example_of_voc.xls', 'Пример оформления словаря', array('class' => 'btn btn-large btn-primary enabled uploadhref')) . '</div>';
  $form_block = vocabulary_step_block_form();
  $form = form_render($form_block);
  print $form;
}