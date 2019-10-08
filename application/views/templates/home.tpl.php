<main class="content">
	<section class="feed">
	<?php foreach ($posts as $key => $value):?>
		<article class="article-preview block">
			<div class="article-preview__content">
				<a href="/<?=$value['tag_url'];?>/<?=$value['post_name'];?>">
					<h2 class="article-preview__title"><?=$value['title'];?></h2>
					<div class='article-preview-description'><?=$value['preview_text'];?></div></a>
				<div class="article-tags">
					<a href="/tag/<?=$value['tag_url']?>"><?=$value['tag']?></a>
				</div>
			</div>
			<div class="article-preview__image">
				<a href="/<?=$value['tag_url'];?>/<?=$value['post_name'];?>">
					<img src="/static/uploads/posts/<?=$value['image_url'];?>" alt="image">
				</a>
			</div>
		</article>
	<?php endforeach; ?>
	</section>
</main>