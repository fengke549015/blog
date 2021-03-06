@extends('layouts.admin')
@section('daohang')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  修改文章
    </div>
    <!--面包屑导航 结束-->

    @endsection
@section('jieguo')
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>添加文章</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin\article\create ')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin\article')}}"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
@endsection
@section('main')
 @if(session('msg')=='A')
        <script>
            //layer.alert('密码修改成功', {icon: 6});
            //边缘弹出

            layer.open({
                type: 1
                ,offset: 't' //具体配置参考：offset参数项
                ,content: '<div style="padding: 20px 80px;">数据修改成功</div>'
                ,btn: '完成'
                ,btnAlign: 'c' //按钮居中
                ,shade: 0 //不显示遮罩
                ,yes: function(){
                    layer.closeAll();
                }
            });
        </script>
    @elseif(session('msg')=='B')
        <script>
            // layer.alert('原密码错误', {icon: 5});
            //边缘弹出
            layer.open({
                type: 1
                ,offset: 't' //具体配置参考：offset参数项
                ,content: '<div style="padding: 20px 80px;">遇见未知错误，请稍候重试</div>'
                ,btn: '关闭'
                ,btnAlign: 'c' //按钮居中
                ,shade: 0 //不显示遮罩
                ,yes: function(){
                    layer.closeAll();
                }
            });
        </script>
    @endif



    <div class="result_wrap">
        <form action="{{url('admin/article/'.$art->art_id)}}" method="post" id="commentForm">
            <table class="add_tab">
                {{csrf_field()}}
                {{ method_field('PUT') }}

                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="cate_id">
                                <option value="0">==顶级分类==</option>
                                @foreach($data as $val)
                                <option value="{{$val->cate_id}}"
                                        {{--表示当分类的id等于等于了选项的父id，那么他就一定是子分类，就有父id就选中他--}}
                                    @if($val->cate_id==$art->cate_id)
                                        selected
                                    @endif
                                >{{$val->_cate_name}}</option>
                                @endforeach
                            </select>
                        </td>

                    </tr>
                    <tr>

                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" name="art_title" data-rule-required="true" class="lg" value="{{$art->art_title}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>文章标题是必填项</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>作者：</th>
                        <td>
                            <input type="text" name="art_editor" data-rule-required="true" value="{{$art->art_editor}}">

                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章描述：</th>
                        <td>
                            <textarea name="art_description" data-rule-required="true" >{{$art->art_description}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th> <i class="require">*</i>封面缩略图：</th>
                        <td>
                            <input type="text" size="50" name="art_thumb" data-rule-required="true" value="{{$art->art_thumb}}">
                            <input id="file_upload" name="file_upload" type="file" multiple="true" >
                            <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                            <link rel="stylesheet" type="text/css" href="{{asset('resources/org/uploadify/uploadify.css')}}">
                            <script type="text/javascript">
                                <?php $timestamp = time();?>
$(function() {
                                    $('#file_upload').uploadify({
                                        'buttonText' : '图片上传',
                                        'formData'     : {
                                            'timestamp' : '<?php echo $timestamp;?>',
                                            '_token'     : "{{csrf_token()}}"
                                        },
                                        'swf'      : "{{asset('resources/org/uploadify/uploadify.swf')}}",
                                        'uploader' : "{{url('admin/upload')}}",
                                        'onUploadSuccess' : function(file, data, response) {
                                            $('input[name=art_thumb]').val(data);
                                            $('#art_thumb_img').attr('src','/'+data);
//                                    alert(data);
                                        }
                                    });
                                });
                            </script>
                            <style>
                                .uploadify{display:inline-block;}
                                .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                                table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                            </style>
                        </td>



                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <img src="/{{$art->art_thumb}}" alt="" height="100px">
                        </td>
                    </tr>
                    <tr>
                        <th>主要内容：</th>
                        <td>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources\org\ueditor\ueditor.config.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources\org\ueditor\ueditor.all.min.js')}}"> </script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources\org\ueditor\lang/zh-cn/zh-cn.js')}}"></script>
                            <script id="editor" type="text/plain" style="width:860px;height:500px;" name="art_content" >{!!$art->art_content!!}</script>

                            <script type="text/javascript">

                            var ue = UE.getEditor('editor');
                            </script>
                            <style>
                                .edui-default{line-height: 28px;}
                                div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow: hidden; height:20px;}
                                div.edui-box{overflow: hidden; height:22px;}
                            </style>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection