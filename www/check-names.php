<?php
require_once 'bootstrap.php';
print theme('messages', array('messages' => get_messages()));
print '��� 1 �� 2';
$check_block = check_name_block();
print $check_block;

?>