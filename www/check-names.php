<?php
require_once 'bootstrap.php';
print theme('messages', array('messages' => get_messages()));
print 'Ўаг 1 из 2';
$check_block = check_name_block();
print $check_block;

?>