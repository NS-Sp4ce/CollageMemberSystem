$(document).ready(function() {
    function GetUrl() {
        var url = location.search; //获取url中"?"符后的字串 
        if (url.indexOf("?") != -1) {
            var str = url.substr(0);
            strs = str.split("&");
            //console.log(strs);
        }
        return strs;
    }
    var req = GetUrl();
    var strUrl = req[0];
    //navigation样式
    //console.log(window.location.search);
    $('ul.navigation li a').each(function() {
        //判断链接相当（当前页面导航样式）
        if ($(this).attr('href') == strUrl) {
            if ($(this).parents('li').hasClass('navigation__sub')) {
                $(this).parents('ul>li.navigation__sub').eq(0).addClass('navigation__sub--active');
                $(this).parents('ul>li.navigation__sub').eq(0).addClass('navigation__sub--toggled');
                $(this).parent('li').addClass('navigation__active');
                $(this).parent('li').siblings().removeClass('navigation__active');
            } else {
                $(this).parent('li').addClass('navigation__active');
                $(this).parent('li').siblings().removeClass('navigation__active');
            }
        }
        //console.log($(this).attr('href'));   
    });

});