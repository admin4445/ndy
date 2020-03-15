Vue.component('dx-component-navbar', {
    data:function(){
        return{
            nav:[]
        }
    },
    template:'<div class="nav">'
    +'<span><i class="layui-icon">&#xe68e;</i> 当前位置：<a href="#">控制台</a></span>'
    +'<span v-for="item in nav"><i class="layui-icon">&#xe602;</i> <a :href="item.url" v-text="item.name"></a></span>'
    +'</div>'
})