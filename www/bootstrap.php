<?php

session_start();

function database_connect()
{
 require_once './connect.php';
}

mysql_query("set names 'utf8'");
mysql_query("set character set 'utf8';");

function check_user_status()
{
    user_goto('main');
}

function logout()
{
    session_start();
    session_destroy();
    user_goto('main');
}

function get_user_block()
{
    $user_id = get_user_info();

    if (!$user_id && isset($_POST['name']) && isset($_POST['password'])) {
        $conditions['login'] = mysql_real_escape_string($_POST['name']);
        $conditions['password'] = md5($_POST['password']);
        $row_uid = user_load($conditions);
        if ($row_uid) {
            $_SESSION['user_uid'] = $row_uid['id_admin'];
            $out = theme('hello_user_block', array('username' => $conditions['login']));
            set_message($out, 'notice');
            user_goto('main');
            return $out;
        } else {
            set_message('����� ����� � ������� �� ������� � ���� ������.', 'error');
            user_goto('main/auth');
        }
    } else {
        if ($user_id) {
            $user_object = user_load($user_id);
            $out = theme('hello_user_block', array('username' => $user_object['login']));
            print '<div>' . linq('logout', '�����') . '</div>';
        } else {
            $out = theme('user_login_form_block');
        }
        return $out;
    }
}

function user_load($uid)
{

    $conditions = array();
    if (!isset($uid)) {
        $uid = get_user_info();
    }

    if (is_numeric($uid)) {
        $conditions['id_admin'] = $uid;
    } elseif (is_array($uid)) {
        $conditions = $uid;
    } else {
        return FALSE;
    }

    $users_result = get_from_db_by_condition('administrator', $conditions);

    return $users_result ? $users_result[0] : FALSE;
}

function get_from_db_by_condition($table_name, $conditions = array(), $fields = '*', $limit = 1, $order = '')
{

    if (!is_numeric($limit) && !is_null($limit)) {
        return FALSE;
    }

    $condition_lines = array();
    if (!empty($conditions)) {
        foreach ($conditions as $field_name => $condition) {
            $condition_lines[] = $field_name . '="' . $condition . '"';
        }
    }
    $query = "SELECT $fields
            FROM $table_name";

    if (!empty($condition_lines)) {
        $query .= " WHERE " . implode(' AND ', $condition_lines);
    }

    if (!empty($order)) {
        $query .= ' ORDER BY ' . $order;
    }

    if (!is_null($limit)) {
        $query .= " LIMIT " . $limit;
    }
    $sql_result = mysql_query($query);
    $result_array = array();

    while ($row = mysql_fetch_assoc($sql_result)) {
        $result_array[] = $row;
    }
    mysql_free_result($sql_result);

    return empty($result_array) ? FALSE : $result_array;
}

function get_user_info()
{
    return isset($_SESSION['user_uid']) ? $_SESSION['user_uid'] : 0;
}

function theme($theme_name, $vars = array())
{

    $candidate = 'theme_' . $theme_name;
    if (function_exists($candidate)) {
        return '<div class="' . str_replace("_", "-", $theme_name) . '" >' . $candidate($vars) . '</div>';
    }

    $preprocess_candidate = 'preprocess_theme_' . $theme_name;
    if (function_exists($preprocess_candidate)) {
        $preprocess_candidate($vars);
    }

    if (!empty($vars)) {
        foreach ($vars as $var_name => $value) {
            $$var_name = $value;
        }
    }
    ob_start();
    include $theme_name . '.tpl.php';
    return ob_get_clean();
}

function preprocess_theme_page(&$vars)
{
    $vars['body_classes'] = str_replace('/', '-', $_GET['route']) . '-page';
}

function get_html_tag_attr($attr)
{
    $out = array();
    foreach ($attr as $key => $value) {
        $out[] = $key . '="' . $value . '"';
    }
    return implode(" ", $out);
}

