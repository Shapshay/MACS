<form method="post" name="MR_Form">
<input type="hidden" name="m_nick">
<input type="hidden" name="m_email">
<input type="hidden" name="m_sex">
<input type="hidden" name="m_birthday">
</form>
<script>
function PswControl(){
psw1 = $('#reg_password1').val();
psw2 = $('#reg_password2').val();
if(psw1!=psw2){
	$('#psw_img').attr("src",'images/krest_reg.png');
}
else{
	$('#psw_img').attr("src",'images/gal_reg.png');
}
}
function PswControl2(){
psw1 = $('#reg_password1').val();
psw2 = $('#reg_password2').val();
if(psw1!=psw2){
	alert($('#msg2').val());
	return false;
}
else{
	return true;
}
}
</script>
<script type="text/javascript">
jQuery(function($) {
	$.mask.definitions['~']='[+-]';
	$('#reg_date_bird').mask('9999-99-99');
});
</script>
<form method="post" id="blokForm" name="blokForm" onsubmit="return PswControl2();">
<input type="hidden" name="msg" value="{MSG_REQUIRED_FIELDS}">
<input type="hidden" name="msg2" id="msg2" value="{STR_CONFIRM_PSW_ERR}" />
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%" style="margin:-30px 0px -20px 0px;">
<tr>
<td align="center" style="padding-top:25px;">
<h1><span class="akcia">Регистрация</span></h1>
</td>
</tr>
<tr>
<td height="342" valign="top" align="center" style="padding:40px 30px 30px 30px;">
<table cellpadding="5" cellspacing="0" border="0" width="700">
<tr><td height="30" colspan="3" class="registracia" align="center"><font color="#FF0000">{RESULT}</font></td></tr>
<tr>
<td height="30" width="144" class="registracia">
E-mail:
</td>
<td width="158" height="30" style="padding-left:20px;">
<input type="text" class="tup required" name="reg_email" required="1">
</td>
<td height="30" class="registracia2" style="padding-left:20px;" align="left">
(будет использоваться для начисления бонусов)
</td>
</tr>
<tr>
<td height="30" width="144" class="registracia">
Пароль:
</td>
<td height="30" style="padding-left:20px;">
<input type="password" class="tup required" name="reg_password1" id="reg_password1" required="1">
</td>
<td height="30" class="registracia2" style="padding-left:20px;" align="left">
(заполняется латинскими буквами и цифрами)
</td>
</tr>
<tr>
<td height="30" width="144" class="registracia">
Повторите пароль:
</td>
<td height="30" style="padding-left:20px;">
<input type="password" class="tup required" name="reg_password2" id="reg_password2" onchange="PswControl();" onkeyup="PswControl();" required="1">
</td>
<td height="30" style="padding-left:20px;" align="left">
<img src="images/krest_reg.png" id="psw_img">
</td>
</tr>
<tr>
<td height="30" width="144" class="registracia">
{STR_CITY}:
</td>
<td width="158" height="30" style="padding-left:20px;" colspan="2" align="left">
<select name="reg_city">
{CITYSEL_ROWS}
</select>
</td>
</tr>
<tr>
<td height="30" width="144" class="registracia">
{STR_FIO}:
</td>
<td width="158" height="30" style="padding-left:20px;" colspan="2" align="left">
<input type="text" class="tup required" name="fio" required="1">
</td>
</tr>
<tr>
<td height="30" width="144" class="registracia">
{STR_LAST_NAME}:
</td>
<td width="158" height="30" style="padding-left:20px;" colspan="2" align="left">
<input type="text" class="tup" name="last_name" required="1">
</td>
</tr>

<tr>
<td height="30" width="144" class="registracia">
Пол:
</td>
<td colspan="2" height="30" class="registracia" style="padding-left:20px;" align="left">
<input type="radio" name="reg_pol" checked="checked" value="0">M &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="reg_pol" value="1">Ж
</td>
</tr>
<tr>
<td height="30" width="236" style="padding:0px 20px 0px 220px;" colspan="3" align="left">
<img src="capcha.php" border="0" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="reg_code" class="tup3 required" required="1">
</td>
</tr>
<tr>
<td colspan="3" align="center" style="padding:20px 20px 0px 0px;">
<input type="submit" value="" class="kn_reg" name="kn_reg" />

</form>