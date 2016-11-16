<?php
$moduleName = "reg";
$prefix = "./modules/".$moduleName."/";

$tpl->define(array(
		$moduleName => $prefix . $moduleName.".tpl",
	));
# MAIN #################################################################################
if (isset($_POST['send'])) {
    $usrname = substr($_POST['lgn'], 0, 25);
    $usrpass = substr($_POST['psw'], 0, 30);
    if (preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $usrname)) $usrname = "";
    if (preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $usrpass)) $usrpass = "";
    $rows = $dbc->dbselect(array(
            "table"=>"users",
            "select"=>"*",
            "where"=>"login = '".$usrname."' AND password = '".$usrpass."'",
            "limit"=>1
        )
    );
    $numRows = $dbc->count;
    if ($numRows > 0) {
        $row = $rows[0];
        session_name('USER');
        @session_start('USER');
        $_SESSION['lgn'] = $usrname;
        $_SESSION['psw'] = $usrpass;
        // Сохраняем логин и пароль в куках, удаляем если не отметили "запомнить"
        if (isset($_POST['member'])) {
            $cookie_value = $usrname."|".$usrpass;
            setcookie("sto", $cookie_value, time()+60*60*24*30, "", $_SERVER['HTTP_HOST']);
        } else {
            if (isset($_COOKIE['sto'])) setcookie("sto", "", 0);
        }

        //echo getItemCHPU($row['page_id'], 'pages');
        header("Location: /".getItemCHPU($row['page_id'], 'pages'));
        exit;
    }
    else{
        echo ('
			<script language="JavaScript">
				alert("Логин или пароль некорректны !!!");
			</script>
		');
    }

}
if (isset($_COOKIE['sto'])) {
    $login_info = explode("|", $_COOKIE['sto']);
    if (is_array($login_info)) {
        $tpl->assign("USR_LOGIN", $login_info[0]);
        $tpl->assign("USR_PASSW", $login_info[1]);
        $tpl->assign("USR_SAVE", 'checked');
    }
}
else{
    $tpl->assign("USR_LOGIN", '');
    $tpl->assign("USR_PASSW", '');
    $tpl->assign("USR_SAVE", '');
}

$tpl->parse(strtoupper($moduleName), $moduleName);


?>