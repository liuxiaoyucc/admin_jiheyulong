const Banner = {
    info(banner_id, cb) {
        handleAjax('/admin/banner/info', {banner_id}).done((res)=>{
            cb && cb(res);
        }).fail(function(msg){
            console.log(msg);
            layer.msg(msg);
        });
    },
    create(data, cb) {
        handleAjax('/admin/banner/create', data, 'POST').done((res)=>{
            tcr_table(res.message, 1, 1);
            cb && cb(res);
        }).fail(function(msg){
            tcr_table(msg)
        });
    },
    update(data, cb) {
        handleAjax('/admin/banner/update', data, 'POST').done((res)=>{
            tcr_table(res.message, 1, 1);

            cb && cb()
        }).fail(function(msg){
            layer.msg(msg);
        });
    },
    remove(ids, cb) {
        handleAjax('/admin/banner/remove', {ids}, 'POST').done((res)=>{
            tcr_table(res.message);
            cb && cb(res);
        }).fail(function(msg){
            layer.msg(msg);
        });
    },

    get_positions(data, cb) {
        handleAjax('/admin/banner/get_positions', data).done((res)=>{
            cb && cb(res)
        }).fail(function(msg){
            layer.msg(msg);
        });
    }
}
