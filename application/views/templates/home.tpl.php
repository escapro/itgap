<main class="content">
	<section class="feed">
	<?php foreach ($posts as $key => $value):?>
		<article class="article-preview block">
			<div class="article-preview__content">
				<a href="/post/<?=$value['post_name'];?>">
					<h2 class="article-preview__title"><?=$value['title'];?></h2>
					<div class='article-preview-description'><?=$value['preview_text'];?></div></a>
				<div class="article-tags">
				<?php if(isset($value['tags'])): ?>
					<?php foreach ($value['tags'] as $key_2 => $value_2):?>
						<a href="/tag/<?=$value_2['tag']?>"><?=$value_2['title']?></a>
					<?php endforeach;?>
				<?php else:?>
					<a href="/tag/<?=$value['tag_url']?>"><?=$value['tag']?></a>
				<?php endif;?>
				</div>
			</div>
			<div class="article-preview__image">
				<a href="/post/<?=$value['post_name'];?>">
					<img src="https://itgap.ru/static/uploads/posts/<?=$value['image_url'];?>" alt="image">
				</a>
			</div>
		</article>
	<?php endforeach; ?>
	</section>
</main>