Vue.component('dx-component-sidepage',{
    data:function(){
        return {
            navs:[
                {
                    title:' 系统管理',
                    icon:"layui-icon layui-icon-util",
                    snav:[
                        {title:"系统信息",icon:"layui-icon layui-icon-add-1",url:""},
                        {title:"城市字典",icon:"layui-icon layui-icon-add-1",url:"/pages/city/country.html"},
                    ]
                },
                 {
                    title:' 权限管理',
                    icon:"layui-icon layui-icon-auz",
                    snav:[
                        {title:"角色管理",icon:"layui-icon layui-icon-add-1",url:"/pages/auth/role/"},
                        {title:"用户管理",icon:"layui-icon layui-icon-add-1",url:"/pages/auth/user/"},
                    ]
                }, 
                 {
                    title:' 资源管理',
                    icon:"layui-icon layui-icon-template-1",
                    snav:[
                        {title:"图片管理",icon:"layui-icon layui-icon-add-1",url:"/pages/resource/photo/"},
                        {title:"视频管理",icon:"layui-icon layui-icon-add-1",url:"/pages/resource/video/"},
                        {title:"音频管理",icon:"layui-icon layui-icon-add-1",url:"/pages/resource/audio/"},
                    ]
                },
                /*{
                    title:' 景点管理',
                    icon:"layui-icon layui-icon-tree",
                    snav:[
                        {title:"自然景点",icon:"layui-icon layui-icon-add-1",url:"/pages/spot/"},
                        {title:"人文景点",icon:"layui-icon layui-icon-add-1",url:""},
                        {title:"演出表演",icon:"layui-icon layui-icon-add-1",url:""},
                    ]
                },*/ 
                /*{
                    title:' 线路管理',
                    icon:"layui-icon layui-icon-location",
                    snav:[
                        {title:"跟团线路",icon:"layui-icon layui-icon-add-1",url:"/pages/line/"},
                        {title:"自驾线路",icon:"layui-icon layui-icon-add-1",url:""},
                        {title:"自助线路",icon:"layui-icon layui-icon-add-1",url:""},
                        {title:"定制线路",icon:"layui-icon layui-icon-add-1",url:""},
                    ]
                   },*/
                   /*{
                    title:' 建站管理',
                    icon:"layui-icon layui-icon-website",
                    snav:[
                        {title:"电脑移动站",icon:"layui-icon layui-icon-add-1",url:""},
                        {title:"微信公众号",icon:"layui-icon layui-icon-add-1",url:""},
                        {title:"微信小程序",icon:"layui-icon layui-icon-add-1",url:""},
                    ]
                    },*/ 
                {
                    title:'帖子管理',
                    icon:"layui-icon layui-icon-fire",
                    snav:[
                        {title:"帖子推广",icon:"layui-icon layui-icon-add-1",url:"/pages/addon/home/"} 
                    ]
                },
                 {
                    title:' 订单管理',
                    icon:"layui-icon layui-icon-cart",
                    snav:[
                        {title:"旅游订单",icon:"layui-icon layui-icon-add-1",url:"/pages/order/"},
                    ]
                },
                /*{
                    title:' 数据报告',
                    icon:"layui-icon layui-icon-table",
                    snav:[
                        {title:"搜索引擎",icon:"layui-icon layui-icon-add-1",url:""},
                        {title:"电商平台",icon:"layui-icon layui-icon-add-1",url:""}
                    ]
                } */
            ]
        }
    },
	mounted:function(){
        this.$nextTick(function () {
           $(".menu-content").hide();
        });
    },
    methods:{
		changePane:function(e){
			$(".menu-content").slideUp("slow");
			$(e.target).next().slideDown("slow");
		},
		changePage:function(e,url){
			$("#iframe").attr('src',url);
			$(e.target).css("background","#1b8fe6").siblings().css("background","");
		}
    },
    template:'<div class="navs">'
    +'	<dl v-for="item in navs">'
    +'		<dt @click="changePane($event)">'
    +'			<span><i :class="item.icon" style="font-size:14px;"></i></span>'
    +'			<span v-text="item.title"></span>'
    +'		</dt>'
    +'		<dd class="menu-content">'
	+'			<span v-for="sitem in item.snav" v-text="sitem.title" @click="changePage($event,sitem.url)"></span>'
	+'		</dd>'
    +'	</dl>'
    +'</div>'
})