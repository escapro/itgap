<main class="content">
	<?php if(APP_ENV == 'test'): ?>
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<ins class="adsbygoogle"
		style="display:block"
		data-ad-client="ca-pub-5882767307365612"
		data-ad-slot="5754734803"
		data-ad-format="auto"
		data-full-width-responsive="true"></ins>
	<script>
		window.addEventListener( 'load', function() {
            (adsbygoogle = window.adsbygoogle || []).push({});
        });
	</script>
	<?php endif; ?>
	<?php if(APP_ENV == 'test'): ?>
	<div class="advertisment bxS mb-2" style="display: block; width: 760px; height: 180px; background-color: #333">
	</div>
	<?php endif; ?>
	<?php if($is_admin):?>
	<div class="d-flex flex-wrap mb-1 m-mt-1"">
		<a class=" panel-btn mr-1" href="/post/edit/<?=$post['post_id'];?>">
		<span class="ico icon-pencil"></span>
		<span>Редактировать</span>
		</a>
		<a class="panel-btn" href="#">
			<span class="ico icon-sticky-note"></span>
			<span>В черновик</span>
		</a>
	</div>
	<?php endif; ?>
	<article class="block post post-entry-content">
		<header class="post-header">
			<h1><?php if($post['title'] !== '') echo $post['title']; ?></h1>
			<div class="post-meta">
				<span class="post-meta__time"><i class="icon icon-clock"></i><?=$post['last_change'];?></span>
				<div class="right">
					<span class="post-meta__views"><i
							class="icon icon-eye"></i><?=number_format($post['views'], 0, ',', ' ');?></span>
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
		data-ad-client="ca-pub-5882767307365612"
		data-ad-slot="1105043350"
		data-ad-format="auto"
		data-full-width-responsive="true"></ins>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
	</div>
	<?php endif; ?>
	<?php if(APP_ENV == 'development'): ?>
	<div class="advertisment bxS mb-2" style="display: block; width: 760px; height: 210px; background-color: #333">
	</div>
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
		<h3>Похожие публикации:</h3>
		<?php foreach ($suggested_posts as $key => $value):?>
		<div class="article-inline">
			<div class="article-preview__image">
				<a href="/<?=$value['category_url'];?>/<?=$value['post_name'];?>">
					<img class="lazy" src="<?=base_url();?>/media/images/placeholder.jpg"
						data-src="<?=base_url();?>/static/uploads/posts/<?=$value['image_url'];?>"
						alt="<?=$value['title'];?>">
				</a>
				<noscript>
					<img src="<?=base_url();?>/static/uploads/posts/<?=$value['image_url'];?>"
						alt="<?=$value['title'];?>">
				</noscript>
			</div>
			<div class="article-preview__content">
				<div class="d-flex column h-100 space-between">
					<div>
						<span class='article-preview__date'><?=$value['last_change']?></span>
						<a class="article-preview__title"
							href="/<?=$value['category_url'];?>/<?=$value['post_name'];?>">
							<div><?=$value['title'];?></div>
						</a>
					</div>
					<div>
						<span class="article-preview__views"><i class="icon icon-eye"></i><?=$value['views']?></span>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="mt-2 comment-block">
		<div id="vk_comments"></div>
		<script type="text/javascript">
			var comment_enabled = false;
			$(window).scroll(function () {
				var hT = $('#vk_comments').offset().top,
					hH = $('#vk_comments').outerHeight(),
					wH = $(window).height(),
					wS = $(this).scrollTop();
				if (wS > (hT + hH - wH)) {
					if (!comment_enabled) {
						VK.init({
							apiId: 7429865,
							onlyWidgets: true
						});
						VK.Widgets.Comments('vk_comments', {
							limit: 10,
							attach: "*",
							pageUrl: location.href
						});
						comment_enabled = true;
					}
				}
			});
		</script>
	</div>
</main>