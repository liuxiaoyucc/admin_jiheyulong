$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
            $('.header').addClass('on');
        } else {
            $('.header').removeClass('on');
        }
    });
    $('.header .a2').click(function () {
        $('.nav_list').addClass('on')
    });
    $('.nav_list .close').click(function () {
        $('.nav_list').removeClass('on')
    });
    $('.header .a3').click(function () {
        $('.search').addClass('on')
    });
    $('.search .a1').click(function () {
        $('.search').removeClass('on')
    });



    $(document).on('click', '.footer .a1 .b1', function () {
        if ($(this).attr('data') == 1) {
            var height = $(this).parent().find('li').length;
            $(this).parent().find('ul').css('display', 'block');
            $(this).parent().find('ul').stop(true).animate({'height': height * 24});
            $(this).attr('data', '0');
        } else {
            $(this).parent().find('ul').stop(true).animate({'height': 0}, function () {
                $(this).parent().find('ul').css('display', 'none');
            });
            $(this).attr('data', '1');
        }
    });
    $(document).on('click', '.footer .a1 ul li a', function () {
        var text = $(this).html()
        $(this).parent().parent().parent().find('.text').html(text);
        $(this).parent().parent().stop(true).animate({'height': 0}).css('display', 'none');
        $(this).parent().parent().parent().find('.text').attr('data', '1');
    });
})