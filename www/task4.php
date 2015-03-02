<?php

title_of_task('Task 4', 'Bruteforce of the passwords, which was encrypted by MD5');

//Enter your encrypted passwords by MD5 into array below
$md5_passwords = array(
    '23586e8a62e5ee0d6f5014d849601c0c',
    'e7806b130b429fc9b5890608a2c60675',
    '713ff7abce2ef30fc4f532bb68e92a1b',
    '67dd64c651270524961da7a6686008ba',
);

print form_ul($md5_passwords);
//Enter into $maximum_length_of_password the value of maximum amount of characters in the passwords
$maximum_length_of_password = 4;

/*This function is trying to find matching passwords.
 *This function returns an array with found passwords.
 *The first @param of this function is array of encrypted passwords.
 *The second @param is the maximum length of password.
 */
$answers = try_to_decrypt_passwords($md5_passwords, $maximum_length_of_password);

//If matches was found, print it. If not, print phrase "Not found!"
if (isset($answers)) {
    print form_ul_answers($answers);
} else {
    print "Not found!";
}

print get_source_code_block('try_to_decrypt_passwords');

?>