<aside class="main-sidebar">
    <section class="sidebar-item">
        <div class="flex" style="justify-content: center; align-items: center">
            <!-- <a href="tg://resolve?domain=itgap_official">
                <div class="block flex"
                    style="justify-content: center; align-items: center; padding: 10px; border-radius: 10px">
                    <i class="soc-icon soc-icon-tg" style="border: none; width: 30px; height: 30px;"></i>
                    <span style="margin-left: 10px;"><b>Читать наc в Telegram</b></span>
                </div>
            </a> -->
            <a target="_blank" href="https://www.youtube.com/channel/UC1OJAB33isTzLjlUQaM12AA">
                <div class="block flex"
                    style="justify-content: center; align-items: center; padding: 10px; border-radius: 10px">
                    <i class="soc-icon soc-icon-yt_orig" style="border: none; width: 30px; height: 30px;"></i>
                    <span style="margin-left: 10px;"><b>Смотрите нас на YouTube</b></span>
                </div>
            </a>
        </div>
    </section>
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
    <section class="sidebar-item">
        <?php if(APP_ENV == 'production'): ?>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle"
            style="display:inline-block;width:300px;height:600px"
            data-ad-client="ca-pub-5882767307365612"
            data-ad-slot="2866005136"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <?php endif; ?>
        <?php if(APP_ENV == 'development'): ?>
        <div class="advertisment bxS" style="display: block; width: 300px; height: 600px; background-color: #333"></div>
        <?php endif; ?>
    </section>
</aside>