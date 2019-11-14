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
                <h3 class="sidebar-block__title">МЫ ВКОНТАКТЕ</h3>
            </div>
            <script type="text/javascript" src="https://vk.com/js/api/openapi.js?162"></script>
            <div id="vk_groups"></div>
            <script type="text/javascript">
            VK.Widgets.Group("vk_groups", {mode: 4, no_cover: 1, width: "280", height: "400", color2: '465881', color3: '1089FF'}, 176209611);
            </script>
        </div>
    </section>
    <section class="sidebar-item">
        <div class="block sidebar-block">
            <div class="sidebar-block__header">
                <h3 class="sidebar-block__title">ИНТЕРЕСНЫЕ СТАТЬИ</h3>
            </div>
            <div class="sidebar-block__content">
                <?php foreach ($suggested_posts_banner as $key => $value):?>
                <a href="/post/<?=$value['post_name'];?>" class="sidebar-block__item">
                    <div class="sidebar-block__item-image">
                        <img src="/static/uploads/posts/<?=$value['image_url'];?>" alt="image">
                    </div>
                    <div class="sidebar-block__item-text sidebar-text__item"><?=$value['title'];?></div>
                </a>
                <?php endforeach; ?>
             </div>
        </div>
    </section>
    <!-- <section class="sidebar-item">
        <div class="sidebar-block__header">
            <h3 class="sidebar-block__title">Лучшие комментарии</h3>
        </div>
        <div class="block sidebar-block">
            <div class="sidebar-block__content">
                <a href="#" class="sidebar-block__item">
                    <div class="sidebar-block__item-image">
                        <img src="/static/uploads/posts/tgrujueyvrl7jwx-08gnvadiujm.png" alt="image">
                    </div>
                    <div class="sidebar-block__item-text">Асимптотическая сложность алгоритмов: что за зверь?</div>
                </a>
                <a href="#" class="sidebar-block__item">
                    <div class="sidebar-block__item-image">
                        <img src="/static/uploads/posts/tgrujueyvrl7jwx-08gnvadiujm.png" alt="image">
                    </div>
                    <div class="sidebar-block__item-text">Асимптотическая сложность алгоритмов: что за зверь?</div>
                </a>
                <a href="#" class="sidebar-block__item">
                    <div class="sidebar-block__item-image">
                        <img src="/static/uploads/posts/tgrujueyvrl7jwx-08gnvadiujm.png" alt="image">
                    </div>
                    <div class="sidebar-block__item-text">Асимптотическая сложность алгоритмов: что за зверь?</div>
                </a>
            </div>
        </div>
    </section> -->
</aside>