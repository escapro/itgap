<main class="content">
	<div class="mb-2 bxS">
		<?php if(APP_ENV == 'production'): ?>
			<div id="yandex_rtb_R-A-518420-3"></div>
			<script type="text/javascript">
				(function(w, d, n, s, t) {
					w[n] = w[n] || [];
					w[n].push(function() {
						Ya.Context.AdvManager.render({
							blockId: "R-A-518420-3",
							renderTo: "yandex_rtb_R-A-518420-3",
							async: true
						});
					});
					t = d.getElementsByTagName("script")[0];
					s = d.createElement("script");
					s.type = "text/javascript";
					s.src = "//an.yandex.ru/system/context.js";
					s.async = true;
					t.parentNode.insertBefore(s, t);
				})(this, this.document, "yandexContextAsyncCallbacks");
			</script>
		<?php else: ?>
			<div class="bxS mb-2" style="display: block; width: 760px; height: 210px; background-color: #333"></div>
		<?php endif; ?>
	</div>
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
				<?php if(APP_ENV == 'production'): ?>
					<div id="yandex_rtb_R-A-518420-4"></div>
					<script type="text/javascript">
						(function(w, d, n, s, t) {
							w[n] = w[n] || [];
							w[n].push(function() {
								Ya.Context.AdvManager.render({
									blockId: "R-A-518420-4",
									renderTo: "yandex_rtb_R-A-518420-4",
									async: true
								});
							});
							t = d.getElementsByTagName("script")[0];
							s = d.createElement("script");
							s.type = "text/javascript";
							s.src = "//an.yandex.ru/system/context.js";
							s.async = true;
							t.parentNode.insertBefore(s, t);
						})(this, this.document, "yandexContextAsyncCallbacks");
					</script>
				<?php else: ?>
					<div class="bxS mb-2" style="display: block; width: 690px; height: 320px; background-color: #333"></div>
				<?php endif; ?>
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
			<?php // ?>
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