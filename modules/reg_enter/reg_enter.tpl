<div class="text9" style="top: 70px; right: 40px;"><a href="" window="login_window" id="ent_link">Вход</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="" window="register_window" id="reg_link">Регистрация</a></div>
	
	<div class="login_window" id="login_window" style=" display:none;">
		<div class="title">Вход на сайт</div>
		<div class="content" style="height: 306px;">
			<div class="message"{REM_RESULT_STYLE}>{REG_ENT_ERR}</div>
			<div style="{SHOW_E_FORM}">
				<center>
				<div class="text4" style="left: 200px; font-size: 18px; color: #3a3a3a; margin-top:-55px;">
					Авторизуйтесь<br />
					через социальную сеть
				</div>
				</center>
				<div style="margin-top:55px;">
				<script src="//ulogin.ru/js/ulogin.js"></script>
				<div id="uLogin" data-ulogin="display=panel;fields=first_name,last_name,email,network,phone;providers=vkontakte,facebook;hidden=;redirect_uri=http%3A%2F%2Flk.coap.kz"></div>
	
				<form action="/" method="post" style="left: 130px; margin-top:20px;" name="frmAuth">
					<input type="hidden" name="type_reg" value="1" />
					<input type="hidden" name="chk_save" value="1" />
					<input type="text" name="e_email" placeholder="Введите e-mail">
					<input type="password" name="e_password" placeholder="Введите пароль">
					<input type="submit" value="Вход на сайт"><br />
					<div class="text9" style="left: 120px; margin-top:10px;"><a href="" window="login_rem_window" id="rem_link">Забыли пароль?</a></div>
				</form>
				</div>
			</div>
		</div>
	</div>
	{REG_DIV_HIDE}
	
	<div class="login_window" id="login_rem_window" style=" display:none;">
		<div class="title">Востановление пароля</div>
		<div class="content" style="height: 260px;">
			<div class="message">{REM_ERR}</div>
			<div style="{SHOW_REM_FORM}">
				<form action="/" method="post" style="left: 130px; margin-top:20px;" name="RemForm" id="RemForm">
					<input type="text" name="rem_email"  id="rem_email" placeholder="Введите e-mail">
					<input type="button" name="submit_rem" value="Востановить пароль" class="login_window_btn" onclick="checkFieldsRem(document.RemForm, $('#msg').val());"><br />
				</form>
			</div>
		</div>
	</div>
	{REM_DIV_HIDE}