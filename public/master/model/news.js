const News = {
    get_cates(data, cb) {
        handleAjax('/admin/news/cates', data).done((res)=>{
            cb && cb(res)
        }).fail(function(msg){
            layer.msg(msg);
        });
    },

}

