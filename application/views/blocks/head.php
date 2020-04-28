<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<?php if(APP_ENV == 'production'): ?>
		<script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(55693036, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/55693036" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131792796-2"></script>
		<script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-131792796-2');</script>
		<meta name="google-site-verification" content="2I45M7PBDeVLgx1uQn51I4t4YmJORZ0IFB-mUSzfGSA" />
	<?php endif; ?>

	<script type="text/javascript" src="https://vk.com/js/api/openapi.js?167"></script>

	<script>var isAdBlockActive=true;</script>
	<script src="/media/js/advertisment.js"></script>
	
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
			"name": "itGap.ru",
			"sameAs":["https://vk.com/public176209611", "https://twitter.com/itgap_official", "https://t.me/itgap_official"],
			"potentialAction":{
				"@type":"SearchAction",
				"target":"https://itgap.ru/search?q={q}",
				"query-input":"required name=q"}
		}</script>';
		echo str_replace(PHP_EOL, '', $a); 
	?>

	<meta property="og:locale" content="ru_RU">
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
		<meta property="og:image" content="<?=base_url();?>media/images/og.png">
		<meta property="og:image:secure_url" content="<?=base_url();?>media/images/og.png">
	<?php endif; ?>

	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="<?=base_url();?>">
	<meta property="twitter:title" content='<?=$page_title;?>'>

	<?php if(isset($page_description)): ?>
		<meta property="twitter:description" content="<?=$page_description?>">
	<?php endif; ?>

	<?php if (isset($page_image)):?>
		<meta property="twitter:image" content="<?=base_url();?>static/uploads/posts/<?=$page_image;?>">
	    <meta property="twitter:image" content="<?=base_url();?>static/uploads/posts/<?=$page_image;?>">
	<?php else: ?>
		<meta property="twitter:image" content="<?=base_url();?>media/images/og.png">
		<meta property="twitter:image" content="<?=base_url();?>media/images/og.png">
	<?php endif; ?>
	
	<link rel="icon" type="image/x-icon" href="<?=base_url();?>favicon.ico">
	<link rel="apple-touch-icon" sizes="180x180" href="<?=base_url();?>apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=base_url();?>favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url();?>favicon-16x16.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?=base_url();?>android-chrome-192x192.png">
	<meta name="apple-mobile-web-app-title" content="itGap">
	<meta name="application-name" content="itGap">
	<meta name="theme-color" content="#1e88e5">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>/media/css/style.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>/media/fonts/Iconfonts/css/fontello.css">
	<script async type="text/javascript" src="<?=base_url();?>/media/js/lazyload.min.js"></script>
	<script type="text/javascript" src="<?=base_url();?>/media/js/jquery.min.js"></script>
	<script async type="text/javascript" src="<?=base_url();?>/media/js/main.min.js"></script>
	<?php echo isset($head_more) ? $head_more : ''; ?>
</head>