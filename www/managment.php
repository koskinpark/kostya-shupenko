<?php
require_once 'bootstrap.php';

print 'Здесь представлена база пользователей с их email`ами';
print theme('messages', array('messages' => get_messages()));
var_dump($_POST);
$result = get_users_list();
$flag_of_titles = True;
$array_of_titles = array('Имя','Фамилия','EMAIL');
print "<table width='100%'><tbody>";
foreach ($result as $key => $value) {
  $result_array = $result[$key];
    $firstname = $result_array['firstname'];
    $lastname = $result_array['lastname'];
    $email = $result_array['email'];
    $id_user = $result_array['id_user'];
    $array_of_table = array($firstname, $lastname, $email);
    print '<tr><div>';
    if ($flag_of_titles) {
      $flag_of_titles = false;
      foreach ($array_of_titles as $titles) {
        print '<td>';
        print '<p>' . $titles . '</p>';
        print '</td>';
      }
      print '</div></tr>';
    }
    foreach ($array_of_table as $value) {
      print '<td>';
      print '<input id="' .  $id_user . '" type="text" name="' . $value . '" value="' . $value . '">';
      print '</td>';
    }
    print '</div></tr>';
   /* $user_content_block = add_user_block_content($action = '/managment', $default_values = array(
      'firstname' => $firstname,
      'lastname' => $lastname,
      'email' => $email,
      'id_user' => $id_user,
    )
  );
print '<tr><div>' . $user_content_block . '</div></tr>';
*/
}
$user_content_block = save_users($action = '/managment');
print '<div>' . $user_content_block . '</div>';
$result = save_content($title, $body, $type, $uid, $created, $cid);
print '</tbody></table>';
?>