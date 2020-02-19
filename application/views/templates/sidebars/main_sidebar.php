<aside class="main-sidebar">
    <section class="sidebar-item">
        <div class="block sidebar-block">
            <div class="sidebar-block__header">
                <h3 class="sidebar-block__title">Теги</h3>
            </div>
            <div class="sidebar-block__content">
                <ul class="sidebar-block__list">
                    <?php foreach ($tags['tags'] as $key => $value):?>
                    <li class="sidebar-block-list__item">
                        <a href="/tag/<?=$value['tag'];?>"><?=$value['title'];?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
             </div>
        </div>
    </section>
    <section class="sidebar-item">
        <div class="block sidebar-block">
            <div class="sidebar-block__header">
                <h3 class="sidebar-block__title">ИНТЕРЕСНЫЕ СТАТЬИ</h3>
            </div>
            <div class="sidebar-block__content">
                <?php foreach ($suggested_posts_banner as $key => $value):?>
                <a href="/<?=$value['category_url'];?>/<?=$value['post_name'];?>" class="sidebar-block__item">
                    <!-- <div class="sidebar-block__item-image">
                        <img src="/static/uploads/posts/<?=$value['image_url'];?>" alt="image">
                    </div> -->
                    <div class="sidebar-block__item-text sidebar-text__item"><?=$value['title'];?></div>
                </a>
                <?php endforeach; ?>
             </div>
        </div>
    </section>
    <section class="sidebar-item sidebar-ad">
        <?php if(APP_ENV == 'production'): ?>
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                style="display:inline-block;width:320px;height:620px"
                data-ad-client="ca-pub-9975977745394887"
                data-ad-slot="7516198603"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        <?php endif; ?>
    </section>
</aside>