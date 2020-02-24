<nav class="navbar editor-navbar">
   <div class="container flex-right">
    <ul class="navbar__block">
        <li class="navbar__items editor-preview-btn"><span class="ico icon-eye-1"></span></li>
        <?php if(isset($postEditPage)): ?>
            <li class="navbar__items" title="В черновик" id="editorPostToDraft"><span class="ico icon-sticky-note"></span></li>
            <li class="navbar__items"><span class="ico icon-cog"></span></li>
            <li class="navbar__items"><button class="btn btn-primary editor-update-btn">Обновить</button></li>
        <?php elseif(isset($postWritingPage)): ?>
            <li class="navbar__items" title="Удалить" id="editorDeletePost"><span class="ico icon-trash-empty"></span></li>
            <li class="navbar__items"><div class="editor-save-btn"><span class="ico icon-floppy"></span></div></li>
            <li class="navbar__items"><button id="publish" class="btn btn-primary">На модерацию</button></li>
        <?php endif; ?>
    </ul>
   </div>
</nav>