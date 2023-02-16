<?php

function checkName($name)
{
    $ret = '';

    if (empty($name)) {
        $ret = 'Please enter name';
    } else if (strlen($name) > 40) {
        $ret = 'Full name is too long!';
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $ret = 'Only letters and whitespaces allowed!';
    }

    return $ret;
}
