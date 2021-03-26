<main class="content">
	<?php if(APP_ENV == 'test'): ?>
	<div class="mb-2">
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<ins class="adsbygoogle"
			style="display:block"
			data-ad-client="ca-pub-5882767307365612"
			data-ad-slot="5754734803"
			data-ad-format="auto"
			data-full-width-responsive="true"></ins>
		<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>
	<?php endif; ?>
	<?php if(APP_ENV == 'development'): ?>
	<div class="advertisment bxS mb-2" style="display: block; width: 760px; height: 180px; background-color: #333">
	</div>
	<?php endif; ?>
	<section class="feed" <?=isset($load_attributes) ? $load_attributes : ""?>>
		<?php foreach ($posts['posts'] as $key => $value):?>
		<article class="article-preview block">
			<div class="article-preview__content">
				<a href="/<?=$value['category_url'];?>/<?=$value['post_name'];?>">
					<h2 class="article-preview__title"><?=$value['title'];?></h2>
					<div class='article-preview-description'><?=$value['preview_text'];?></div>
				</a>
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
				<a href="/<?=$value['category_url'];?>/<?=$value['post_name'];?>">
					<img class="lazy" src="<?=base_url();?>/media/images/placeholder.jpg"
						data-src="<?=base_url();?>/static/uploads/posts/<?=$value['image_url'];?>"
						alt="<?=$value['title'];?>">
					<noscript>
						<img src="<?=base_url();?>/static/uploads/posts/<?=$value['image_url'];?>"
							alt="<?=$value['title'];?>">
					</noscript>
				</a>
			</div>
		</article>
		<?php endforeach; ?>
	</section>
</main>