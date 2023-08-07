function handleAjax(url, param, type) {
  	return ajax(url, param, type).then(function(resp){

		if (resp && typeof resp === 'string') {
			resp = JSON.parse(resp);
		}

		if(resp.code === 0){
        	return resp || true; // 直接返回要处理的数据，作为默认参数传入之后done()方法的回调
      	}else{
      		console.log(resp);
      		if (resp.code === 401) { // 401直接未登录跳转
            	window.location = '/admin/login/index';
      		}
			if (resp.code === 403) { // 403权限不足

			}
			let msg = typeof resp.message === "undefined" ? "接口错误" : resp.message;
        	return $.Deferred().reject(msg); // 返回一个失败状态的deferred对象，把错误代码作为默认参数传入之后fail()方法的回调
      	}
    }, function(err){
      	// 网络请求失败
      	console.log(err);
    });
}


function ajax(url, param, type) {
  	// 利用了jquery延迟对象回调的方式对ajax封装，使用done()，fail()，always()等方法进行链式回调操作
  	// 如果需要的参数更多，比如有跨域dataType需要设置为'jsonp'等等，也可以不做这一层封装，还是根据工程实际情况判断吧，重要的还是链式回调
  	return $.ajax({
    	url: url,
    	data: param || {},
    	type: type || 'GET'
  	});
}