<main class="content">
	<div class="block page-right_block">
		<div class="editor">
			<form action="#">
			<div class="editor-error"></div>
			<div class="editor-with editor-meta_info">
				<div class="editor-date">
					<span><?=$postData['last_change'] ?? ''?></span>
				</div>
			</div>
				<div class="editor-width source-link mb-1"> 
					<input type="text" placeholder="Ссылка на источник" value="<?=$postData['link'] ?? ''?>">
				</div>
				<div class="select-tag mb-2">
					<select class="editor-tag__selector" name="states[]" multiple="multiple">
						<?php
							foreach ($tags['tags'] as $key => $value) {
								echo '<option value="'.$value['id'].'"';
								// if(isset($postData['tag_id'])) {
								// 	if($postData['tag_id'] == $value['id']) {
								// 		echo ' selected';
								// 	}
								// }
								echo '>'.$value['title'].'</option>';
							}
						?>
					</select>
				</div>
				<div class="editor-width editor__title mb-2">
					<textarea name="title" placeholder="Заголовок" maxlength="120" default="Заголовок"><?=$postData['title'] ?? ''?></textarea>
				</div>
				<div class="editor-content mb-2">
					<div class="editor-file__loader">
						<?php if(!empty($postData['preview_image_url'])):?>
							<div class="editor-image_preview">
								<img src="/static/uploads/posts/<?=$postData['preview_image_url']?>" alt="preview image">
								<div class="file-preview__controls">
									<div class="file-preview__clear">Удалить</div> 
								</div>
							</div>
						<?php else:?>
							<label class="editor-item__bg post__file-uploader" for="post-mainImage">
								<div class="db ta-c">
									<span class="icon-picture"></span>
									<div class="mt-05">Разрешение картинки строго 2:1, минимальная высота 500px.</div>
									<input class="hide" id="post-mainImage" type="file" accept="image/*">
								</div>
							</label>
						<?php endif;?>
					</div>
				</div>
				<div class="editor-width editor-preview mb-2">
					<textarea class="editor-item__bg" name="title" placeholder="Краткое содержание" maxlength="300" default="Краткое содержание"><?=$postData['preview_text'] ?? ''?></textarea>
				</div>
				<div class="editor-content">
					<div id="codex-editor"></div>
				</div>
			</form>
		</div>
	</div>
	<script>
		let postData;
		<?php echo $editorData; ?>
		<?php echo $post_tags_jquery; ?>
	</script>
</main>