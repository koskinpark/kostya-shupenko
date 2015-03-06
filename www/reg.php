<?php
require_once 'bootstrap.php';
if (!empty($_SESSION['registration_process']['fname']) AND !empty($_SESSION['registration_process']['lname'])) {
  $fname = $_SESSION['registration_process']['fname'];
  $lname = $_SESSION['registration_process']['lname'];
  $logins = rand_logins_from_container($fname, $lname);

  $logins_stuff = '<div class="login-container">';
  foreach ($logins as $key => $value) {
    $logins_stuff .= '<div><a href="#" >' . $value . '</a></div>';
  }
  $logins_stuff .= '</div>';

  $passwords = rand_passwords_from_container();
  $passwords_stuff = '<div class="password-container">';
  foreach ($passwords as $key => $value) {
    $passwords_stuff .= '<div><a href="#" >' . $value . '</a></div>';
  }
  $passwords_stuff .= '</div>';
  $form_block = reg_block_form();
  if ($_SESSION['register']['set_fake_data']) {

    $form_block['login']['value'] = 'ololo';
    unset($_SESSION['register']['set_fake_data']);
  }
  $form_block = form_render($form_block);
  print theme('messages', array('messages' => get_messages()));
  print 'Шаг 2 из 2';
  print $form_block;
  print '<div class="generate-stuff" style="display:none;">';
  print $logins_stuff . $passwords_stuff;
  print '</div>';
}
else {
  set_message ('Вы не ввели Имя/Фамилию', 'error');
  user_goto('/main/reg/1');
}