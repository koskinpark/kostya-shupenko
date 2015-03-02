<?php
require_once 'bootstrap.php';
$user_status = get_user_info();
print theme('messages', array('messages' => get_messages()));
if (empty($user_status)) {
  set_message('Чтобы редактировать контент, авторизуйтесь', 'error');
  user_goto('/main');
}
else {

  $result = get_content_list();
  foreach ($result as $key => $value) {
    $result_array = $result[$key];

    if ($_GET["cid"] == $result_array['cid']) {
      $cid_up = $result_array['cid'];
      $title_edit = $result_array['title'];
      $body_edit = $result_array['body'];
    }
  }

  $user_content_block = add_user_block_content($action = '/main/content/' . $cid_up . '/edit', $default_values = array(
      'title' => $title_edit,
      'body' => $body_edit,
    )
  );
  $cid = $_POST['cid'];
  $title = $_POST['title'];
  $body = $_POST['body'];
  if ($_POST['op'] == 'Удалить запись') {
    $delete_query = delete_content($cid);
    set_message('Запись удалена', 'notice');
    user_goto('/main/content/my');
  }
  if (isset($_POST['title']) AND isset($_POST['body'])) {
    $bool = TRUE;
    $errors = check_content($title, $body, $type, $bool);
    if ($errors) {
      user_goto('/main/content/' . $cid_up . '/edit');
    }
    $result = save_content($title, $body, $type, $uid, $created, $cid);

    set_message('Вы успешно изменили контент', 'notice');
    user_goto("/main");
  }

}
?>
<div><?php print $user_content_block; ?></div>