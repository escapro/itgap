<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?=$page_title;?></title>
	<link rel="stylesheet" type="text/css" href="/media/css/style.min.css">
	<link rel="stylesheet" type="text/css" href="/media/css/admin.min.css">
	<link rel="stylesheet" type="text/css" href="/media/fonts/Iconfonts/css/fontello.css">
	<script type="text/javascript" src="/media/js/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="/media/js/main.js"></script>
	<?php echo isset($head_more) ? $head_more : '';?>
</head>

<body class="page home-page admin-panel">
	<div class="main">
		<header class="header">
			<div class="container flex">
				<div class="flex header-left">
					<a href="/" class="logo">
						Admin panel
					</a>
					<ul class="main-menu dsktp-show">
						<li><a href="/">Главная</a></li>
						<li><a href="#">Лучшее</a></li>
						<li><a href="#">О нас</a></li>
					</ul>
				</div>
				<div class="flex header-right">
					dfsfd
				</div>
			</div>
		</header>
		<div class="page-content">
			<div class="main-row">
				<div class="admin-menu">
					<div class="admin-menu__item"><a href="/admin">Консоль</a></div>
					<div class="admin-menu__item"><a href="/admin/in_moderation">На проверке</a></div>
					<div class="admin-menu__item"><a href="#">Выход</a></div>
				</div>
				<div class="admin-content">
				<?php require('pages/'.$page.'.php');?>
				</div>
			</div>
		</div>
		<footer class="page-footer">
			<div class="container">
				<div class="footer-right">© 2019 itgap.az</div>
			</div>
		</footer>
	</div>
</body>

</html>