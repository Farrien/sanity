	<title><?=$PageTitle?> | Панель управления Sanity</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, shrink-to-fit=no, user-scalable=no">
	
	<!-- Basic Styles -->
	<link rel="stylesheet" type="text/css" media="all" href="//<?=$_SERVER['HTTP_HOST']?>/client/fonts.css">
	<link rel="stylesheet" type="text/css" media="all" href="//<?=$_SERVER['HTTP_HOST']?>/client/first.css">
	<!-- App Styles -->
	<link rel="stylesheet" type="text/css" media="all" href="//<?=$_SERVER['HTTP_HOST']?>/client/sn-design.css">
	<link rel="stylesheet" type="text/css" media="all" href="//<?=$_SERVER['HTTP_HOST']?>/mypanel/panel.css">
	
	<?$css_path = '/client/mypanel--' . $RO['SECTION'] . '.css';
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . $css_path)) echo '<link rel="stylesheet" type="text/css" media="all" href="//' . $_SERVER['HTTP_HOST'] . $css_path . '">';?>
	
	<!-- App Icon -->
	<link rel="icon" href="//<?=$_SERVER['HTTP_HOST']?>/res/ui/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="//<?=$_SERVER['HTTP_HOST']?>/res/ui/favicon.ico" type="image/x-icon">
	
	<!-- JS -->
	<script type="text/javascript" src="//<?=$_SERVER['HTTP_HOST']?>/client/sanity/sanity.0.1.8.js"></script>
	<script type="text/javascript" src="//<?=$_SERVER['HTTP_HOST']?>/client/sn-design.js"></script>
