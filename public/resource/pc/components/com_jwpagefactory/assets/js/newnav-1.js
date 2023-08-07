/*
 * @Author: your name
 * @Date: 2021-04-16 13:17:30
 * @LastEditTime: 2021-05-27 18:02:38
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \joomla_test\components\com_jwpagefactory\assets\js\newnav.js
 *
 */
jQuery(function(e){
    e(document).on("mouseenter", ".sprite02", function (o) {
        o.preventDefault(),
            // console.log(3636)
        e(this).find(".children").animate({ opacity: "show", height: "show" }, 300);
        e(this).find(".depth1").addClass("navhover");
    });
    e(document).on("mouseleave", ".sprite02", function (o) {
        o.preventDefault(),
            // console.log(3637)
        e(".children").stop(true, true).hide();
        e(".depth1").removeClass("navhover");
    });
    // 点击翻页
    e(document).on("click", ".page_num", function (o) {
        // o.preventDefault();
        // 区块id
        let secid_88759_activ=e(this).parents(".jwpf-section")[e(this).parents(".jwpf-section").length-1].id;

        //有tab选项卡
        // if(e(`#${secid_88759_activ} .page_n`)){
        if(e('#' + secid_88759_activ + ' .page_n')){
            // 保存区块id
            sessionStorage.setItem("tabsecid", secid_88759_activ);
            // 遍历tab 获取href
            // e(`#${secid_88759_activ} li.page_n`).each(function(){
            e('#' + secid_88759_activ + ' ul:first li.page_n').each(function(){
                if(e(this).hasClass('active')) {
                    if (e(this).find('a').attr('href')) {
                        sessionStorage.setItem(secid_88759_activ, e(this).find('a').attr('href').substr(1));
                        var fdi=e(this).find('a').attr('id');
                        sessionStorage.setItem("first_liid", fdi);
                        // console.log('first_liid',fdi);
                    }
                }
            })

            var tid=sessionStorage.getItem("tabsecid");
            var tab_content_id=sessionStorage.getItem(tid);
            // console.log('first_contid',tab_content_id);
            if(tab_content_id){
                sessionStorage.setItem("first_contid", tab_content_id);
            }
            if(e('#' + tab_content_id + ' .jwpf-tab-content')){
                e('#' + tab_content_id + ' .jwpf-tab-content div').each(function(){

                    if(e(this).hasClass('active')) {
                        var contentid=e(this).attr('id');
                        // 保存选中内容id
                        sessionStorage.setItem("tab_content_id", contentid);
                        // console.log('contentid',contentid);
                    }
                })
            }
            if(e('#' + tab_content_id + ' li.page_n')){
                e('#' + tab_content_id + '  li.page_n').each(function(){

                    if(e(this).hasClass('active')) {
                        var liid=e(this).find('a').attr('id');
                        // 保存选中内容id
                        sessionStorage.setItem("tab_li_id", liid);
                        // console.log('liid',liid);
                    }
                })
            }

        }

    });
    // 页面加载处理翻页
    window.onload=function (){
        // 没有点击翻页
        var tid=sessionStorage.getItem("tabsecid");//外层区块id

        
        //第一层选项卡li中a链接的 id （自带#）
        var first_liid=sessionStorage.getItem('first_liid');
        // console.log('first_liid1',first_liid)
        // content页面id
        var tab_content_id=sessionStorage.getItem(tid);//第一层内容div的id
        // console.log('first_contid1',tab_content_id)

        var content_id=sessionStorage.getItem("first_contid");//第一层内容div的id
        // console.log('contid1',content_id)



        var tab_li_id=sessionStorage.getItem("tab_li_id");//第二层选项卡li中a链接的 id （自带#）
        // console.log('secd_liid2',tab_li_id);
        var contid=sessionStorage.getItem("tab_content_id");//第二层选项卡内容id
        // console.log('secd_contid2',contid);
        
        if(!sessionStorage.getItem("tabsecid")){
        
        }else{
            
            // tab 选项操作
            
             // 移除active
            // e(`#${tid} li.page_n`).removeClass("active");
            
            // e('#' + tid + ' ul li.page_n').removeClass("active");
            //  e('#' + tid + ' li.page_n').each(function(){
             

            // e('#' + content_id + ' li.page_n').removeClass("active");
            e('#' + content_id + ' .jwpf-tab-content>div:first').each(function(aa){

            })


            // e('#' + tid + ' ul:first-child li.page_n:first-child:not(#' + content_id +')').addClass("active");
            // var dd=e('#' + tid + ' ul:first-child li.page_n:first-child:not(#' + content_id +') li');
            // console.log('dd',dd)
            // 添加当前状态
            // e(`#${tid} li.page_n`).each(function(){
            e('#' + tid + ' li.page_n').each(function(){
                if(e(this).find('a').attr('id')==first_liid){
                    e(this).siblings(".active").removeClass("active");
                }
                if(e(this).find('a').attr('href')=='#' + content_id){
                    e(this).addClass("active")
                }

                if(e(this).find('a').attr('id')==tab_li_id){
                    e(this).addClass("active")
                }

            })


            // content页面操作
            // 移除active in
            // e(`#${tid} .jwpf-tab-pane`).removeClass("active");
            e('#' + tid + ' .jwpf-tab-pane').removeClass("active");
            // e(`#${tid} .jwpf-tab-pane`).removeClass("in");
            e('#' + tid + ' .jwpf-tab-pane').removeClass("in");

            e('#' + content_id ).siblings().each(function(aa){
                    // console.log('div', e(this).attr("id"));
                    e(this).find('li.page_n:first').addClass("active");
                    e(this).find('.jwpf-tab-content>div:first').addClass("active");
                    e(this).find('.jwpf-tab-content>div:first').addClass("in");
            })
            // 添加当前状态
            // e(`#${tid} .jwpf-tab-content>div`).each(function(){
            e('#' + tid + ' .jwpf-tab-content>div').each(function(aa){

                    // if(e(this).attr('id')==`${tab_content_id}`){ //判断传来的tid和本条div的id属性相同就显示
                    if(e(this).attr('id')==content_id){ //判断传来的tid和本条div的id属性相同就显示
                        e(this).addClass("active");
                        e(this).addClass("in");
                        
                    }
                    if(e(this).attr('id')==contid){ //判断传来的tid和本条div的id属性相同就显示
                        e(this).addClass("active");
                        e(this).addClass("in");

                    }

            })
            // e('#' + tid + ' .jwpf-tab-content div:first-child:not(' + content_id +')').addClass("active in");

            // sessionStorage.setItem("tab_content_id", 0);
            // sessionStorage.setItem("tab_li_id", 0);
            sessionStorage.setItem("tabsecid", 0);
        }
    }
})
