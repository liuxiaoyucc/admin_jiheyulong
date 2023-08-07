const Specialist = {
    majors(data, cb) {
        handleAjax('/admin/specialist/majors', data).done((res)=>{
            cb && cb(res)
        }).fail(function(msg){
            layer.msg(msg);
        });
    },

}
