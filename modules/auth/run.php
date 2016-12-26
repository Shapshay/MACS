<?php
/**
 * Created by PhpStorm.
 * User: Skiv
 * Date: 29.08.2016
 * Time: 12:18
 */
# SETTINGS #############################################################################
$moduleName = "auth";

# MAIN #################################################################################
session_name('USER');
@session_start('USER');
if(isset($_GET['exit'])){
    $_SESSION = array();
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
    exit();
}

if(isset($_SESSION['lgn'])){
    $rows = $dbc->dbselect(array(
            "table"=>"users",
            "select"=>"users.*, 
			        GROUP_CONCAT(r_user_role.role_id) as role",
            "joins"=>"LEFT OUTER JOIN r_user_role ON users.id = r_user_role.user_id",
            "where"=>"login = '".$_SESSION['lgn']."' AND password = '".$_SESSION['psw']."'",
            "limit"=>1
        )
    );
    $user_row = $rows[0];
    define("ROOT_ID", $user_row['id']);
    define("ROOT_NAME", $user_row['name']);
    $USER_ROLE = explode(",",$user_row['role']);
    $tpl->assign("ROOT_NAME", ROOT_NAME);
    $tpl->assign("ROOT_ID", ROOT_ID);
    define("VER_ID", $user_row['ver_id']);
    $tpl->assign("VER_ID", VER_ID);
}
else{
    $_SESSION = array();
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
    exit();
}
$tpl->assign(strtoupper($moduleName), "");