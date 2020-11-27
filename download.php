<?php

require_once(__DIR__ . '/Includes/Bd/Consultas.php');
$id = '';
$valid = false;

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $valid = Bd::getBuy($id);
}

if($valid)
{
    header('Content-disposition: attachment; filename=folder_test.zip');
    header('Content-type: application/octet-stream');
    readfile(__DIR__ . '/Includes/folder_test.zip');
    $success = Bd::changeStatus($id);
}
else
{
    header('Location: http://new.cdn20.com/error.html');
}