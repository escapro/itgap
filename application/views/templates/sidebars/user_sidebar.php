<aside class="">
    <div class="acount-sidebar__block block">
        <div class="acount-sidebar__info">
            <div class="acount-sidebar__user-avatar">
                <img src="/static/img/avatars/<?=$user_image?>" alt="image">
            </div>
            <div class="acount-sidebar__user-meta">
                <span class="nickname">
                    <?=$user->username;?>
                </span>
                <span class="userdata">Зарегистрирован(а) <?=$user->created_on;?></span>
            </div>
        </div>
        <div class="scroll-area">
            <div class="acount-sidebar__nav">
                <?php
                    $profile = '';
                    $a_posts = '';
                    $drafts = '';
                    $mod = '';
                    switch ($userPageBlock) {
                        case 'profile':
                            $profile = 'active';
                        break;
                        case 'active_posts':
                            $a_posts = 'active';
                        break;
                        case 'drafts':
                            $drafts = 'active';
                        break;
                        case 'moderations':
                            $mod = 'active';
                        break;
                    }
                ?>
                <a class="account-section" href="/admin">Админ панель</a>
                <a class="account-section <?=$profile;?>" href="/user">Профиль</a>
                <a class="account-section" href="/post/new">Новая статья</a>
                <a class="account-section <?=$mod;?>" href="/user/in_moderations">На модерации</a>
                <a class="account-section <?=$drafts;?>" href="/user/drafts">Черновик</a>
                <a class="account-section <?=$a_posts;?>" href="/user/posts">Публикации</a>
                <a class="account-section" href="/user/logout">Выйти</a>
            </div>
        </div>
    </div>
</aside>