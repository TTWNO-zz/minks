<?php

require 'variables.php';
require 'MinksDB.php';

function checkDBError($rel, $db){
    if($rel){
        return True;
    }else{
        return $db->lastErrorMsg();
    }
}

function writeCSS($username, $db){
    global $database_file;

    $css = $db->genUserCSS($username);
    $db->close();
    file_put_contents('./css/'.$username.'-words.css', $css);
}

$db = new MinksDB($SQLITE3_DATABASE);

switch ($_POST['func']){
    case 'nu':
        $db->addMinksUser($_POST['user']);
        break;
    case 'cws':
        $db->modifyUserWord($_POST['user'], $_POST['word'], $_POST['kl']);
        writeCSS($_POST['user'], $db);
        break;
}
$db->close();
?>
