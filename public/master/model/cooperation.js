const Cooperation = {
    get_cates(data, cb) {
        handleAjax('/admin/cooperation/cates', data).done((res)=>{
            cb && cb(res)
        }).fail(function(msg){
            layer.msg(msg);
        });
    },

}
