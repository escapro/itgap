<?php require('blocks/head.php') ?>

<body class="page home-page">
	<div class="main">
		<?php require('blocks/header.php'); ?>
		<?php require('blocks/main-nav.php'); ?>
		<div class="page-content">
			<div class="container row-6">
				<div class="main-row row-middle">
					<div class="col sidebar left-sidebar">
						<?php require('templates/sidebars/user_sidebar.php');?>
					</div>
					<div class="col page-main page-main__right">
					<?php
						if(isset($userPageBlock)) {
							switch ($userPageBlock) {
								case 'profile':
									require('templates/user_profile.tpl.php');
								break;
								case 'admin':
									require('templates/admin/main.tpl.php');
								break;
								case 'posts':
									require('templates/user_posts.tpl.php');
								break;
								case 'drafts':
									require('templates/user_drafts.tpl.php');
								break;
								case 'moderations':
									require('templates/user_moderations.tpl.php');
								break;
								case 'active_posts':
									require('templates/user_posts.tpl.php');
								break;
							}
						}
					?>
					</div>
				</div>
			</div>
		</div>
		<?php require('blocks/footer.php') ?>
	</div>
</body>

</html>