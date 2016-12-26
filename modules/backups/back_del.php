<?php
/**
 * Created by PhpStorm.
 * User: Skiv
 * Date: 26.12.2016
 * Time: 11:49
 */
error_reporting (E_ALL);
ini_set("display_errors", 1);
require_once("../../adm/inc/BDFunc.php");
$dbc = new BDFunc;
date_default_timezone_set ("Asia/Almaty");

// получение заголовка страницы
function isUser($u_id) {
    global $dbc;
    $row = $dbc->element_find_by_field('users','ver_id',$u_id);
    if($dbc->count>0){
        return true;
    }
    else{
        return false;
    }

}

// чистим текстовую $_GET[]
function SuperSaveGETStr($name) {
    $name = preg_replace("/[^a-zA-Z0-9_]/","",$name);
    return $name;
}

// Чистим числовую переменную
function SuperSaveInt($name) {
    $name = strip_tags($name);
    $name = trim($name);
    $name = iconv("utf-8", "windows-1251", $name);
    $name = preg_replace("/[^0-9]/i", "", $name);
    $name = iconv("windows-1251", "utf-8", $name);
    if($name=='') $name = 0;
    return $name;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$u_id = '';
$back_id = 0;
if(isset($_POST['back_id'])){
    $back_id = SuperSaveInt($_POST['back_id']);
}
if(isset($_POST['u_id'])){
    $u_id = SuperSaveGETStr($_POST['u_id']);
}
if(isUser($u_id)&&$back_id!=0){
    $dir = '../../backups/backups_'.$u_id;
    $row = $dbc->element_find('backups',$back_id);
    $file_name = $row['name_back'];
    
    if($row['user_id']==$u_id){
        unlink($dir.'/'.$file_name);
        $dbc->element_delete('backups',$back_id);
        $out_row['result'] = 'OK';
    }
    else{
        $out_row['result'] = 'Err';
    }
}
else{
    $out_row['result'] = 'Err';
}
header("Content-Type: text/html;charset=utf-8");
$result = preg_replace_callback('/\\\u([0-9a-fA-F]{4})/', create_function('$_m', 'return mb_convert_encoding("&#" . intval($_m[1], 16) . ";", "UTF-8", "HTML-ENTITIES");'),json_encode($out_row));
echo $result;