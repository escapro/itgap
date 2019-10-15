<main class="content">
	<div class="block page-right_block user_drafts">
		<section class="feed">
			<?php if(!empty($draft_posts)): ?>
				<?php foreach ($draft_posts as $key => $value):?>
					<article class="article-preview block" data-id="<?=$value['post_id'];?>">
						<div class="article-preview__header">
							<div class="article-preview-header__user">
								<div class="centered aic">
									<a class="profile-mini" href="#">
										<div class="profile-mini__image">
											<img src="/static/img/avatars/<?=$user_image;?>" alt="image">
										</div>
										<div class="profile-mini__username"><?=$user->username;?></div>
									</a>
									<span class="secondary-text"><?=$value['last_change'];?></span>
								</div>
								<div class="pos-rel">
									<span class="icon-ellipsis ico-23 ico-btn" module="etc_controls"></span>
									<div class="etc_control__list">
										<a class="etc_control__item" href="/writing/<?=$value['post_id'];?>/edit">Редактировать</a>
										<div class="etc_control__item" action="delete">Удалить</div>
									</div>
								</div>
							</div>
						</div>
						<div class="article-preview__content">
							<a href="/post/preview/<?=$value['post_id'];?>">
								<?php if ($value['title'] !== ''):?>
									<h2 class="article-preview__title"><?=$value['title']?></h2>
								<?php else:?>
									<h2 class="ubP1Si">Без заголовка</h2>
								<?php endif;?>
								<?php if ($value['preview_text'] !== ''):?>
									<div class='article-preview-description'><?=$value['preview_text'];?></div>
								<?php else:?>
									<div class='ieOYpZ'>Без краткого содержания</div>
								<?php endif;?>
							</a>
							<div class="article-tags">
							<?php if(!empty($value['tags'])): ?>
								<?php foreach ($value['tags'] as $key_2 => $value_2):?>
									<a href="/tag/<?=$value_2['tag']?>"><?=$value_2['title']?></a>
								<?php endforeach;?>
							<?php endif;?>
							</div>
						</div>
						<?php if ($value['image_url'] !== ''):?>
							<div class="article-preview__image">
								<a href="/post/preview/<?=$value['post_id'];?>">
									<img src="/static/uploads/posts/<?=$value['image_url'];?>" alt="image">
								</a>
							</div>
						<?php endif;?>
					</article>
					<?php endforeach;?>
				<?php else: ?>
				<div class="empty">
					<p>Тут пока нет публикаций</p>
				</div>
				<?php endif; ?>
		</section>
	</div>
</main>