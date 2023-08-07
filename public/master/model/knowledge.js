const Knowledge = {
    get_cates(data, cb) {
        handleAjax('/admin/knowledge/cates', data).done((res)=>{
            cb && cb(res)
        }).fail(function(msg){
            layer.msg(msg);
        });
    },

}

