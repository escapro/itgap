<main class="content">
	<div class="block page-right_block">
		<div class="editor">
			<form action="#">
			<div class="editor-error"></div>
			<div class="editor-with editor-meta_info mb-2">
				<div class="form-field">
					<label class="form-label" for="editor-datepicker">Дата публикации</label>
					<input type='text' id="editor-datepicker" class="form-control editor-datepicker" value="<?php echo isset($postData['last_change']) ? $postData['last_change'] : time()?>"/>
					<?php echo isset($postData['last_change']) ? '<small id="hDate" style="margin-left: 16px; color: silver">'.date("d.m.Y H:i", $postData['last_change']).'</small>' : '' ?>
				</div> 
			</div>
				<div class="editor-width post-category mb-2"> 
					<div class="form-field">
						<label class="form-label" for="editor-category">Категория</label>
						<select class="form-control" id="editor-category">
							<?php
								foreach ($categories as $key => $value) {
									echo '<option value="'.$value['id'].'"';
									if(isset($postData['category_id'])) {
										if($postData['category_id'] == $value['id']) {
											echo "selected";
										}
									}else {
										if(isset($_GET['post_category'])) {
											$cat = $_GET['post_category'];
											if($cat == $value['id']) {
												echo "selected";
											}
										}
									}
									echo '>'.$value['title'].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="editor-width editor-page_title mb-2">
					<div class="form-field">
						<label class="form-label" for="editor-title">URL страницы</label>
						<input class="form-control" id="editor-title" type="text" placeholder="Заголовок страницы" value="<?=$postData['post_name'] ?? ''?>">
					</div>
				</div>
				<div class="editor-width source-link mb-2">
					<div class="form-field">
						<label class="form-label" for="editor-sourceLink">Ссылка на источник</label>
						<input class="form-control" id="editor-sourceLink" type="text" placeholder="Ссылка на источник" value="<?=$postData['link'] ?? ''?>">
					</div>
					</div>
				<div class="select-tag mb-2">
					<div class="form-field">
						<label class="form-label" for="editorTags">Теги</label>
						<select class="editor-tag__selector" id="editorTags" name="states[]" multiple="multiple">
							<?php
								foreach ($tags['tags'] as $key => $value) {
									echo '<option value="'.$value['id'].'"';
									echo '>'.$value['title'].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<hr>
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