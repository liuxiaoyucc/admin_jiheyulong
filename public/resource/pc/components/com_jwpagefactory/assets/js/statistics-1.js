var jzt_url = window.location.hostname;
var ishttps = ('https:' == document.location.protocol) ? 'https://': 'http://';
switch (jzt_url) {
    case 'http://ijzt.china9.cn/components/com_jwpagefactory/assets/js/ijzt.china9.cn':
        jzt_url = 'http://ijzt.china9.cn/components/com_jwpagefactory/assets/js/zhjzt.china9.cn';
        break;
    case 'http://ijzt.china9.cn/components/com_jwpagefactory/assets/js/jzt_dev_2.china9.cn':
        jzt_url = 'http://ijzt.china9.cn/components/com_jwpagefactory/assets/js/jzt_dev_1.china9.cn';
        break;
    default :
        jzt_url = 'http://ijzt.china9.cn/components/com_jwpagefactory/assets/js/zhjzt.china9.cn';
        break;
}
function statistics() {
    var url = window.location.hostname;
    if (url != 'http://ijzt.china9.cn/components/com_jwpagefactory/assets/js/jzt_dev_2.china9.cn' && url != 'http://ijzt.china9.cn/components/com_jwpagefactory/assets/js/ijzt.china9.cn') {
        jQuery.post(ishttps + jzt_url + '/api/statistics/submit', {'url': url}, function (e) {

        });
    }
}
statistics();