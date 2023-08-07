const Common = {
    info(api, param, cb) {
        handleAjax(api, param).done((res)=>{
            cb && cb(res);
        }).fail(function(msg){
            console.log(msg);
            layer.msg(msg);
        });
    },
    create(api, param, cb) {
        handleAjax(api, param, 'POST').done((res)=>{
            tcr_table(res.message, 1, 1);
            cb && cb(res);
        }).fail(function(msg){
            tcr_table(msg)
        });
    },
    update(api, param, cb, flag) {
        flag = flag || 0;
        handleAjax(api, param, 'POST').done((res)=>{
            if (flag) {
                tcr_table(res.message);
            }else  {
                tcr_table(res.message ,1,1);
            }
            cb && cb(res)
        }).fail(function(msg){
            layer.msg(msg);
        });
    },
    remove(api, ids, cb) {
        handleAjax(api, {ids}, 'POST').done((res)=>{
            tcr_table(res.message);
            cb && cb(res);
        }).fail(function(msg){
            layer.msg(msg);
        });
    },
}

function getQueryString(name) {
    let reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    let r = window.location.search.substr(1).match(reg);
    if (r != null) {
        return decodeURIComponent(r[2]);
    };
    return null;
}

function hoverOpenImg() {
    var img_show = null; // tips提示
    $('td img').hover(function () {
        var kd = $(this).width();
        kd1 = kd * 3;          //图片放大倍数
        kd2 = kd * 3 + 30;       //图片放大倍数
        var img = "<img class='img_msg' src='" + $(this).attr('src') + "' style='width:" + kd1 + "px;' />";
        img_show = layer.tips(img, this, {
            tips: [2, '#999999']
        });

    }, function () {
        layer.close(img_show);
    });
    $('td img').attr('style', 'max-width:50px;display:block!important');
}


/**
 * 成功后的提示与操作
 * m: 提示信息
 * c: close
 * r: reload
 * table id暂时写死 currentTableId
 */
function tcr_table(m, c, r) {
    c = c || null;
    r = r || null;
    layer.msg(m, {
        icon: 1,
        time: 2000 //2秒关闭（如果不配置，默认是3秒）
    },function(){

        if (window.name === "") {
            if (c)			layer.close(iframeIndex);
            if (r)	        layui.table.reload('currentTableId');
        }else  {
            let iframeIndex = parent.layer.getFrameIndex(window.name);
            if (c)			parent.layer.close(iframeIndex);
            if (r)	        parent.layui.table.reload('currentTableId');
        }

    });
}