<?php

if ($argc !== 3)
{
    echo 'Usage [password] [salt]';
    die;
}

echo sha1($argv[2] . $argv[1]); //salt . password
