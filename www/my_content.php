<?php
require_once 'bootstrap.php';
$user_status = get_user_info();
print theme('messages', array('messages' => get_messages()));
if (empty($user_status)) {
  set_message('Чтобы просматривать свой контент, авторизуйтесь', 'error');
  user_goto('/main');
}
else {
  $result = get_users_content_list();
  $check_new = 'Мои новости:';
  $check_article = 'Мои статьи:';
  $array_result_by_type = array();
  foreach ($result as $res) {
    $array_result_by_type[$res['type']][] = $res;
  }
  foreach ($array_result_by_type as $content_type => $contents) {
    $title_content_type_var = 'check_' . $content_type;
    print $$title_content_type_var . '<br>';
    foreach ($contents as $content) {
         $title_name = $content['title'];
         $cid = $content['cid'];
         print '<div>' . linq($cid . '/edit', $title_name) . '</div>';
    }
  }
}

?>