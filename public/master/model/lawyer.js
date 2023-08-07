const Lawyer = {
    get_cates(data, cb) {
        handleAjax('/admin/lawyer/cates', data).done((res)=>{
            cb && cb(res)
        }).fail(function(msg){
            layer.msg(msg);
        });
    },

}

