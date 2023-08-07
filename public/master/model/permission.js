const Permission = {
	auth_edit(auth_group_id, rule, cb) {
		handleAjax('/admin/Permission/auth_edit', {auth_group_id: auth_group_id,rule: rule}, 'POST').done((res)=>{
			layer.msg(res.message);
			cb && cb()
		}).fail(function(msg){
			layer.msg(msg);
		});
	},
	get_auth_info(auth_group_id, cb) {
		handleAjax('/admin/Permission/auth_info', {auth_group_id: auth_group_id}, 'POST').done((res)=>{
			cb && cb(res.data);
		}).fail(function(msg){
			layer.msg(msg);
		});
	},
	list(cb) {
		handleAjax('/admin/Permission/list', {}, 'POST').done((res)=>{
	        cb && cb(res.data);
    	}).fail(function(msg){
			layer.msg(msg);
    	});
	},
	remove(ids, cb) {
		handleAjax('/admin/Permission/remove', {ids}, 'POST').done((res)=>{
			tcr_table(res.message);
	        cb && cb(res);
    	}).fail(function(msg){
			layer.msg(msg);
    	});
	},
	add(data, cb) {
		handleAjax('/admin/Permission/add', data, 'POST').done((res)=>{
			tcr_table(res.message, 1, 1);
        	cb && cb(res);
    	}).fail(function(msg){
			layer.msg(msg);
    	});
	},
	edit(data, cb) {
		handleAjax('/admin/Permission/edit', data, 'POST').done((res)=>{
			tcr_table(res.message, 1, 1);
        	cb && cb(res);
    	}).fail(function(msg){
			layer.msg(msg);
    	});
	},
	info(auth_group_id, cb) {
		handleAjax('/admin/Permission/info', {auth_group_id}).done((res)=>{
        	cb && cb(res);
    	}).fail(function(msg){
			layer.msg(msg);
    	});
	}
}

/**
 * 成功后的提示与操作
 * m: 提示信息
 * c: close
 * r: reload
 * table id暂时写死 currentTableId
 */
function tcr_table(m, c, r) {
	c = c || 0;
	r = r || 0;
	layer.msg(m, {
        icon: 1,
        time: 2000 //2秒关闭（如果不配置，默认是3秒）
    }, function(){

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