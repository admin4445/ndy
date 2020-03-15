var api={
   //资源上传接口////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   UserImg:"http://www.media.com/index.php/index/Upload/uploadBasePhoto",//图片上传接口
   uploadImges:"http:/www.media.com/index.php/index/Upload/uploadBasePhoto",//图片上传接口
   uploadVideo:"http://www.media.com/index.php/index/Upload/uploadVideo",//视频上传接口
   uploadAudio:"http:/www.media.com/index.php/index/Upload/UploadAudio",//音频上传接口
   //图片管理接口////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   ListCatalog:"http://www.api.com/index.php/index/Mapwarehouse/SelectCatalog",    //列表目录接口
   AddCatalog:"http://www.api.com/index.php/index/Mapwarehouse/AddCatalog",   //创建目录接口
   FindCatalog:"http://www.api.com/index.php/index/Mapwarehouse/FindCatalog",  //查询单个目录接口
   UpdateCatalog:"http://www.api.com/index.php/index/Mapwarehouse/UpdateCatalog", //提交编辑目录接口
   DeleteCatalog:"http://www.api.com/index.php/index/Mapwarehouse/DeleteCatalog", //删除目录接口
   UploadSub:"http://www.api.com/index.php/index/photo/AddImg"  ,  //上传图片提交接口
   SelectImg:"http://www.api.com/index.php/index/Photo/SelectImg",//上传图片查询接口
   deleteImg:"http://www.api.com/index.php/index/Photo/DeleteImg", //删除图片的接口
   Findimg:"http://www.api.com/index.php/index/photo/findimg",//查询单个图片接口
   UpdateImg:"http://www.api.com/index.php/index/photo/UpdateImg", //提交编辑图片接口
   //视频管理接口////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   SelectVideocatalog:"http://www.api.com/index.php/index/VideoCatalog/SelectVideocatalog",//列表视频目录接口
   AddVideocatalog:"http://www.api.com/index.php/index/VideoCatalog/AddVideocatalog",//创建视频目录接口
   UpdateVideocatalog:"http://www.api.com/index.php/index/VideoCatalog/UpdateVideocatalog",//修改视频目录接口
   FindVideocatalog:"http://www.api.com/index.php/index/VideoCatalog/FindVideocatalog",//查询单个视频目录接口
   DeleteVideocatalog:"http://www.api.com/index.php/index/VideoCatalog/DeleteVideocatalog",//删除单个视频目录接口
   SelectVideo:"http://www.api.com/index.php/index/Video/SelectVideo",//列表视频接口
   AddVideo:"http://www.api.com/index.php/index/Video/AddVideo",//添加视频接口
   UpdateVideo:"http://www.api.com/index.php/index/Video/UpdateVideo",//修改视频接口
   FindVideo:"http://www.api.com/index.php/index/Video/FindVideo",//查询单个视频接口
   DeleteVideo:"http://www.api.com/index.php/index/Video/DeleteVideo",//删除视频接口
   //音频管理接口///////////////////////////////////////////////////////////////////////////////////////////////////////////////
   SelectAudiocatalog:"http://www.api.com/index.php/index/Audiocatalog/SelectAudiocatalog",//列表音频目录接口
   AddAudiocatalog:"http://www.api.com/index.php/index/Audiocatalog/AddAudiocatalog",//创建音频目录接口
   UpdateAudiocatalog:"http://www.api.com/index.php/index/Audiocatalog/UpdateAudiocatalog",//修改音频目录接口
   DeleteAudiocatalog:"http://www.api.com/index.php/index/Audiocatalog/DeleteAudiocatalog",//删除音频目录接口
   FindAudiocatalog:"http://www.api.com/index.php/index/Audiocatalog/FindAudiocatalog",//查询单个音频目录接口
   SelectAudio:"http://www.api.com/index.php/index/Audio/SelectAudio",//查询音频接口
   AddAudio:"http://www.api.com/index.php/index/Audio/AddAudio",//添加音频接口
   UpdateAudio:"http://www.api.com/index.php/index/Audio/UpdateAudio",//修改音频接口
   DeleteAudio:"http://www.api.com/index.php/index/Audio/DeleteAudio",//删除音频接口
   FindAudio:"http://www.api.com/index.php/index/Audio/FindAudio",//查询单个音频接口
   //用户登录接口//////////////////////////////////////////////////////////////////////////////////////////////////////////////
   loginUser:"http://www.api.com/index.php/index/login/login", //登陆接口
   //注册用户接口//////////////////////////////////////////////////////////////////////////////////////////////////////////////
   Register:"http://www.api.com/index.php/index/Company/Register",//注册提交接口
   //用户管理接口//////////////////////////////////////////////////////////////////////////////////////////////////////////////
   UserUpdatepassword:"http://www.api.com/index.php/index/user/Updatepassword",//用户修改密码接口
   Edtinfo:"http://www.api.com/index.php/index/user/Updatelogininfo",//修改个人信息接口
   selectCompanyinfo:"http://www.api.com/index.php/index/Company/selectCompanyinfo",//导航条公司信息接口
   //员工管理接口//////////////////////////////////////////////////////////////////////////////////////////////////////////////
   deletUser:"http://www.api.com/index.php/index/user/deleteuser",//删除用户接口
   selectUser:"http://www.api.com/index.php/index/user/selectuser",//列表用户接口
   findUser:"http://www.api.com/index.php/index/user/findUser",//查找用户接口
   updateUser:"http://www.api.com/index.php/index/user/updateuser",//修改用户接口
   addUser:"http://www.api.com/index.php/index/user/adduser",//添加接口
   Updatestatus:"http://www.api.com/index.php/index/user/Updatestatus",//用户状态开关接口
   scrUser:"http://www.api.com/index.php/index/user/filtrateselect",  //查询接口
   //角色管理接口/////////////////////////////////////////////////////////////////////////////////////////////////////////////
   selectRole:"http://www.api.com/index.php/index/role/info",//角色列表接口
   addRole:"http://www.api.com/index.php/index/rolePermission/insertrp",//角色添加接口
   deleteRole:"http://www.api.com/index.php/index/rolePermission/deleterp",//角色批量删除接口
   editRole:"http://www.api.com/index.php/index/rolePermission/updatarp",//角色修改接口
   UpdateroleStatus:"http://www.api.com/index.php/index/Role/UpdateroleStatus", //页面状态开关接口
   //权限管理接口/////////////////////////////////////////////////////////////////////////////////////////////////////////////
   permissionRole:"http://www.api.com/index.php/index/rolePermission/info", //权限列表
   selectrp:"http://www.api.com/index.php/index/Rolepermission/selectrp", //角色权限单个数据查询
   //订单管理接口/////////////////////////////////////////////////////////////////////////////////////////////////////////////
   Addorder:"http://www.api.com/index.php/index/order/Addorder",//订单添加接口
   Selectorder:"http://www.api.com/index.php/index/order/Selectorder",//订单列表接口
   Findorder:"http://www.api.com/index.php/index/order/Findorder",//订单详细信息接口
   Updateorder:"http://www.api.com/index.php/index/order/Updateorder",//订单编辑接口
   Deleteorder:"http://www.api.com/index.php/index/order/Deleteorder",//订单删除接口
   Filtrateorder:"http://www.api.com/index.php/index/order/Filtrateorder",//订单查询接口
   //区域管理接口////////////////////////////////////////////////////////////////////////////////////////////////////////////
   SelectCountry:"http://www.api.com/index.php/index/Country/SelectCountry",  //查询国家
   SelectProvince:"http://www.api.com/index.php/index/Province/SelectCountry_Province", //查询国家下的省
   SelectCitylist:"http://www.api.com/index.php/index/city/SelectProvince_city",//查询省份下的城市
   addCountry:"http://www.api.com/index.php/index/Country/addCountry" ,       //添加国家
   SelectProincial:"http://www.api.com/index.php/index/Province/SelectProvince",      //查询省份的接口
   addProincial:"http://www.api.com/index.php/index/Province/addProvince",      //添加省份的接口
   SelectCity:"http://www.api.com/index.php/index/City/SelectCity",      //查询城市的接口
   addCity:"http://www.api.com/index.php/index/City/AddCity",      //添加城市的接口
   delCountry:"http://www.api.com/index.php/index/Country/DeleteCountry",            //删除国家的接口
   delProvince:"http://www.api.com/index.php/index/Province/DeleteProvince",       //删除省份的接口
   delCity:"http://www.api.com/index.php/index/City/DeleteCity",                    //删除城市的接口
   //问答管理接口////////////////////////////////////////////////////////////////////////////////////////////////////////////
   SelectGroup:"http://www.api.com/index.php/index/Group/selectGroup", //分组列表
   AddGroup:"http://www.api.com/index.php/index/Group/AddGroup",    //添加分组接口
   UpdateGroup:"http://www.api.com/index.php/index/Group/UpdateGroup",//修改分组接口
   FindGroup:"http://www.api.com/index.php/index/Group/FindGroup",   //查询单个分组接口
   DeleteGroup:"http://www.api.com/index.php/index/Group/DeleteGroup", //删除分组接口
   selectLandingpage:"http://www.api.com/index.php/index/Landingpage/selectLandingpage", //列表落地页接口
   Selecttemplate:"http://www.api.com/index.php/index/Landingpage/Selecttemplate",
   CopyLandingpage:"http://www.api.com/index.php/index/Landingpage/CopyLandingpage",     //复制落地页接口
   DeleteLandingpage:"http://www.api.com/index.php/index/Landingpage/DeleteLandingpage", //删除落地页接口
   FindLandingpage:"http://www.api.com/index.php/index/Landingpage/FindLandingpage",//查询单个落地页接口
   UpdateLandingpage:"http://www.api.com/index.php/index/Landingpage/UpdateLandingpage",//落地页修改提交接口
   AddLandingpage:"http://www.api.com/index.php/index/Landingpage/AddLandingpage",   //添加回复接口
   insert:"http://www.api.com/index.php/index/Page/insert" ,//回答提交接口
   Selects:"http://www.api.com/index.php/index/Page/select" , //回答列表接口
   Deletes:"http://www.api.com/index.php/index/Page/delete",// 删除回答接口
   Finds:"http://www.api.com/index.php/index/page/Find",//查询单个回答接口
   Updates:"http://www.api.com/index.php/index/page/update",//修改提交接口
   UpdataLandingPageStatus:"http://www.api.com/index.php/index/Landingpage/updatecode",//落地页状态接口
   CustomerService:"http://www.api.com/index.php/index/Customerservice/SelectFindPageCustomerService",//查询落地页对应客服信息接口
   AddCustomerService:"http://www.api.com/index.php/index/Customerservice/AddFindPageCustomerService",//添加落地页客服接口
   FindCustomerService:"http://www.api.com/index.php/index/Customerservice/FindCustomerService", //查询单个落地页客服接口
   UpdateCustomerService:"http://www.api.com/index.php/index/Customerservice/UpdateCustomerService",//客服修改提交接口
   DeleteCustomerService:"http://www.api.com/index.php/index/Customerservice/DeleteCustomerService",//删除客服接口
   AddReply:"http://www.api.com/index.php/index/Replay/addReplay",//追评艾特谁的接口
   UpdateroleStatuss:"http://www.api.com/index.php/index/Customerservice/UpdateCustomerServiceCode",//客服状态接口
   SelectStatistics:"http://www.api.com/index.php/index/Statistics/SelectStatistics",//查询统计接口
   SelectCycle:"http://www.api.com/index.php/index/Statistics/SelectCycle",//查询当天,月接口
   //景点管理接口//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   Addspot:"http://www.api.com/index.php/index/Scenicspot/AddScenicSpot",//景点添加接口
   Selectspot:"http://www.api.com/index.php/index/Scenicspot/SelectScenicspot", //景点列表接口
   Deletespot:"http://www.api.com/index.php/index/Scenicspot/ScenicsSpotDelete",  //景点删除接口
   Findspot:"http://www.api.com/index.php/index/Scenicspot/ScenicsSpotFind",      //根据id查询单个数据
   Updatespot:"http://www.api.com/index.php/index/Scenicspot/ScenicsSpotUpdate",  //修改景点接口
   //线路管理接口/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   LineSelecttr:"http://www.api.com/index.php/index/Touristroute/Selecttr",//列表线路接口
  
} 