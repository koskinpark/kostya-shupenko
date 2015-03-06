<?php
title_of_task('Task 6','Makeup of gallery');
$array_of_albums = get_path_of_albums("images/gallery/*");
print get_albums_form($array_of_albums);
print get_source_code_block('get_albums_form');
?>