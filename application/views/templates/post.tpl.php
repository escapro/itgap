<main class="content">
<?php if(APP_ENV == 'production'): ?>
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<ins class="adsbygoogle"
		style="display:block"
		data-ad-client="ca-pub-9975977745394887"
		data-ad-slot="6901476157"
		data-ad-format="auto"
		data-full-width-responsive="true"></ins>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
<?php endif; ?>
	<article class="block post post-entry-content">
		<header class="post-header">
			<h1><?php if($post['title'] !== '') echo $post['title']; ?></h1>
			<div class="post-meta">
				<span class="post-meta__time"><i class="icon icon-clock"></i><?=$post['last_change'];?></span>
				<div class="right">
					<span class="post-meta__views"><i class="icon icon-eye"></i><?=$post['views'];?></span>
					<!-- <span class="post-meta__comments"><i class="icon icon-chat"></i></span> -->
				</div>
			</div>
			<div class="article-tags">
				<?php if(!empty($post['tags'])): ?>
				<?php foreach ($post['tags'] as $key_2 => $value_2):?>
				<a href="/tag/<?=$value_2['tag']?>"><?=$value_2['title']?></a>
				<?php endforeach;?>
				<?php endif;?>
			</div>
		</header>
		<div class="post-content">
			<?php if($post['image_url'] !== ''): ?>
			<div class="post-image">
				<img src="<?=base_url();?>/static/uploads/posts/<?=$post['image_url'];?>"
					<?php if($post['title'] !== '') echo 'alt="'.$post['title'].'"'; ?>>
			</div>
			<?php endif; ?>
			<div class="post-entry">
				<?=$post['data_html'];?>
				<div class="post-bottom_ad">
					<?php if(APP_ENV == 'production'): ?>
						<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<ins class="adsbygoogle"
							style="display:block; text-align:center;"
							data-ad-layout="in-article"
							data-ad-format="fluid"
							data-ad-client="ca-pub-9975977745394887"
							data-ad-slot="2995565323"></ins>
						<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="post-entry-footer">
			
		</div>
	</article>
	<script async>
		$(".post-entry a").attr("target", "_blank");		
		document.addEventListener('DOMContentLoaded', (event) => {
			document.querySelectorAll('pre code').forEach((block) => {
				hljs.highlightBlock(block);
			});
		});
	</script>
	<div class="post suggested-posts">
		<h3>Также рекомендуем:</h3>
		<?php $loop = 0?>
		<?php foreach ($suggested_posts as $key => $value):?>
			<?php $loop++; ?>
			<?php if($loop == 2): ?>
				<div class="article-inline">
					<div class="suggested-posts_ad">
						<?php if(APP_ENV == 'production'): ?>
							<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
								style="display:block"
								data-ad-format="fluid"
								data-ad-layout-key="-h8+t-2c-eb+z1"
								data-ad-client="ca-pub-9975977745394887"
								data-ad-slot="7958101982"></ins>
							<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						<?php endif; ?>
					</div>
				</div>
			<?php else: ?>
				<div class="article-inline">
					<div class="article-preview__image">
						<a href="/<?=$value['category_url'];?>/<?=$value['post_name'];?>">
							<img class="lazy" src="<?=base_url();?>/media/images/placeholder.jpg" data-src="<?=base_url();?>/static/uploads/posts/<?=$value['image_url'];?>" alt="image">
						</a>
						<noscript>
							<img src="<?=base_url();?>/static/uploads/posts/<?=$value['image_url'];?>" alt="image">
						</noscript>
					</div>
					<div class="article-preview__content">
						<a href="/<?=$value['category_url'];?>/<?=$value['post_name'];?>">
							<h2 class="article-preview__title"><?=$value['title'];?></h2>
						</a>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</main>