<div class="block tag-navbar">
    <ul class="navbar__block">
        <?php foreach ($tags['tags'] as $key => $value):?>
        <li class="navbar__items"><a href="/tag/<?=$value['tag'];?>"><?=$value['title'];?></a></li>
        <?php endforeach; ?>
    </ul>
</div>