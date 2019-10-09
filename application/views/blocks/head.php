<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php if(APP_ENV == 'production'): ?>
		<script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(55693036, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/55693036" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131792796-2"></script>
		<script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-131792796-2');</script>
	<?php endif; ?>
	<title><?=$page_title;?></title>
	<?php if(isset($page_description)): ?>
		<meta name="description" content="<?=$page_description?>">
	<?php endif; ?>
		<meta name="keywords" content="">
	<?php 
		$a = '<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "WebSite",
			"url": "'.base_url().'",
			"name": "Itgap.ru",
			"sameAs":["https://vk.com/public176209611"],
			"potentialAction":{
				"@type":"SearchAction",
				"target":"https://itgap/search?q={search_query}",
				"query-input":"required name=search_query"}
		}</script>';
		echo str_replace(PHP_EOL, '', $a); 
	?>
	<meta property="og:url" content="<?=base_url();?>">
	<meta property="og:site_name" content="Itgap.ru">
	<meta property="og:title" content='<?=$page_title;?>'>
	<meta property="og:type" content="website">
	<?php if(isset($page_description)): ?>
		<meta property="og:description" content="<?=$page_description?>">
	<?php endif; ?>
	<?php if (isset($page_image)):?>
		<meta property="og:image" content="<?=base_url();?>static/uploads/posts/<?=$page_image;?>">
	    <meta property="og:image:secure_url" content="<?=base_url();?>static/uploads/posts/<?=$page_image;?>">
	<?php else: ?>
		<meta property="og:image" content="<?=base_url();?>media/images/logo.png">
		<meta property="og:image:secure_url" content="<?=base_url();?>media/images/logo.png">
	<?php endif; ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="/favicon/favicon.ico">
	<link rel="stylesheet" type="text/css" href="/media/css/style.min.css">
	<link rel="stylesheet" type="text/css" href="/media/fonts/Iconfonts/css/fontello.css">
	<script type="text/javascript" src="/media/js/jquery.min.js"></script>
	<script type="text/javascript" src="/media/js/main.min.js"></script>
	<?php echo isset($head_more) ? $head_more : ''; ?>
</head>