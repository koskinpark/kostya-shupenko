<?php
require_once 'bootstrap.php';

$result = get_content_list();

$check_new = 'Список новостей:';
$check_article = 'Список статей:';
$array_result_by_type = array();
foreach ($result as $res) {
  $array_result_by_type[$res['type']][] = $res;
}
foreach ($array_result_by_type as $content_type => $contents) {
  $title_content_type_var = 'check_' . $content_type;
  print '<div>' . $$title_content_type_var . '</div>';
  foreach ($contents as $content) {
    $title_name = $content['title'];
    $content_body = $content['body'];
    $photo_path = '/images/' . $content['photo_path'];
    $cid = $content['cid'];
	print '<div>';
    print '<div>' . linq('content/' . $cid, $title_name) . '</div>';
    print '<div class="content_images" style="background-image: url(' .$photo_path . ')">' . '</div>';
    print '<div>' . linq('content/' . $cid, $content_body) . '</div>';
    print '</div>';
  }
}
?>