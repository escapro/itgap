<nav class="navbar main-navbar">
   <div class="container">
    <ul class="navbar__block">
        <?php foreach ($categories as $key => $value):?>
            <li class="navbar__items main-navbar__items"><a href="/category/<?=$value['url_name'];?>"><?=$value['title'];?></a></li>
        <?php endforeach; ?>
    </ul>
   </div>
</nav>