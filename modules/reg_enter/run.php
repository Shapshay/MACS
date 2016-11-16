<?php
# SETTINGS #############################################################################

$moduleName = "reg_enter";

$prefix = "./modules/".$moduleName."/";

$tpl->define(array(
		$moduleName => $prefix . $moduleName.".tpl",
		$moduleName . "kab" => $prefix . "kab.tpl",
		$moduleName . "mail" => $prefix . "mail.tpl",
		$moduleName . "mail2" => $prefix . "mail2.tpl",
		$moduleName . "mail3" => $prefix . "mail3.tpl",
));
# SETTINGS ##############################################################################

$_sendTo = META_EMAIL;				// E-mail ����������
$_sendFrom = $_sendTo;								// E-mail �����������
$_mailSubject = getval("REG_EMAIL_SUBJECT");		// ���� ������
$_mailFrom = "COAP.KZ";		// ������� ������

# MAIN #################################################################################
//echo $_SERVER['HTTP_HOST'];
// ����� ������
$rem_psw_bool = false;
if(isset($_GET['rem_activ'])){
	$result = db_query("SELECT id, email FROM users WHERE MD5(email) = '".$_GET['rem_activ']."' LIMIT 1");
	if (db_num_rows($result) > 0){
		$row = db_fetch_array($result);
		$psw = generate_password(6);
		$sql = "UPDATE users SET 
						password = '".md5($psw)."'
					WHERE id = ".$row['id'];
		db_query($sql);

		//�������� ������
		$tpl->assign("USER_LOGIN", $row['email']);
		$tpl->assign("USER_PSW", $psw);
		$_sendTo = $row['email'];					// E-mail ����������
		$_sendFrom = META_EMAIL;				// E-mail �����������
		$_mailSubject = getval("STR_REM_MAIL_COMPLEET");	// ���� ������

		$tpl->parse("TEMP", $moduleName . "mail3");

		sendMail3($_sendTo, $_mailSubject, $tpl->fetch("TEMP"), $_mailFrom, $_sendFrom);
		$rem_psw_bool = true;
	}
}


