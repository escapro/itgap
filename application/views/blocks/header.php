<header class="header">
	<div class="container flex">
		<div class="flex header-left">
			<a href="/" class="logo">
			<img src="/media/images/logo.svg" alt="image">
				<span>itGap</span>
			</a>
			<ul class="main-menu dsktp-show">
				<li><a href="/">Главная</a></li>
				<li><a href="#">Лучшее</a></li>
			</ul>
		</div>
		<div class="flex header-right">
			<?php if ($this->ion_auth->is_admin()):?>
			<div class="header-right-block header-profile-block">
				<a href="/user"><div class="profile-icon"></div></a>
			</div>
			<?php else: ?>
			<div class="header-right-block header-profile-block">
				<div class="auth-form-btn profile-icon">
			</div>
			<div class="header-dropdown auth-block">
				<form>
					<div class="form-field">
						<input class="form-input" type="text" name="email" placeholder="Введите email">
						<input class="form-input" type="password" name="password" placeholder="Введите пароль">
						<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
						<button class="btn btn-primary">Войти</button>
					</div>
				</form>
			</div>
			<?php endif;?>
			<div class="search-form-btn header-right-block header-search-block">
				<div class="search-icon"></div>
			</div>
			<div class="header-dropdown search-block">
				<form method="GET" action="/search">
					<div class="form-field">
						<input class="form-input" type="text" name="q" placeholder="Введите поисковый запрос" autofocus>
						<button class="btn btn-primary">Поиск</button>
					</div>
				</form>
			</div>
			<!-- <div class="header-right-block header-toggle_main_menu-block">
				<div class="menu-icon"></div>
			</div> -->
		</div>
	</div>
	<div class="mobile-menu">
		
	</div>
</header>