function theme_table($vars)
{
    $out = '<table ' . get_html_tag_attr($vars['attr']) . '>';

    if (isset($vars['header'])) {
        $out .= '<thead><tr>';
        foreach ($vars['header'] as $head) {
            if (!is_array($head)) {
                $head['data'] = $head;
            }
            $out .= '<th ' . (isset($head['attr']) ? get_html_tag_attr($head['attr']) : '') . '>' . $head['data'] . '</th>';
        }
        $out .= '</tr></thead>';
    }

    if (isset($vars['rows'])) {
        $out .= '<tbody>';
        foreach ($vars['rows'] as $row) {
            $out .= '<tr>';
            foreach ($row as $cell) {
                if (!is_array($cell)) {
                    $cell = array(
                        'data' => $cell,
                    );
                }
                $out .= '<td ' . ((is_array($cell['attr']) && isset($cell['attr'])) ? get_html_tag_attr($cell['attr']) : '') . '>' . $cell['data'] . '</td>';
            }
            $out .= '</tr>';
        }
        $out .= '</tbody>';
    }


    $out .= '</table>';

    return $out;
}

function title_of_task($title, $subtitle)
{
    print '<div class="task-of-adci">';
    print '<span>' . $title . '</span>';
    print '<p>' . $subtitle . '</p>';
    print '</div>';
}

function theme_list_ul($vars)
{
    $out = '<ul ' . get_html_tag_attr($vars['attr']) . '>';

    if (isset($vars['rows'])) {
        foreach ($vars['rows'] as $row) {
            foreach ($row as $cell) {
                if (!is_array($cell)) {
                    $cell = array(
                        'data' => $cell,
                    );
                }
                $out .= '<li ' . ((is_array($cell) && isset($cell['attr'])) ? get_html_tag_attr($cell['attr']) : '') . '>' . $cell['data'] . '</li>';
            }
        }
    }


    $out .= '</ul>';

    return $out;
}


function theme_adci_task_ul_menu($vars)
{

    $list = array();
    $list[1] = 'Operations of primes';
    $list[2] = 'HTML-list by javascript';
    $list[3] = 'Picture by javascript';
    $list[4] = 'MD5 brute force';
    $list[5] = 'Makeup of picture';
    $list[6] = 'Makeup of gallery';
    $list[7] = 'Multiplication tables';
    $list[8] = 'Password generator';

    foreach ($list as $taskn => $description) {
        $ul_vars['rows'][0][] = '<a href="/adci/task/' . $taskn . '"class="use-ajax content-a ' . "content-$taskn" . '">
    <div class="block-of-slides">
      <div class="slide-div">
        <div class="slide-left"><span>Task ' . $taskn . '</span></div><div class="slide-right"><span class="right-span">' . $description . '</span></div></div></div>
    </a>';
    }
    $ul_vars['attr'] = array(
        'class' => 'content-ul',
    );

    return theme('list_ul', $ul_vars);
}

function theme_adci_task_list_menu($vars)
{

    $list = array();
    $list[1] = 'Operations of primes';
    $list[2] = 'HTML-list by javascript';
    $list[3] = 'Picture by javascript';
    $list[4] = 'MD5 brute force';
    $list[5] = 'Makeup of picture';
    $list[6] = 'Makeup of gallery';
    $list[7] = 'Multiplication tables';
    $list[8] = 'Password generator';

    foreach ($list as $taskn => $description) {
        $table_vars['rows'][0][] = '<a href="/adci/task/' . $taskn . '" class="use-ajax content-a">
    <div>
    <h2 class="content-h2">Task ' . $taskn . '</h2><p>' . $description . '</p></div></a>';
    }
    $table_vars['attr'] = array(
        'class' => 'content-table',
    );

    return theme('table', $table_vars);
}

function user_goto($path = NULL)
{
    // $currentUrl = $_SERVER['REQUEST_URI'];
    // preg_replace('/&?os=[^&]*/', '', $currentUrl);
    header('Location: ' . $path, TRUE, 302);
    die;
}

function set_message($message, $message_status = 'notice')
{
    $_SESSION['messages'][] = array(
        'status' => $message_status,
        'data' => $message,
    );
}

function get_messages()
{
    $messages = $_SESSION['messages'];
    unset($_SESSION['messages']);
    return $messages;
}

function check_name_block()
{
    $check_name = array(
        array(
            'title' => '������� ���� ���:',
            'type' => 'input',
            'input_type' => 'text',
            'name' => 'check-first-name',
            'id' => 'login-reg',
        ),
        array(
            'title' => '������� ���� �������:',
            'type' => 'input',
            'input_type' => 'text',
            'name' => 'check-last-name',
            'id' => 'pass-reg',
        ),
        array(
            'type' => 'input',
            'input_type' => 'submit',
            'name' => 'register',
            'value' => '��������� ���',
            'id' => 'reg-submit',
        ),
    );
    $out = theme('form', array(
            'action' => "/addtodb",
            'form_elements' => $check_name,
        )
    );
    return $out;
}

