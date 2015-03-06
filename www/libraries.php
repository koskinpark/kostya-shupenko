<?php

function load_libraries() {
  $librariers = array(
    'PHPExcel' => 'PHPExcel/PHPExcel.php',
    'PHPExcel_IOFactory' => 'PHPExcel/PHPExcel/IOFactory.php',
  );
  foreach ($librariers as $name => $libraries) {
    require_once './libraries/' . $libraries;
  }
}