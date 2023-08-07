const Manager = {
	remove(ids, cb) {
		handleAjax('/admin/manage/remove', {ids}, 'POST').done((res)=>{
			tcr_table(res.message);
	        cb && cb(res);
    	}).fail(function(msg){
			layer.msg(msg);
    	});
	},
	create(data, cb) {
		handleAjax('/admin/manage/create', data, 'POST').done((res)=>{
			tcr_table(res.message, 1, 1);
        	cb && cb(res);
    	}).fail(function(msg){
			tcr_table(msg)
    	});
	},
	edit(data, cb) {
		handleAjax('/admin/manage/update', data, 'POST').done((res)=>{
			tcr_table(res.message, 1, 1);
        	cb && cb(res);
    	}).fail(function(msg){
			layer.msg(msg);
    	});
	},
	info(manager_id, cb) {
		handleAjax('/admin/manage/info', {manager_id}).done((res)=>{
        	cb && cb(res);
    	}).fail(function(msg){
			layer.msg(msg);
    	});
	},

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