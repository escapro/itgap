<aside class="main-sidebar">
    <section class="sidebar-item">
        <div class="block sidebar-block">
            <div class="sidebar-block__header">
                <h3 class="sidebar-block__title">Категории</h3>
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
                <h3 class="sidebar-block__title">Популярные статьи</h3>
            </div>
            <div class="sidebar-block__content">
                <?php foreach ($popular_posts as $key => $value):?>
                <a href="/<?=$value['tag'];?>/<?=$value['post_name'];?>" class="sidebar-block__item">
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