//����������� ����� ���.����
if(isset($_POST['token'])){
	//$soc_net = true;
	//echo "TOKEN<br>";
	$s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
	$user = json_decode($s, true);
	//print_r($user);
	if(isset($user['email'])&&$user['email']!=''){
		//echo $user['email']."<br>";
		if(!checkUsersEmail($user['email'])){
			// �� ���������� � ����
			$sql = "INSERT INTO users SET 
						email = '".$user['email']."',
						password = 'c4ca4238a0b923820dcc509a6f75849b',
						network = '".$user['network']."',
						name = '".$user['first_name']." ".$user['last_name']."',
						phone = '".$user['phone']."',
						activ = 1,
						data_reg = NOW()";
			db_query($sql);
			$usrname = $user['email'];
			$usrpass = '1';
			session_name('SID');
			@session_start();
			//@session_register('login');
			$_SESSION['login'] = $usrname;
			//@session_register('password');
			$_SESSION['password'] = $usrpass;
			//@session_register('soc');
			$_SESSION['soc'] = 1;
			$_SESSION['profile'] = 0;
			// ��������� ����� � ������ � �����, ������� ���� �� �������� "���������"
			if (isset($_POST['chk_save'])) {
				$cookie_value = $usrname."|".$usrpass."|".$_SERVER['HTTP_HOST'];
				//$cookie_value = crypt_string($cookie_value);
				setcookie("k_auth", $cookie_value, time()+60*60*24*30, "", $_SERVER['HTTP_HOST']);
			} else {
				if (isset($_COOKIE['k_auth'])) {
					$cookie_value = "";
					setcookie("k_auth", $cookie_value, 0, "", $_SERVER['HTTP_HOST']);
				}
			}
			//print_r($_SESSION);
			header("Location: http://".$_SERVER['HTTP_HOST']."/kabinet");
		}
		else{
			// ���������� � ����
			$usrname = $user['email'];
			$result = db_query("SELECT password FROM users WHERE email = '".$usrname."' LIMIT 1");
			$row = db_fetch_array($result);
			$usrpass = $row['password'];
			session_name('SID');
			@session_start();
			//@session_register('login');
			$_SESSION['login'] = $usrname;
			//@session_register('password');
			$_SESSION['password'] = $usrpass;
			//@session_register('soc');
			$_SESSION['soc'] = 1;
			$_SESSION['profile'] = 0;
			// ��������� ����� � ������ � �����, ������� ���� �� �������� "���������"
			if (isset($_POST['chk_save'])) {
				$cookie_value = $usrname."|".$usrpass."|".$_SERVER['HTTP_HOST'];
				//$cookie_value = crypt_string($cookie_value);
				setcookie("k_auth", $cookie_value, time()+60*60*24*30, "", $_SERVER['HTTP_HOST']);
			} else {
				if (isset($_COOKIE['k_auth'])) {
					$cookie_value = "";
					setcookie("k_auth", $cookie_value, 0, "", $_SERVER['HTTP_HOST']);
				}
			}
			//print_r($_SESSION);
			header("Location: http://".$_SERVER['HTTP_HOST']."/kabinet");
		}
	}

}
// ������� �����������
if (isset($_POST['e_password'])) {
	$usrname = substr(SuperSaveStr($_POST['e_email']), 0, 50);
	$usrpass = substr(SuperSaveStr($_POST['e_password']), 0, 20);

	$result = db_query("SELECT * FROM users WHERE email = '".$usrname."' AND password = MD5('".$usrpass."') LIMIT 1");
	//print_r($_POST);

	if (db_num_rows($result)) {

		$row = db_fetch_array($result);
		if($row['activ']==1){
			//echo "YES";
			session_name('SID');
			@session_start();
			//@session_register('login');
			$_SESSION['login'] = $usrname;
			//@session_register('password');
			$_SESSION['password'] = $usrpass;
			//@session_register('soc');
			$_SESSION['soc'] = 0;
			$_SESSION['profile'] = 0;
			// ��������� ����� � ������ � �����, ������� ���� �� �������� "���������"
			if (isset($_POST['chk_save'])) {
				$cookie_value = $usrname."|".$usrpass."|".$_SERVER['HTTP_HOST'];
				//$cookie_value = crypt_string($cookie_value);
				setcookie("k_auth", $cookie_value, time()+60*60*24*30, "", $_SERVER['HTTP_HOST']);
			} else {
				if (isset($_COOKIE['k_auth'])) {
					$cookie_value = "";
					setcookie("k_auth", $cookie_value, 0, "", $_SERVER['HTTP_HOST']);
				}
			}
			//print_r($_SESSION);
			header("Location: http://".$_SERVER['HTTP_HOST']."/kabinet");
		}
		else{
			//echo "NO1";
			$tpl->assign("REG_ENT_ERR", getval("STR_REG_ENT_ERR2").'<br /><img src="images/reg1.png" />');
			$tpl->assign("REG_DIV_HIDE", "<script>
					$(document).ready(function() {
						$('#ent_link').click();
					});
				</script>");
			$tpl->assign("REG_ACTIV", md5($row['email']));
			$_sendTo = $row['email'];					// E-mail ����������
			$_sendFrom = META_EMAIL;				// E-mail �����������
			$_mailSubject = getval("REG_EMAIL_SUBJECT");	// ���� ������

			$tpl->parse("TEMP", $moduleName . "mail");

			sendMail3($_sendTo, $_mailSubject, $tpl->fetch("TEMP"), $_mailFrom, $_sendFrom);

			/*
			$loc_url = getCodeBaseURL('index.php?city='.CITY_ID.'&menu='.$_GET['menu'].'&result=4');
			*/
			$tpl->assign("RESULT", getval("STR_REG_COMPL_MAIL1"));
			$tpl->assign("SHOW_E_FORM", "display:none;");
		}


	}
	else{
		//echo "NO2";
		$tpl->assign("SHOW_E_FORM", "");
		$tpl->assign("REG_ENT_ERR", getval("STR_REG_ENT_ERR"));
		$tpl->assign("REG_DIV_HIDE", "<script>
				$(document).ready(function() {
					$('#ent_link').click();
				});
			</script>");
	}



}
else{
	//echo "NO3";
	$tpl->assign("SHOW_E_FORM", "");
	$tpl->assign("REG_ENT_ERR", "");
	$tpl->assign("REG_DIV_HIDE", '');
}


if(!isset($_POST['exit'])){
	session_name('SID');
	@session_start();

	// ��������� ����� � ������ �� ���
	$usr_login = '';
	$usr_passw = '';

	if (isset($_COOKIE['k_auth'])) {
		$str = $_COOKIE['k_auth'];
		//echo $str."+<br>";
		if($str!=''){
			$login_info = explode("|", $str);
			if (is_array($login_info)) {
				$host = $login_info[2];
				if ($host == $_SERVER['HTTP_HOST']) {
					$usr_login = $login_info[0];
					$usr_passw = $login_info[1];
					$save = ' checked';
					//@session_register('login');
					$_SESSION['login'] = $usr_login;
					//@session_register('password');
					$_SESSION['password'] = $usr_passw;
				}
			}
		}
	}
}
else{
	$cookie_value = "";
	/*
	setcookie("k_auth", $cookie_value, 0, "", $_SERVER['HTTP_HOST']);
	setcookie('k_auth', '', 1, '/', '.coap.kz', false, true);
	setcookie('k_auth', '', 1, '/almaty', '.coap.kz', false, true);
	*/
	setcookie ("k_auth", "", time() - 3600);
	setcookie ("k_auth", "", time() - 3600, "/", ".coap.kz", 1);
	session_name('SID');
	@session_start();
	unset($_SESSION['login'], $_SESSION['password']);
	header("Location: http://".$_SERVER['HTTP_HOST']);
}
//echo $_SERVER['HTTP_HOST'];

if (!checkAuth()) {
	if(isset($_POST['rem_email'])){
		// ������������� ������
		$usrname = substr($_POST['rem_email'], 0, 50);
		$result = db_query("SELECT * FROM users WHERE email = '".$usrname."' LIMIT 1");
		if (db_num_rows($result)) {

			$row = db_fetch_array($result);
			$tpl->assign("REM_ERR", getval("STR_REM_SEND").'<br /><img src="images/reg1.png" />');
			$tpl->assign("REM_DIV_HIDE", "<script>
					$(document).ready(function() {
						$('#rem_link').click();
					});
				</script>");
			$tpl->assign("REM_ACTIV", md5($row['email']));
			$_sendTo = $row['email'];					// E-mail ����������
			$_sendFrom = META_EMAIL;				// E-mail �����������
			$_mailSubject = getval("REM_EMAIL_SUBJECT");	// ���� ������

			$tpl->parse("TEMP", $moduleName . "mail2");

			sendMail3($_sendTo, $_mailSubject, $tpl->fetch("TEMP"), $_mailFrom, $_sendFrom);
			$tpl->assign("REM_RESULT_STYLE", ' style="color:#6875BF;"');
			$tpl->assign("SHOW_REM_FORM", "display:none;");
		}
		else{
			$tpl->assign("REM_RESULT_STYLE", '');
			$tpl->assign("REM_ERR", getval("STR_REM_ERR"));
			$tpl->assign("REM_DIV_HIDE", "<script>
					$(document).ready(function() {
						$('#rem_link').click();
					});
				</script>");
			$tpl->assign("SHOW_REM_FORM", "");
		}
	}
	else{
		// ����������� ����� ������������������
		if($rem_psw_bool){
			$tpl->assign("REM_RESULT_STYLE", ' style="color:#6875BF;"');
			$tpl->assign("REM_ERR", getval("STR_REM_FINISH").'<br /><img src="images/reg1.png" />');
			$tpl->assign("SHOW_REM_FORM", "display:none;");
			$tpl->assign("REM_DIV_HIDE", "<script>
					$(document).ready(function() {
						$('#rem_link').click();
					});
				</script>");
		}
		else{
			$tpl->assign("REM_RESULT_STYLE", '');
			$tpl->assign("REM_ERR", '');
			$tpl->assign("SHOW_REM_FORM", "");
			$tpl->assign("REM_DIV_HIDE", "");
		}
	}
	$tpl->parse(strtoupper($moduleName), $moduleName);
}
else{
	session_name('SID');
	@session_start();
	/*
	if (!session_is_registered('fb')){
		$result = db_query("SELECT * FROM users WHERE password = MD5('".$_SESSION['password']."') AND email = '".$_SESSION['login']."' LIMIT 1");
	}
	else{
		$result = db_query("SELECT * FROM users WHERE email = '".$_SESSION['login']."' LIMIT 1");
	}
	*/
	$tpl->parse(strtoupper($moduleName), ".".$moduleName . "kab");
}
	
?>
