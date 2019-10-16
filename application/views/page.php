<?php require('blocks/head.php') ?>
<body class="page home-page">
	<div class="main">
		<?php require('blocks/header.php'); ?>
		<?php require('blocks/main-nav.php'); ?>
		<div class="page-content">
			<div class="container row-6">
				<div class="main-row">
					<div class="col page-main page-main__left">
					<?php require('templates/'.$page.'.php'); ?>
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