function get_pass()
{

}

function block_of_primes()
{
    $user_login_form = array(
        'Number A' => array(
            'title' => '�����:',
            'type' => 'input',
            'input_type' => 'text',
            'name' => 'login',
            'id' => 'login-reg',
        ),
        'Number A' => array(
            'title' => '�����:',
            'type' => 'input',
            'input_type' => 'text',
            'name' => 'login',
            'id' => 'login-reg',
        )
    );
}

function reg_block_form()
{
    $user_login_form = array(
        'login' => array(
            'title' => '�����:',
            'type' => 'input',
            'input_type' => 'text',
            'name' => 'login',
            'id' => 'login-reg',
        ),
        'pass' => array(
            'title' => '������:',
            'type' => 'input',
            'input_type' => 'text',
            'name' => 'pass',
            'id' => 'pass-reg',
        ),
        array(
            'type' => 'input',
            'input_type' => 'submit',
            'name' => 'register_step2',
            'value' => '������������������',
            'id' => 'reg-submit',
        ),
        array(
            'type' => 'input',
            'input_type' => 'submit',
            'name' => 'generate',
            'value' => '�������������',
            'id' => 'gen-submit',
        ),
        '#action' => 'addtodb',
    );
    return $user_login_form;
}

function form_render($form)
{
    $action = $form['#action'];
    unset($form['#action']);
    return theme('form', array(
            'action' => "/" . $action,
            'form_elements' => $form,
        )
    );
}

function save_users($action)
{
    $form_elements = array(
        array(
            'type' => 'input',
            'input_type' => 'submit',
            'name' => 'op',
            'value' => '���������',
            'id' => 'add-content-submit',
        ),
    );

    $out = theme('form', array(
            'action' => $action,
            'form_elements' => $form_elements,
            //'token' => $token,
        )
    );


    return $out;
}

function add_user_block_content($action, $default_values = array())
{

    $_SESSION['add_content_form_token'] = $token = rand(10000, 99999);

    $form_elements = array(
        array(
            'table' => 'td',
            'type' => 'input',
            'input_type' => 'text',
            'name' => $default_values['firstname'],
            'value' => $default_values['firstname'] ? $default_values['firstname'] : '',
        ),
        array(
            'table' => 'td',
            'type' => 'input',
            'input_type' => 'text',
            'name' => $default_values['lastname'],
            'value' => $default_values['lastname'] ? $default_values['lastname'] : '',
        ),
        array(
            'table' => 'td',
            'type' => 'input',
            'input_type' => 'text',
            'name' => $default_values['email'],
            'value' => $default_values['email'] ? $default_values['email'] : '',
        ),
        array(
            'type' => 'input',
            'input_type' => 'submit',
            'name' => 'op',
            'value' => '���������',
            'id' => 'add-content-submit',
        ),

    );

    $out = theme('form', array(
            'action' => $action,
            'form_elements' => $form_elements,
            //'token' => $token,
        )
    );


    return $out;
}

function block_of_task8()
{
    $out = '<div class="task">';
    $out .= '<div class="task8">';
    $out .= form_of_task8();
    $out .= '</div>';
    $out .= '</div>';
    return $out;
}

function form_of_task8()
{
    $form_elements = array(
        array(
            'title' => 'Enter the amount of passwords:',
            'type' => 'input',
            'input_type' => 'text',
            'name' => 'counts',
            'value' => 'Input me pls...',
            'id' => 'id_of_counts',
            'onFocus' => "doClear(this)",
            'onBlur' => "doDefault(this)",
        ),
        array(
            'id' => 'btn-task8',
            'type' => 'input',
            'input_type' => 'submit',
            'name' => 'generate',
            'value' => 'Generate!',
        ),
        array(
            'type' => 'div',
            'id' => 'result',
        ),
    );
    $out = theme('form', array(
            'id_form' => 'id_task8',
            'action' => "/adci/task/8",
            'form_elements' => $form_elements,
        )
    );
    return $out;
}

function form_ul($md5_passwords)
{
    $elements = array(
        array(
            'type' => 'div',
            'class' => 'task4-div',
            'sub' => array(
                array(
                    'type' => 'span',
                    'text' => 'Passwords:',
                ),
                array(
                    'type' => 'ul',
                    'li' => $md5_passwords,
                ),
            ),
        ),
    );
    $out = theme('ul_menu', array(
            'form_elements' => $elements,
        )
    );
    return $out;
}

