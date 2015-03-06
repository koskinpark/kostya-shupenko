<?php
// Загрузка файлов на сервер 
// Если register_globals=On 

print("Имя файла на нашем сервере (во время запроса): ".$myfile."<br>");
print("Имя файла на компьютере пользователя: ".$myfile_name."<br>");
print("MIME-тип файла: ".$myfile_type."<br>");
print("Размер файла: ".$myfile_size."<br><br>");

if(isset($_FILES["myfile"]))
{
  $myfile = $_FILES["myfile"]["tmp_name"];
  $myfile_name = $_FILES["myfile"]["name"];
  $myfile_size = $_FILES["myfile"]["size"];
  $myfile_type = $_FILES["myfile"]["type"];
  $error_flag = $_FILES["myfile"]["error"];

  // Если ошибок не было
  if($error_flag == 0)
  {
    print("Имя файла на нашем сервере (во время запроса): ".$myfile."<br>");
    print("Имя файла на компьютере пользователя: ".$myfile_name."<br>");
    print("MIME-тип файла: ".$myfile_type."<br>");
    print("Размер файла: ".$myfile_size."<br><br>");

    // Получаем содержимое файла
    $fp = fopen($myfile,"r");
    $content = fread($fp, filesize($myfile));
    fclose($fp);

    // Вывод содержимого файла
    print($content);

  } // end of if 2
} // end of if 1
?> 