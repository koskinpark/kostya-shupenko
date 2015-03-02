<?php
require_once 'bootstrap.php';
$user_status = get_user_info();

if (empty($user_status)) {
  set_message('Чтобы добавлять контент, авторизуйтесь', 'error');
  user_goto('/main');
}
else {
    $user_content_block = add_user_block_content($action = 'main/content/add/');
    $uid = $user_status;
    $created = date("Y-m-d");
	
      if (isset($_POST['title']) AND isset($_POST['body'])) {
		
	  $files = $_FILES["myfile"];
	  $file_path = $_FILES["myfile"]["name"];
	  var_dump( $file_path);
      $title = $_POST['title'];
      $body = $_POST['body'];
      if ($_POST["type"] == "new") {
        $type = 'new';
      }
      else {
        $type = 'article';
      }
          $bool = FALSE;
       $errors = check_content($files,$title,$body,$type,$bool);
             if ($errors) {
            if ($type == 'new') {
              $link = '/main/content/add/new';
             user_goto($link);
            }
            else {
              $link = '/main/content/add/article';
              user_goto($link);
            }
          }
		 
		 
      $result = save_content($file_path, $title, $body, $type, $uid, $created, $cid);
	  if ($result) {
	  
      set_message('Вы успешно добавили контент', 'notice');
     user_goto('/main');
}
else {
set_message('Ошибка добавления','error');
}      
	  }

}

print theme('messages', array('messages' => get_messages()));

?>
<div><?php print $user_content_block; ?></div>