function form_ul_answers($answers)
{
    $elements = array(
        array(
            'type' => 'div',
            'class' => 'task4-div margin-top',
            'sub' => array(
                array(
                    'type' => 'span',
                    'text' => 'Found ' . count($answers) . ' matches:',
                ),
                array(
                    'type' => 'ul',
                    'li' => $answers,
                ),
            ),

        ),
    );
    $out = theme('ul_menu', array(
            'form_elements' => $elements,
        )
    );
    return $out;
}


function add_users_block($action, $default_values = array())
{
    $_SESSION['add_content_form_token'] = $token = rand(10000, 99999);
    $type_hidden = 'new';
    $new_firstname = '���';
    $new_lastname = '�������';
    $hidden = 'submit';
    $form_elements = array(
        array(
            'title' => $new_firstname,
            'type' => 'input',
            'input_type' => 'text',
            'name' => 'title',
            'value' => $default_values['title'] ? $default_values['title'] : '',
            'id' => 'add-firstname',
        ),
        array(
            'title' => $new_lastname,
            'type' => 'input',
            'input_type' => 'text',
            'name' => 'body',
            'value' => $default_values['body'] ? $default_values['body'] : '',
            'id' => 'add-lastname',
        ),
        array(
            'type' => 'input',
            'input_type' => 'submit',
            'name' => 'op',
            'value' => '�������� � ����',
            'id' => 'add-user-submit',
        ),
        array(
            'type' => 'input',
            'input_type' => $hidden,
            'name' => 'new_user',
            'value' => '�������� ��',
            'id' => 'add-new-user',
        ),
    );

    if (isset($_GET['cid'])) {
        $form_elements[] = array(
            'type' => 'input',
            'input_type' => 'hidden',
            'name' => 'cid',
            'value' => $_GET['cid'],
            'id' => 'add_content_cid',
        );
    }

    $out = theme('form', array(
            'action' => $action,
            'form_elements' => $form_elements,
            //'token' => $token,
        )
    );


    return $out;
}

function delete_content($cid)
{
    $query = mysql_query("DELETE FROM content WHERE `cid` = $cid");
    return $query;
}

function get_users_content_list()
{
    $users_result = get_from_db_by_condition('content', array('uid' => get_user_info()), '*', NULL);
    return $users_result;
}

function get_words()
{
    $words = get_from_db_by_condition('generator_words', array('gid' == 1), '*', NULL);
    return $words;
}

function get_pid_names($first_name, $last_name)
{
    $names = get_from_db_by_condition('names', array('firstname' => $first_name, 'lastname' => $last_name));
    return $names;
}

function linq($path, $title, $attributes = array())
{
    if (isset($attributes['query'])) {
        $query_ready = array();
        foreach ($attributes['query'] as $query_key => $value) {
            $query_ready[] = $query_key . '=' . rawurlencode($value);
        }
        $query_ready = implode("&", $query_ready);
        $url = $path . '?' . $query_ready;
    } else {
        $url = $path;
    }

    return '<a href="' . $url . '" >' . $title . '</a>';
}

function get_users_list()
{
    $users_result = get_from_db_by_condition('users', array(), '*', NULL);
    return $users_result;
}

function get_content_list()
{
    $users_result = get_from_db_by_condition('content', array(), '*', NULL);
    return $users_result;
}

