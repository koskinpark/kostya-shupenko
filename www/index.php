<?php
$routes = array(
  'main/content' => array(
    'file' => 'show_content',
  ),
    'kost' => array(
      'file' => 'kost',
    ),
  'adci' => array (
    'file' => 'adci',
      'sidebar' => array(
        'id' => 'sidebar-wrapper',
        'theme' => 'adci_task_ul_menu',
      ),

    'header_image' => 'images/header_adci.jpg',
    'class_of_content' => 'content',
    'classname_of_content_bg' => 'bg-adci',
  ),
  'adci/task/1' => array (
    'file' => 'task1',
    'classname_of_content_bg' => 'bg-task1',
  ),
  'adci/task/2' => array (
    'file' => 'task2',
      'classname_of_content_bg' => 'bg-task1',
  ),
  'adci/task/3' => array (
    'file' => 'task3',
      'classname_of_content_bg' => 'bg-task1',
  ),
  'adci/task/4' => array (
    'file' => 'task4',
      'classname_of_content_bg' => 'bg-task1',
  ),
  'adci/task/5' => array (
    'file' => 'task5',
      'classname_of_content_bg' => 'bg-task1',
  ),
  'adci/task/6' => array (
    'file' => 'task6',
      'classname_of_content_bg' => 'bg-task1',
  ),
  'adci/task/7' => array (
    'file' => 'task7',
      'classname_of_content_bg' => 'bg-task1',
  ),
  'adci/task/8' => array (
    'file' => 'task8',
      'classname_of_content_bg' => 'bg-task1',
  ),
  'managment' => array (
    'file' => 'managment',
  ),
  'main/auth' => array (
    'file' => 'auth',
  ),
  'main/reg/2' => array (
    'file' => 'reg'
  ),
  'main/reg/1' => array (
    'file' => 'check-names'
  ),
  'main/content/([\d]+)' => array(
    'file' => 'content',
    'args' => array(
      1 => 'cid',
    ),
  ),
  'addtodb' => array (
    'file' => 'addtodb'
  ),
  'reg-suggestions' => array (
    'file' => 'reg-suggestions'
  ),
  'logout' => array (
    'file' => 'logout'
  ),
  'main' => array(
    'file' => 'main_page',
    'classname_of_content_bg' => 'bg-main',
  ),
  'main/content/my' => array(
    'file' => 'my_content'
  ),
  'main/content/([\d]+)/edit' => array(
    'file' => 'my_content_edit',
    'args' => array(
      1 => 'cid',
    ),
  ),
  'main/add-users' => array (
    'file' => 'add_users'
  ),
  'main/content/add/([\S]+)' => array(
    'file' => 'add_content',
    'args' => array(
      1 => 'content_type',
    ),
  ),
);
$current_route = FALSE;

$_GET['route'] = empty($_GET['route']) ? 'main' : $_GET['route'];

foreach ($routes as $path => $route) {
  preg_match('/^' . str_replace("/", "\/", $path) . '$/', $_GET['route'], $matches);
  if (!empty($matches)) {
    $current_route = $route;
    break;
  }
}

if (!$current_route) {
  header("HTTP/1.0 404 Not Found");
  require_once './errors.php';
  die;
}

if (isset($current_route['args'])) {
  foreach ($current_route['args'] as $key => $get_key) {
    $_GET[$get_key] = $matches[$key];
  }
}
// elseif (empty($current_route['args'])) {}
/*if ($_SERVER['REQUEST_URI'] == ($current_route['file'] . '.php')) {
  var_dump($_SERVER['REQUEST_URI']);
  header("HTTP/1.0 404 Not Found");
  require_once '/errors.php';
  die;
}*/
require_once './bootstrap.php';
ob_start();
require_once './' . $current_route['file'] . '.php';
$page_content = ob_get_clean();

$class_content = !empty($current_route['class_of_content']) ? $current_route['class_of_content'] : '';
$sidebar = !empty($current_route['sidebar']) ? $current_route['sidebar'] : '';
$header_img = !empty($current_route['header_image']) ? $current_route['header_image'] : '';
$content_bg = !empty($current_route['classname_of_content_bg']) ? $current_route['classname_of_content_bg'] : '';
$out = isset($_GET['ajax']) ? $page_content : theme('page', array(
    'content' => $page_content,
    'sidebar' => $sidebar,
    'header_img' => $header_img,
    'content_bg' => $content_bg,
    'class_content' => $class_content,
));

print $out;
?>
