<?php

$fl = '../../vendor/autoload.php';
if ( !is_file($fl) )
{
    $fl = '../../../' . $fl;
}

require $fl;