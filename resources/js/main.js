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
                $.get('/writing/' + postId + '/delete', function(data, status){
                    postBlock.remove();
                });
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
        alert("ssdf");
    })

    var loadPage = 1;

    $('.load-more').on('click', () => {
        loadContent('all', '.content .feed', $(this))
    });

    function loadContent(type, container, object) {
        
        var data={}

        data.page = loadPage + 1;
        data.postsType = type;

        $.ajax({
            type: "POST",
            url: '/post/fetch',
            data: data,
            success: function (response) {
                response = JSON.parse(response);
                $(container).append(response.html);
                loadPage++;
            }
        });
    }

    var myLazyLoad = new LazyLoad({
		elements_selector: ".lazy"
    });
});