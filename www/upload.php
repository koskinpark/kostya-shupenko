<?php
// �������� ������ �� ������ 
// ���� register_globals=On 

print("��� ����� �� ����� ������� (�� ����� �������): ".$myfile."<br>");
print("��� ����� �� ���������� ������������: ".$myfile_name."<br>");
print("MIME-��� �����: ".$myfile_type."<br>");
print("������ �����: ".$myfile_size."<br><br>");

if(isset($_FILES["myfile"]))
{
  $myfile = $_FILES["myfile"]["tmp_name"];
  $myfile_name = $_FILES["myfile"]["name"];
  $myfile_size = $_FILES["myfile"]["size"];
  $myfile_type = $_FILES["myfile"]["type"];
  $error_flag = $_FILES["myfile"]["error"];

  // ���� ������ �� ����
  if($error_flag == 0)
  {
    print("��� ����� �� ����� ������� (�� ����� �������): ".$myfile."<br>");
    print("��� ����� �� ���������� ������������: ".$myfile_name."<br>");
    print("MIME-��� �����: ".$myfile_type."<br>");
    print("������ �����: ".$myfile_size."<br><br>");

    // �������� ���������� �����
    $fp = fopen($myfile,"r");
    $content = fread($fp, filesize($myfile));
    fclose($fp);

    // ����� ����������� �����
    print($content);

  } // end of if 2
} // end of if 1
?> 