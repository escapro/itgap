<?php require('blocks/head.php') ?>

<body class="editor-page page">
	<div class="main">
		<?php require('blocks/header.php'); ?>
		<?php require('blocks/editor-nav.php'); ?>
		<div class="page-content">
			<div class="container row-6">
				<div class="main-row centered">
					<div class="col page-main page-main__left">
						<?php require('templates/editor.tpl.php') ?>
					</div>
				</div>
			</div>
		</div>
		<?php require('blocks/footer.php') ?>
	</div>
</body>

</html>