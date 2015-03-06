<?php
require_once 'bootstrap.php';
print theme('messages', array('messages' => get_messages()));
if (isset($_POST['register'])) {
  $first_name = $_POST['check-first-name'];
  $last_name = $_POST['check-last-name'];
  $names = get_pid_names($first_name,$last_name);
  if ($names) {
    foreach ($names as $key) {
      $pid = $key["pid"];
      $fname = $key["firstname"];
      $lname = $key["lastname"];
    }
  }
  else {
    set_message('������ ��������� ���/������� �� ������� � ���� ������', 'error');
    user_goto('/main/reg/1');
  }
  if (user_load(array('pid' => $pid))) {
    set_message('�� ��� ����������������� � �������','error');
    user_goto('/main/reg/1');
  }
  if (isset($pid)) {
    $_SESSION['registration_process'] = array(
      'fname' => $fname,
      'lname' => $lname,
      'pid' => $pid,
    );
    set_message("������������, $fname $lname" , 'notice');
    set_message('����������, ���������� �����/������ ��� ������� ������ "�������������"', 'notice');
    user_goto('/main/reg/2');
  }
}
else {
  if (isset($_POST['register_step2'])) {
    $login = $_POST['login'];
    $errors_exists = FALSE;
    if (strlen($login) < 5) {
      set_message('����� ������ ���� �� ������ 6 ��������', 'error');
      $errors_exists = TRUE;
    }
    $pass = $_POST['pass'];
    if (strlen($pass) < 5) {
      set_message('������ ������ ���� �� ������ 6 ��������', 'error');
      $errors_exists = TRUE;
    }

    else {
      $password = md5($pass);
    }

    if ($errors_exists) {
      user_goto('/main/reg/2');
    }

    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $login = trim($login);

    if (user_load(array('Login' => $login))) {
      set_message('�������� ���� ����� ��� �������', 'error');
      user_goto('/main/reg/2');
    }

    $pid = $_SESSION['registration_process']['pid'];
    $result_norm = mysql_query("INSERT INTO users (Login,Password,pid)
                               VALUES('$login','$password','$pid')");
    if ($result_norm) {
      set_message('����������, �� �������', 'notice');
      unset($_SESSION['registration_process']['fname']);
      unset($_SESSION['registration_process']['lname']);
      user_goto('/main');
    }
    else {
      set_message('������ �����������', 'error');
      user_goto('/main/reg/2');
    }
  }
  elseif (isset($_POST['generate'])) {
    $_SESSION['register']['set_fake_data'] = TRUE;
    user_goto('/main/reg/2');
  }
}
?>