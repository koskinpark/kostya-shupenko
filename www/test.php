<?php
// "�����" ������ �������, ���������� � � �����
$routeArray = explode('/', $_SERVER['REQUEST_URI']);
// ������� ������ �������� ������� (�������� ������������ ��������� � �������� ������� URI)
// ��� ����� ���� �������� array_shift � array_pop - �� ��� ������ � foreach ������� ����� "�������������"
$route = array();
foreach ($routeArray as $value) {
  if (!empty($value)) {
    $route[] = trim($value);
  }

}
// ������ � �������� ������ ������ ����, ������� ��� ��� ����������
echo "<pre>";
print_r($route);
echo "</pre>";
?>