<?php
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
print $logins_stuff . $passwords_stuff;