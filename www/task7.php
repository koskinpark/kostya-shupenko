<?php

title_of_task('Task 7','Print of multiplication tables with a help of four different cycles');

$amount_x = range(1,10);
$amount_y = range(1,10);

$for = get_m_table_with_for($amount_x, $amount_y);
$while = get_m_table_with_while($amount_x, $amount_y);
$dowhile = get_m_table_with_dowhile($amount_x, $amount_y);
$foreach = get_m_table_with_foreach($amount_x, $amount_y);

get_m_table_form($for,'for');
print get_source_code_block('get_m_table_with_for');

get_m_table_form($while,'while');
print get_source_code_block('get_m_table_with_while');

get_m_table_form($dowhile,'dowhile');
print get_source_code_block('get_m_table_with_dowhile');

get_m_table_form($foreach,'foreach');
print get_source_code_block('get_m_table_with_foreach');

?>