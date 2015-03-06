<?php

require_once 'bootstrap.php';
if (isset($_POST['counts'])) {
    $counts=htmlspecialchars($_POST['counts']);
    print task8_generate($counts);
}
else {
    title_of_task('Task 8','Generate of random passwords with length of 6 characters and print them');
    print block_of_task8();
    print get_source_code_block('task8_generate');
}
?>
