<?php require('blocks/head.php') ?>

<body class="page home-page">
	<div class="main">
		<?php require('blocks/header.php'); ?>
		<?php require('blocks/main-nav.php'); ?>
		<div class="page-content">
			<div class="container row-6">
				<div class="main-row">
					<div class="col page-main page-main__left">
					<?php require('templates/tag-navbar.php'); ?>
						<?php if(isset($content_title)): ?>
							<div class="block mb-2 section-head">
								<h1 class="section-head__title"><?=$content_title;?></h1>
								<h2 class="section-head__subtitle"><?=$current_tag_description;?></h2>								
							</div>
						<?php endif; ?>
						<?php switch ($content_type) {
								case 'block':
								require('templates/home.tpl.php');
									break;
								case 'inline':
								require('templates/posts_inline.tpl.php');
									break;
							} ?>
							<div class="centered">
								<button class="btn btn-large btn-primary load-more">Показать ещё</button>
							</div>
					</div>
					<div class="col sidebar right-sidebar">
						<?php require('templates/sidebars/main_sidebar.php');?>
					</div>
				</div>
			</div>
		</div>
		<?php require('blocks/footer.php') ?>
	</div>
</body>

</html>