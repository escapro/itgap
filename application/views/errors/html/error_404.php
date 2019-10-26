<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		.container {
			width: 700px;
			max-width: 100%;
			margin: auto;
			padding: 20px;
		}
		.page {
			height: 100vh;
			min-height: 400px;
			display: flex;
			flex-direction: column;
			font-family: sans-serif;
		}
		.header {
			background-color: #343434;
		}
		.header a{
			color: #fff;
		}
		.main {
			flex-grow: 1;
			display: flex;
			justify-content: center;
			align-items: center;
			font-weight: bold;
		}
		.main .container {
			text-align: center;
		}
		.error-code{
			font-size: 100px;
    		color: #333;
		}
		.error-msg {
			font-size: 42px;
    		color: #8e8e8e;
		}
	</style>
</head>
<body>
	<div class="page">
		<header class="header">
			<div class="container">
				<a href="https://itgap.ru">Вернуться в itgap.ru</a>
			</div>
		</header>
		<div class="main">
			<div class="container">
				<h1 class="error-code">404</h1>
				<small class="error-msg">Такой страницы не существует</small>
			</div>
		</div>
	</div>
</body>
</html>