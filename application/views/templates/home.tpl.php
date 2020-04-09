<main class="content">
	<div class="BYmiTN flex-center n-ls">
		<a target="_blank" rel="nofollow" href="https://ad.admitad.com/g/3w3tocvbxr3e3da004095fb557f5d8/"><img src="https://itgap.ru/static/uploads/2465ebb3705bd345a2e6eef3a37d10c3.jpg"></a>
	</div>
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
					<img class="lazy" src="<?=base_url();?>/media/images/placeholder.jpg" data-src="<?=base_url();?>/static/uploads/posts/<?=$value['image_url'];?>" alt="<?=$value['title'];?>">
				<noscript>
					<img src="<?=base_url();?>/static/uploads/posts/<?=$value['image_url'];?>" alt="<?=$value['title'];?>">
				</noscript>
				</a>
			</div>
		</article>
	<?php endforeach; ?>
	</section>
</main>