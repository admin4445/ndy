var kefuInfo = kefu[0];
$(function() {
    // 如果不是PC端
    if (IsPC() == false) {
        loadScript('/wenda/public/resources/js/clipboard.min.js', function(){
            var _hmtTrackEvent = [];
            var html = '';
            html += '<style>';
            html += '#tk{ position: fixed; z-index: 99; transition: all 0.5s; border-radius: 18px; margin: auto; left: 0; right: 0; bottom: -250px; overflow: hidden;  background:#F9F9F9;  width: 90%;}';
            html += '#tk div{ width: 100%; height: 60px ; border-bottom: 1px solid #D1D1D3; text-align: center; font-size: 20px; font-family:微软雅黑; line-height: 60px; color:#0876FB; }';
            html += '#tk div:hover{ background:#eee;}';
            html += '#tk a:last-child div{ border-bottom: none !important; }';
            html += '#closetk{ position: fixed; transition: all 0.5s; z-index: 99; width: 90%; height: 60px ; text-align: center;  margin: auto; left: 0; right: 0; bottom: -300px;font-size: 20px; font-family:微软雅黑; font-weight: bold; line-height: 60px; background: #fff; color:#0876FB;border-radius: 15px; cursor: pointer;}';
            html += '#tck{ position: fixed;top:0px;left:0px; z-index: 90; width: 100%; height: 100%; background: rgba(0,0,0,0.4);transition: all 0.8s;}';
            html += '</style>';
            html += '<div id="tck"></div>';
            html += '<div id="tk"><div id="fzwx" style="font-size:15px;color:#4d9dfe">请加微信</div>';
            html += '<div class="fzbtn" style="cursor: pointer;">点击复制<span style="font-size:14px;">（<span id="fzzz" style="font-size:14px;cursor: pointer;"></span>）</span></div>';
            html += '<a style="text-decoration:none;" href="weixin://">';
            html += '<div style="cursor: pointer;">';
            html += '打开微信<span style="font-size:14px;">（选择添加朋友）</span>';
            html += '</div>';
            html += '</a>';
            html += '<a style="text-decoration:none;" id="tel" href="tel:"">';
            html += '<div style="cursor: pointer;">或点击拨打电话</div>';
            html += '</a>';
            html += '</div>';
            html += '<div id="closetk">取消</div>';
            $('body').append(html);
            $('#tck').hide();
            $('#closetk,#tck').bind('click', function() {
                $('#tck').css('display', 'none');
                $('#tk').css('bottom', '-290px');
                $('#closetk').css('bottom', '-300px');
            });
            $('.dx-tel').click(function() {
                var kefu_type = $(this).attr('class');
                $('#fzzz').text('');
                $('#fzwx').text('');
                if(kefu_type == 'dx-tel'){
                    $('#fzzz').text(kefuInfo.tel);
                    $('#fzwx').text('该号码是微信和手机号');
                    $('#tel').attr('href', 'tel:' + kefuInfo.tel).show();
                }else{
                    $('#fzzz').text(kefuInfo.weixin);
                    $('#fzwx').text(kefuInfo.weixin + '是微信号');
                    $('#tel').hide();
                }
                $('#tck').show();
                $('#tk').css('bottom', '80px');
                $('#closetk').css('bottom', '10px');
            });
            var clipboard = new ClipboardJS('.fzbtn', {
                text: function() {
                    return $('#fzzz').text();
                }
            });
            clipboard.on('success', function(e) {
                alert('复制成功');
            });
            clipboard.on('error', function(e) {
                alert('复制失败，请长按号码复制');
            });
        });
    }
});
function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "android", "iPhone", "iphone", "SymbianOS", "Windows Phone", "iPad", "iPod"];
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}
function loadScript(url, callback) {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    if (typeof(callback) != 'undefined') {
        if (script.readyState) {
            script.onreadystatechange = function() {
                if (script.readyState == 'loaded' || script.readyState == 'complete') {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {
            script.onload = function() {
                callback();
            };
        }
    }
    script.src = url;
    document.body.appendChild(script);
}