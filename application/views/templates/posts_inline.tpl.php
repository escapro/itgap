<main class="content">
	<section class="feed">
		<div class="block article-inline__block">
			<div class="section-head">
				<div class="mb-2">
					<h1 class="fs-2">Поиск по запросу: "<?=$query;?>"</h1>
				</div>
				<div class="mb-2">
					<form method="GET">
						<div class="form-field">
							<input class="form-input" type="text" name="q" placeholder="Введите поисковый запрос" value="<?=$query;?>" autofocus>
							<button class="btn btn-primary">Поиск</button>
						</div>
					</form>
				</div>
			</div>
			<div class="search-result-area">
				<?php if(!empty($posts)): ?>
				<?php foreach ($posts as $key => $value):?>
				<article class="article-inline">
					<div class="article-preview__content">
						<a href="/post/<?=$value['post_name'];?>">
							<h2 class="article-preview__title"><?=$value['title'];?></h2>
						</a>
					</div>
					<div class="article-preview__image">
						<a href="/post/<?=$value['post_name'];?>">
							<img src="https://itgap.ru/static/uploads/posts/<?=$value['image_url'];?>" alt="image">
						</a>
					</div>
				</article>
				<?php endforeach; ?>
				<?php else: ?>
				<div class="no-search-result"><h3>Нет результатов</h3></div>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>