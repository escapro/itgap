<?php require('blocks/head.php') ?>

<body class="page home-page">
	<div class="main">
		<?php require('blocks/header.php'); ?>

		<div class="page-content">
			<div class="container row-6">
				<div class="main-row row-middle">
					<form class="login-form user-form" action="#">
						<h1 class="mb-2">Авторизация</h1>
						<div class="form-field">
							<label class="form-label" for="email">Email</label>
							<input class="form-input" id="email" type="email" placeholder="Введите email адрес">
						</div>
						<div class="form-field">
							<label class="form-label" for="password">Пароль</label>
							<input class="form-input" id="password" type="password" placeholder="Ваш пароль">
						</div>
						<div class="mt-2">
							<button class="btn btn-primary">Войти</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php require('blocks/footer.php') ?>
	</div>
</body>

</html>