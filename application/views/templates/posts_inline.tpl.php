<main class="content">
	<section class="feed" <?=isset($load_attributes) ? $load_attributes : ""?>>
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
				<?php if(!empty($posts['posts'])): ?>
				<?php foreach ($posts['posts'] as $key => $value):?>
				<article class="article-inline">
					<div class="article-preview__content">
						<a href="/post/<?=$value['post_name'];?>">
							<h2 class="article-preview__title"><?php echo preg_replace("/\w*?$query\w*/i", "<b style='font-size: 21px'>$0</b>", $value['title'])?></h2>
							<div class="article-preview-description">
								<p><?php echo preg_replace("/\w*?$query\w*/i", "<b style='font-size: 16px'>$0</b>", $value['preview_text'])?></p>
							</div>
						</a>
					</div>
					<div class="article-preview__image">
						<a href="/post/<?=$value['post_name'];?>">
							<img src="https://itgap.ru/static/uploads/posts/<?=$value['image_url'];?>" alt="image">
						</a>
					</div>
					<div class="article-inline_borderBottom"></div>
				</article>
				<?php endforeach; ?>
				<?php else: ?>
				<div class="no-search-result"><h3>Нет результатов</h3></div>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>