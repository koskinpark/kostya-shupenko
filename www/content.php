<?php
require_once 'bootstrap.php';
print theme('messages', array('messages' => get_messages()));
$result = get_content_list();
$user_status = get_user_info();
foreach ($result as $key => $value) {
  $result_array = $result[$key];
  if ($_GET["cid"] == $result_array['cid']) {
    $type_content = $result_array['type'];
    if ($type_content == 'new') {
      $new_content = '�������';
      }
    elseif ($type_content == 'article') {
      $new_content = '������';
      }
    print ("��������� $new_content");
    $title_name = $result_array['title'];
    print '<div>' . "$title_name" . '</div>';
    print '<div>' . "����� $new_content" . '</div>';
    $name_body = $result_array['body'];
    print '<div>' . "$name_body" . '</div>';
	$photo = '/images/' . $result_array['photo_path'];
	
	print '<img src=' . $photo . '>';
    if ($result_array['uid'] == $user_status) {
      print linq($result_array['cid'] . '/edit', '�������������');
    }
  }

}
?>