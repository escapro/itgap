$(document).ready(function () {

    function toggleCheckbox(el) {
        var checkbox = $(el).find('input');

        if (checkbox.is(':checked')) {
            checkbox.prop('checked', false)
            $(el).removeClass('tglr-checked');
        } else {
            checkbox.prop('checked', true)
            $(el).addClass('tglr-checked');
        }
    }

    $('.toggler').click(function (event) {
        event.preventDefault();
        toggleCheckbox(this);
    })

    $('[module=etc_controls]').click(function (event) {
        event.preventDefault();

        var module = $(this).parent().find('.etc_control__list');

        if($(module).hasClass('ecl-opened')) {
            $(module).removeClass('ecl-opened')
        }else {
            $('.etc_control__list').removeClass('ecl-opened');
            $(module).addClass('ecl-opened');
        }
    })

    $('.etc_control__list .etc_control__item').on('click', function() {
        var postBlock = $(this).parent().parent().parent().parent().parent();
        var postId = postBlock.attr('data-id');
        var action = $(this).attr('action');

        switch (action) {
            case 'delete':
                if(confirm("Вы действительно хотите удалить данный пост?")) {
                    $.get('/writing/' + postId + '/delete', function(data, status){
                        postBlock.remove();
                    });
                }
            break;
        }
    })

    $('.header .auth-form-btn').on('click', function() {
        $(this).parent().find('.auth-block').toggle();
    });

    $('.header .search-form-btn').on('click', function() {
        $(this).parent().find('.search-block').toggle();      
    });


    $('.auth-block .btn').on('click', function() {

        event.preventDefault();

        var data = {};

        data['email'] = $(this).parent().find('input[name=email]').val();
        data['password'] = $(this).parent().find('input[name=password]').val();
        data['csrf_token'] = $(this).parent().find('input[name=csrf_token]').val();
        
        $.ajax({
            type: "POST",
            url: "/user/login",
            data: data,
            success: function (response) {
                response = JSON.parse(response);
                if(response.success == 1) {
                    window.location = '/user';
                }
            }
        });
        
    });

    $('.header-toggle_main_menu-block').on('click', function () {
        alert("");
    })

    var loadPage = 1;

    $('.load-more').on('click', () => {
        var 
            page = $('.content .feed').attr('page'),
            data={},
            url='',
            container;

        if(page == 'all') {
            url = '/post/fetch';
            data.type = 'all';
            container = '.content .feed';

        }else if(page == 'tag') {
            url = '/tag/fetch';
            data.tag = $('.content .feed').attr('tag');
            container = '.content .feed'; 

        }else if(page == 'search') {
            url = '/search/fetch';
            data.query = $('.content .feed').attr('query');
            container = '.content .search-result-area';

        }else if(page == 'category') {
            url = '/category/fetch';
            data.category = $('.content .feed').attr('category');
            container = '.content .feed';
        }else if(page == 'top') {
            url = '/post/fetch';
            data.type = 'top';
            container = '.content .feed';
        }
    
        loadContent(data, url, container)
    });

    function loadContent(data, url, container) {

        data.page = loadPage + 1;

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (response) {
                response = JSON.parse(response);

                $(container).append(response.html);
                loadPage++;

                if(response.isLastPage == 1) {
                    $('.load-more').parent().remove();
                }
            }
        });
    }

    var myLazyLoad = new LazyLoad({
		elements_selector: ".lazy"
    });
});