function save_content($file_path, $title, $body, $type, $uid, $created, $cid)
{
    if (isset($cid)) {

        $return = mysql_query("UPDATE `content`
                           SET `title` = '$title', `body` = '$body', `photo_path` = '$file_path'
                           WHERE `cid` =  '$cid'");
    } else {
        $return = mysql_query("INSERT INTO content (photo_path, title, body, type, uid, created)
                           VALUES('$file_path','$title','$body', '$type', $uid, '$created')");
    }
    return $return;
}

function check_num_role()
{
    if (get_user_info()) {
        $uid = get_user_info();
        $return = get_from_db_by_condition('users', array('id_admin' => $uid), $fields = 'num_role', NULL);
        foreach ($return as $value) {
            foreach ($value as $key => $value1) {
                $result = $value1;
            }
        }
    }
    return TRUE ? $result == '2' : FALSE;
}

function check_content($files, $title, $body, $type, $bool)
{

    $errors_exists = FALSE;
    if (isset($files)) {
        if (empty($_FILES["myfile"]["tmp_name"])) {
            set_message('�������� ����������', 'error');
            $errors_exists = TRUE;
        } else {
            move_uploaded_file($_FILES["myfile"]["tmp_name"], './images/' . $_FILES["myfile"]["name"]);
        }
    }
    if (isset($type)) {
        if ($type == 'new') {
            if (strlen($title) < 5) {
                set_message('�������� ��������� �������', 'error');
                $errors_exists = TRUE;
            }
            if (strlen($body) < 5) {
                set_message('�������� ����� �������', 'error');
                $errors_exists = TRUE;
            }
        } elseif ($type == 'article') {
            if (strlen($title) < 5) {
                set_message('�������� ��������� ������', 'error');
                $errors_exists = TRUE;
            }
            if (strlen($body) < 5) {
                set_message('�������� ����� ������', 'error');
                $errors_exists = TRUE;
            }
        }
    } else {
        if (strlen($title) < 5) {
            set_message('�������� ��������� �������', 'error');
            $errors_exists = TRUE;
        }
        if (strlen($body) < 5) {
            set_message('�������� ����� �������', 'error');
            $errors_exists = TRUE;
        }
    }
    $check_db = get_content_list();
    if ($bool == TRUE) {
    } else {
        foreach ($check_db as $key => $value) {
            $check_arr = $check_db[$key];
            if ($body == $check_arr['body']) {
                set_message('�� ��������!', 'error');
                $errors_exists = TRUE;
            }
        }
    }
    return $errors_exists;
}

function container_of_generation_logins($fname, $lname)
{
    $fname = strtolower($fname);
    $lname = strtolower($lname);
    $symbols_array = array('#', '%', '^', '*', '-', '_', '+', '=', '.', '1', '01', '001', '0001', '123', '11', '0');
    foreach ($symbols_array as $key) {
        $rand_symb = array_rand($symbols_array, 1);
        $gen_v1 = $fname . "$symbols_array[$rand_symb]" . $lname;
        $gen_v2 = "$symbols_array[$rand_symb]" . $fname . $lname;
        $gen_v3 = $fname . $lname . "$symbols_array[$rand_symb]";
        $container_of_generations[] = array($gen_v1, $gen_v2, $gen_v3);
        unset($symbols_array[$rand_symb]);
    }
    return $container_of_generations;
}

function rand_logins_from_container($fname, $lname)
{
    $logins = container_of_generation_logins($fname, $lname);
    $rand_login = array_rand($logins, 7);
    foreach ($rand_login as $key => $value) {
        $rand_var = array_rand(($logins[$value]), 1);
        $array_logins[] = $logins[$value][$rand_var];
    }
    return $array_logins;
}

function container_of_generation_passwords()
{
    $passwords[] = get_from_db_by_condition('generator_words', array('number' => 2), $fields = 'value', NULL);
    $passwords[] = get_from_db_by_condition('generator_words', array('number' => 1), $fields = 'value', NULL);
    return $passwords;
}

function rand_passwords_from_container()
{
    $passwords = container_of_generation_passwords();
    foreach ($passwords as $key => $value) {
        if ($key == 0) {
            $adjectives[] = $value;
        }
        if ($key == 1) {
            $nouns[] = $value;
        }
    }
    foreach ($adjectives as $keys => $value) {
        foreach ($value as $key => $val) {
            $array_adj[] = ($val['value']);
        }
    }

    foreach ($nouns as $keys => $value) {
        foreach ($value as $key => $val) {
            $array_nouns[] = ($val['value']);
        }
    }
    foreach ($array_adj as $key => $value) {
        foreach ($array_nouns as $kei => $val) {
            $generated[] = $array_adj[$key] . '_' . $array_nouns[$kei];
        }
    }
    $rand_pass = array_rand($generated, 7);
    foreach ($rand_pass as $key => $value) {
        $array_passwords[] = $generated[$value];
    }
    return $array_passwords;
}

function adci_table()
{
    $bufer_of_table = array(
        'div' => array(
            'class-div' => 'content-div',
        ),
        'table' => array(
            'class-table' => 'content-table',
            'tbody' => array(
                'tr1' => array(
                    'td1' => array(
                        'a' => array(
                            'class-a' => 'content-a',
                            'href' => '/adci/task/1',
                        ),
                        'div' => array(
                            'h2' => 'Task 1',
                            'class-h2' => 'content-h2',
                            'p' => 'Operations of primes',
                        ),
                    ),
                    'td2' => array(
                        'a' => array(
                            'class-a' => 'content-a',
                            'href' => '/adci/task/2',
                        ),
                        'div' => array(
                            'h2' => 'Task 2',
                            'class-h2' => 'content-h2',
                            'p' => 'HTML-list by javascript',
                        ),
                    ),
                    'td3' => array(
                        'a' => array(
                            'class-a' => 'content-a',
                            'href' => '/adci/task/3',
                        ),
                        'div' => array(
                            'h2' => 'Task 3',
                            'class-h2' => 'content-h2',
                            'p' => 'Picture by javascript',
                        ),
                    ),
                    'td4' => array(
                        'a' => array(
                            'class-a' => 'content-a',
                            'href' => '/adci/task/4',
                        ),
                        'div' => array(
                            'h2' => 'Task 4',
                            'class-h2' => 'content-h2',
                            'p' => 'MD5 brute force',
                        ),
                    ),
                    'td5' => array(
                        'a' => array(
                            'class-a' => 'content-a',
                            'href' => '/adci/task/5',
                        ),
                        'div' => array(
                            'h2' => 'Task 5',
                            'class-h2' => 'content-h2',
                            'p' => 'Makeup of picture',
                        ),
                    ),
                    'td6' => array(
                        'a' => array(
                            'class-a' => 'content-a',
                            'href' => '/adci/task/6',
                        ),
                        'div' => array(
                            'h2' => 'Task 6',
                            'class-h2' => 'content-h2',
                            'p' => 'Makeup of gallery',
                        ),
                    ),
                    'td7' => array(
                        'a' => array(
                            'class-a' => 'content-a',
                            'href' => '/adci/task/7',
                        ),
                        'div' => array(
                            'h2' => 'Task 7',
                            'class-h2' => 'content-h2',
                            'p' => 'Multiplication tables',
                        ),
                    ),
                    'td8' => array(
                        'a' => array(
                            'class-a' => 'content-a',
                            'href' => '/adci/task/8',
                        ),
                        'div' => array(
                            'h2' => 'Task 8',
                            'class-h2' => 'content-h2',
                            'p' => 'Password generator',
                        ),
                    ),
                ),
            ),
        ),
    );
    return $bufer_of_table;
}

function print_adci_table($adci_table)
{
    $counter_tr = 1;
    $counter_td = 1;
    foreach ($adci_table as $key => $value) {
        if ($key == 'div') {
            if (is_array($value)) {
                foreach ($value as $key_of_upper_div => $value_of_upper_div) {
                    if ($key_of_upper_div == 'class-div') {
                        print '<div class="' . $value_of_upper_div . '">';
                    }
                }
            }
        }
        if ($key == 'table') {
            if (is_array($value)) {
                foreach ($value as $key_of_table => $value_of_table) {
                    if ($key_of_table == 'class-table') {
                        print '<table class="' . $value_of_table . '">';
                    }
                    if ($key_of_table == 'tbody') {
                        print '<tbody>';
                        foreach ($value_of_table as $key_of_tbody => $value_of_tbody) {
                            if ($key_of_tbody == 'tr1') {
                                print '<tr>';
                                foreach ($value_of_tbody as $key_of_tr => $value_of_tr) {
                                    if ($key_of_tr == ('td' . $counter_td)) {
                                        print '<td>';
                                        foreach ($value_of_tr as $key_of_td => $value_of_td) {


                                            if ($key_of_td == 'a') {
                                                print '<a href=' . $value_of_td["href"] . ' class=' . $value_of_td["class-a"] . '>';
                                            }
                                            if ($key_of_td == 'div') {
                                                print '<div>';
                                                print '<h2 class=' . $value_of_td["class-h2"] . '>' . $value_of_td["h2"] . '</h2>';
                                                print '<p>' . $value_of_td["p"] . '</p>';
                                                print '</div>';
                                            }
                                        }
                                        print '</a>';
                                        print '</td>';
                                    }


                                    $counter_td++;
                                }
                                print '</tr>';
                                $counter_tr++;
                            }

                        }
                        print '</tbody>';
                    }
                }
            }
            print '</table>';
        }
    }

    print '</div>';
}

/**
 * This function finds primes among all the numbers
 * @param int $amount limit of search primes
 * @return array of primes
 */

function table_of_primes($amount) {
    //$amount = 1000;
    for ($i = 3; $i <= $amount; $i++) {
        $flag = false;
        for ($j = 2; $j <= ($i - 1); $j++) {
            if ($i % $j == 0) {
                $flag = true;
            } else {
                $num = $i;
            }
        }
        if ($flag == false) {
            $array_of_primes[] = $num;
        }
    }
    array_unshift($array_of_primes, 2);
    return $array_of_primes;
}

function get_table_of_primes($amount)
{
    $array_of_primes = table_of_primes($amount);
    print '<div class="task1-table">';
    print '<table>';
    print '<tbody>';
    $strs = round(count($array_of_primes) / 10, 0, PHP_ROUND_HALF_UP);
    for ($n = 0; $n <= 12; $n++) {
        if ($n != 0) {
            print '<tr>';
            for ($col = 1; $col < 15; $col++) {
                print '<td>' . current($array_of_primes) . '</td>';
                array_shift($array_of_primes);
            }
            print '</tr>';
        } else {
            print '<tr>';
            print '<th  colspan="15">' . "Primes from 1 to $amount" . '</th>';
            print '</tr>';
        }
    }
    print '</tbody>';
    print '</table>';
    print '</div>';


}

function get_source_code_block($param)
{
    $out = '<div class="source-code">';
    $out .= '<span>' . 'Source PHP-code:' . '</span>';
    $out .= print_func($param);
    $out .= '</div>';

    return $out;
}

function print_func($func_name)
{
    $reflect = new ReflectionFunction($func_name);
    $line_num = 0;
    $doxygen = NULL;
    $fp = fopen($reflect->getFileName(), 'r');
    $out = '<pre>';
    $out .= '<code>';
    while (!feof($fp) && ($line_num < ($reflect->getStartLine() - 1))) {
        $line = fgets($fp);
        ++$line_num;

        if (substr($line, 0, 3) == '/**') {
            $doxygen = $line;
        } elseif (isset($doxygen)) {
            $doxygen .= $line;
            if ($line_num + 1 == $reflect->getStartLine()) {
                $out .= htmlspecialchars(rtrim($doxygen));
            }
            if (strstr($line, '*/') !== FALSE) {
                $doxygen = NULL;
                // print "\n";
            }
        }
    }
    while (!feof($fp) && ($line_num < $reflect->getEndLine())) {
        $line = fgets($fp);
        ++$line_num;

        $out .= htmlspecialchars(rtrim($line) . "\n");

    }
    $out .= '</code>';
    $out .= '</pre>';

    return $out;
}

function get_m_table_with_for($array_of_i, $array_of_j)
{
    $array_of_table = array();
    for ($i = 1; $i <= count($array_of_i); $i++) {
        $ij = array();
        for ($j = 1; $j <= count($array_of_j); $j++) {
            $ij[$j] = $i * $j;
        }
        $array_of_table[$i] = $ij;
    }
    return $array_of_table;
}

function get_m_table_with_while($array_of_i, $array_of_j)
{
    $i = 1;
    while ($i <= count($array_of_i)) {
        $j = 1;
        $ij = array();
        while ($j <= count($array_of_j)) {
            $ij[$j] = $i * $j;
            $j++;
        }
        $array_of_table[$i] = $ij;
        $i++;
    }
    return $array_of_table;
}

function get_m_table_with_dowhile($array_of_i, $array_of_j)
{
    $i = 1;
    $j = 1;
    do {
        $ij = array();
        do {
            $ij[$j] = $i * $j;
            $j++;
        } while ($j <= count($array_of_j));
        $array_of_table[$i] = $ij;
        $i++;
        $j = 1;
    } while ($i <= count($array_of_j));
    return $array_of_table;
}

function get_m_table_with_foreach($array_of_i, $array_of_j)
{
    foreach ($array_of_i as $i) {
        $ij = array();
        foreach ($array_of_j as $j) {
            $ij[$j] = $i * $j;
        }
        $array_of_table[$i] = $ij;
    }
    return $array_of_table;
}

function get_m_table_form($vars, $name_of_method)
{
    // theme('m_table',$vars);

    print '<div class="task1-table task7-block">';
    print '<table border="1px" cellpadding="8" cellspacing="0" style="width: 100%;">';
    print '<tbody>';
    print '<tr align=center><td colspan="' . (count($vars) + 1) . '">' . "Multiplication table" . '</td></tr>';
    print '<tr align=center><td id="rotatetext" rowspan="' . (count($vars) + 1) . '">' . ucfirst($name_of_method) . '</td></tr>';
    for ($i = 1; $i <= count($vars); $i++) {
        print '<tr>';
        for ($j = 1; $j <= count($vars[$i]); $j++) {
            print '<td>' . $vars[$i][$j] . '</td>';
        }
        print '</tr>';
    }


    print '</tbody>';
    print '</table>';
    print '</div>';


}

function get_path_of_albums($path)
{
    $filelist = glob($path, GLOB_ONLYDIR);
    return $filelist;
}

function get_albums_form($filelist)
{
    $out = '<div class="gallery-block">';
    $out .= '<div class="sub-gallery-block">';
    foreach ($filelist as $value) {
        $list_of_pict = glob("$value/*");
        $out .= '<div class="subcontainer">';
        $out .= '<div class="upper_block">';
        $out .= '<a href="http://adci-practice.ru/' . $list_of_pict[0] . '"><div
        style="background: url(' . $list_of_pict[0] . '); background-size: cover;"
        class="upper_block_img"></div></a>';
        $out .= '</div>';
        array_shift($list_of_pict);
        $count = count($list_of_pict) + 1;
        $out .= '<div class="lower_block""><ul class="ul_block">';
        for ($i = 0; $i <= 2; $i++) {
            $out .= '<a href="http://adci-practice.ru/' . $list_of_pict[$i] . '">
            <li style="background-image: url(/' . $list_of_pict[$i] . ')"></li></a>';
        }
        $out .= '</div></ul>';
        $out .= '<p class="p_of_gallery">' . substr($value, 15) . '</p>';
        $out .= '<p class="count_of_picture">' . $count . ' photos in the album' . '</p>';
        $out .= '</div>';
    }
    $out .= '</div>';
    $out .= '</div>';
    return $out;
}

function task8_generate($counts)
{
    if (!empty($counts)) {
        $check = '';
        $alfabet = range('a', 'z');
        array_push($alfabet, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $array_of_all_passwords = array();
        $count = (int)($counts);
        $out = 'Amount: ' . $count . ':';
        for ($i = 1; $i <= $count; $i++) {
            $keys_of_pass = array_rand($alfabet, 6);
            foreach ($keys_of_pass as $value) {
                $check = $check . $alfabet[$value];
            }
            if (array_search($check, $array_of_all_passwords)) {
                break;
            } else {
                $out .= '<div>';
                for ($z = 0; $z < 6; $z++) {
                    $out .= $alfabet[$keys_of_pass[$z]];
                }
                $out .= '</div>';
            }
            $array_of_all_passwords[] = $check;
        }
    }
    return $out;
}

function get_unlimit_time_limit()
{
    set_time_limit(0);
}

function get_unlimit_buffer()
{
    ini_set('memory_limit', '-1');
}

function try_to_decrypt_passwords($md5_passwords, $length)
{
    get_unlimit_time_limit(); //set time_limit = 0
    get_unlimit_buffer(); //set memory_limit = -1

    $array_of_symb = range('a', 'z');
    //now $array_of_symb include all symbols from 'a' to 'z' and from '0' to '9'
    array_push($array_of_symb, '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    // copy $array into other array for upgrade symbols in process of bruteforce
    $copy_array = $array_of_symb;

    /*
     * Here is the process of bruteforce the passwords.
     * After the first checking the $array_of_symb will be upgrade to $new_array
     * with a help of $copy_array.
     * For example, after the first iteration we have a array with values of 'aa',
     * 'ab' and so on.
     * After the second we have a 'aaa', 'aab', ..., '998', '999'.
     */
    for ($i = 1; $i <= $length; $i++) {
        $counter_of_iter = 0;
        for ($j = 0; $j < count($md5_passwords); $j++) {
            for ($q = 0; $q < count($array_of_symb); $q++) {
                if (md5($array_of_symb[$q]) == $md5_passwords[$j]) {
                    //Found passwords
                    $answer[] = $array_of_symb[$q] . "=" . $md5_passwords[$j];
                }
            }
            $counter_of_iter++;
        }
        if (($counter_of_iter == count($md5_passwords)) and ($i != $length)) {
            $num = 0;
            for ($new = 0; $new < count($array_of_symb); $new++) {
                for ($copy = 0; $copy < count($copy_array); $copy++) {
                    $new_array[$num] = $array_of_symb[$new] . $copy_array[$copy];
                    $num++;
                }
            }

        }
        $array_of_symb = $new_array;
    }
    return $answer;
}


database_connect();
