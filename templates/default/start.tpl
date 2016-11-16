<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta name="viewport" content="width=500">
	<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
{META}
	<script src="adm/js/jquery-1.3.2.min.js"></script>
	{TOP_BTN}
	<script type="application/javascript">
		function PageOK() {
			window.location = '{URL_OK}';
		}
		function PageErr() {
			window.location = '{URL_ERR}';
		}
	</script>
</head>
<body bgcolor="#8093E3">
<div  style="display:none;" id="tmp_name"><template style="display:none;">Главная</template></div>
<script type="text/javascript">
	$("#tmp_name").hide();
</script>
<button type="button" onclick="PageOK();" id="ok_page" class="top_btn btn_ok_page">Доставлен</button>
<button type="button" onclick="PageErr();" id="err_page" class="top_btn btn_err_page">Ошибка</button><br>
<img src="images/logo.png" alt="Mobile Delivery"><br>
<h1>Mobile Delivery</h1>
<div class="parent2">
	<div class="block">
			<b>Здравствуйте<br>{HELLO}</b>
	</div>
</div>
</body>
</html>