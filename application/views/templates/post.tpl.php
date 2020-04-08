<main class="content">
	<div class="BYmiTN flex-center n-ls">
		<a target="_blank" rel="nofollow" href="https://bit.ly/39TIxkA"><img src="https://itgap.ru/static/uploads/2465ebb3705bd345a2e6eef3a37d10c3.jpg"></a>
	</div>
	<?php if(isset($user_id)):?>
		<div class="post-admin-control">
			<a class="post-admin-control_link" href="/post/edit/<?=$post['post_id'];?>">Редактировать</a>
			<a class="post-admin-control_link" href="#">В черновик</a>
		</div>
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
				<?php
					$post['data_html'] = preg_replace_callback('#(<p>.*?</p>)#', 'callback_func', $post['data_html']);

					function callback_func($matches)
					{
						static $count = 0;
						$ret = $matches[1];
						if (++$count == 1) {
							if (APP_ENV == 'production') {
								$ret .= '
								<div class="mb-2">
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
								</div>';	
							}else {
								$ret .= '<div class="advertisment bxS mb-2" style="display: block; width: 100%; height: 200px; background-color: #333"></div>';
							}
						}
						return $ret;
					}
				?>

				<?=$post['data_html'];?>

			</div>
		</div>
		<div class="post-entry-footer">
			
		</div>
	</article>
	<?php if(APP_ENV == 'production'): ?>
		<div class="mb-2">
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
		</div>
	<?php else: ?>
		<div class="bxS mb-2" style="display: block; width: 760px; height: 210px; background-color: #333"></div>
	<?php endif; ?>
	<script async>
		$(".post-entry a").attr("target", "_blank");		
		document.addEventListener('DOMContentLoaded', (event) => {
			document.querySelectorAll('pre code').forEach((block) => {
				hljs.highlightBlock(block);
			});
		});
	</script>
	<div class="post suggested-posts block">
		<h3>Также рекомендуем:</h3>
		<?php foreach ($suggested_posts as $key => $value):?>
			<div class="article-inline">
				<div class="article-preview__image">
					<a href="/<?=$value['category_url'];?>/<?=$value['post_name'];?>">
						<img class="lazy" src="<?=base_url();?>/media/images/placeholder.jpg" data-src="<?=base_url();?>/static/uploads/posts/<?=$value['image_url'];?>" alt="<?=$value['title'];?>">
					</a>
					<noscript>
						<img src="<?=base_url();?>/static/uploads/posts/<?=$value['image_url'];?>" alt="<?=$value['title'];?>">
					</noscript>
				</div>
				<div class="article-preview__content">
					<a href="/<?=$value['category_url'];?>/<?=$value['post_name'];?>">
						<h2 class="article-preview__title"><?=$value['title'];?></h2>
					</a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</main>