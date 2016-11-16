<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <base href="http://{BASE_URL}">
	<!--                       CSS                       -->
	<link rel="stylesheet" href="css/reset.css" type="text/css" media="screen" />
	<!-- Main Stylesheet -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
	<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
	<link rel="stylesheet" href="css/invalid.css" type="text/css" media="screen" />
	<!-- Internet Explorer Fixes Stylesheet -->
	<!--[if lte IE 7]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<![endif]-->
	<link rel="stylesheet" href="styles2.css" type="text/css" media="screen" />
	<!--                       Javascripts                       -->
	<!-- jQuery -->
	<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<!-- jQuery Configuration -->
	<script type="text/javascript" src="js/simpla.jquery.configuration.js"></script>



	<!-- ALERT -->
	<link rel="stylesheet" href="inc/swetalert/sweetalert.css" />
	<script src="inc/swetalert/sweetalert.min.js"></script>
	<!-- /ALERT -->

	<!-- Data Table -->
	<link rel="stylesheet" href="adm/inc/data_table/jquery.dataTables.min.css" />
	<script src="adm/inc/data_table/jquery.dataTables.min.js"></script>
    {AUTH}
	{META}
</head>
<body>
<div  style="display:none;" id="tmp_name"><template style="display:none;">Внутреняя</template></div>
<script type="text/javascript">
	$("#tmp_name").hide();
</script>
<div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

	<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->

			<h1 id="sidebar-title" align="center">
				<a href="/"><img src="images/logo.png" alt="Perch 1.0" width="100" /></a><br>
				<a href="#">СТО 1.0</a></h1>

			<!-- Sidebar Profile links -->
			<div id="profile-links">
				Здравствуйте, <a href="system.php?menu=777" title="Редактирование профиля">{ROOT_NAME}</a><!--, у Вас <a href="#messages" rel="modal" title="3 сообщения">3 сообщения</a>--><br />
				<br />
				<a href="/index.php?exit" title="Выход">Выход</a>
			</div>

			<ul id="main-nav">  <!-- Accordion Menu -->

				{MENU_PAGES}



			</ul> <!-- End #main-nav -->

		</div></div> <!-- End #sidebar -->

	<div id="main-content"> <!-- Main Content Section with everything -->
		<!-- Page Head -->
		<h2>{PAGE_TITLE}</h2>
		<div class="clear"></div> <!-- End .clear -->

		<div class="content-box"><!-- Start Content Box -->

			{CONTENT}

		</div> <!-- End .content-box -->



		<div id="footer">
			<small> <!-- Remove this notice or replace it with whatever you want -->
				&#169; Copyright 2016 Авто Клуб Казахстана | <a href="#">Top</a>
			</small>
		</div><!-- End #footer -->
		<input type="hidden" id="copy_page" value="0">
	</div> <!-- End #main-content -->

</div></body>
</body>
</html>