<?php
require_once 'bootstrap.php';
 session_start();
 session_destroy();
 user_goto('main');
?>