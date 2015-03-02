<?php
require_once 'bootstrap.php';
if (get_user_info()) {
  check_user_status();
}
print $_SESSION['user_uid'];
$user_block = get_user_block();
print theme('messages', array('messages' => get_messages()));
?>
<div><?php print $user_block; ?></div>