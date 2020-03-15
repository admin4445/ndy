var dxComponentLineOp ={
    data:function () {
        return {
           order:{
                Contacts:"",
                Telephone:"",
                Number:"",
                Trip:"",
                TotalSum:"",
                Deposit:"",
                Remarks:"",
                Operator:"",
                token:localStorage.token,
                Status:""
            },
            mode:1
        }
    },
    methods:{
        //添加订单
        addOrderHandle:function(){
            this.$http.post(api.Addorder,this.order,{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstOrder();
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("服务器无响应，请联系技术人员"); 
            });
        },
        //编辑订单
        edtOrderHandle:function(){
            this.$http.post(api.Updateorder,this.order,{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstOrder();
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("服务器无响应，请联系技术人员"); 
            });
        }
    },
    template:'<div class="layui-form orderTable" lay-filter="orderTable" style="display:none;margin-right:30px;">'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">团队领队</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入团队领队" class="layui-input" v-model="order.Contacts">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">联系电话</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入联系电话" class="layui-input" v-model="order.Telephone">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">出游人数</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入出游人数" class="layui-input" v-model="order.Number">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">所选行程</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入所选行程" class="layui-input" v-model="order.Trip">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">参团金额</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入参团金额" class="layui-input" v-model="order.TotalSum">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">预付订金</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入预付订金" class="layui-input" v-model="order.Deposit">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">订单日期</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入订单日期" class="layui-input" v-model="order.Date">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane v-if="2==mode">'
    +'    <label class="layui-form-label">订单状态</label>'
    +'    <div class="layui-input-block">'
    +'      <select lay-filter="orderStatus">'
    +'          <option value="2">完成</option>'
    +'          <option value="3">取消</option>'
    +'      </select>'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item layui-form-text">'
    +'<label class="layui-form-label">订单备注</label>'
    +'<div class="layui-input-block">'
    +'<textarea placeholder="请输入预订人的身份证和联系方式" class="layui-textarea" v-model="order.Remarks"></textarea>'
    +'</div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">业务人员</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入业务人员" class="layui-input" v-model="order.Operator">'
    +'    </div>'
    +'</div>'
    +'</div>'
}