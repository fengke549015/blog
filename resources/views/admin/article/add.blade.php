@extends('layouts.admin')
@section('daohang')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  添加分类列表
    </div>
    <!--面包屑导航 结束-->

    @endsection
@section('jieguo')
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>分类管理</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin\category\create ')}}"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{url('admin\category')}}"><i class="fa fa-recycle"></i>全部分类</a>
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
                ,content: '<div style="padding: 20px 80px;">数据添加成功</div>'
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
        <form action="{{url('admin/upload')}}" method="post" id="commentForm" enctype="multipart/form-data">
            <table class="add_tab">
                {{csrf_field()}}
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>分类名称：</th>
                        <td>
                            <select name="cate_pid">

                                @foreach($data as $val)
                                <option value="{{$val->cate_id}}">{{$val->_cate_name}}</option>
                                @endforeach
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" name="art_title" data-rule-required="true" class="lg">
                            <span><i class="fa fa-exclamation-circle yellow"></i>文章标题是必填项</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>作者：</th>
                        <td>
                            <input type="text" name="art_editor" data-rule-required="true">

                        </td>
                    </tr>

                    <tr>
                        <th>文章描述：</th>
                        <td>
                            <textarea name="art_content"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>封面缩略图：</th>
                        <td>
                            <input type="file" size="50" name="file" >

                            <style>
                                .uploadify{display:inline-block;}
                                .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                                table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                            </style>
                        </td>
                    </tr>
                    <tr>
                        <th>主要内容：</th>
                        <td>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources\org\ueditor\ueditor.config.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources\org\ueditor\ueditor.all.min.js')}}"> </script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources\org\ueditor\lang/zh-cn/zh-cn.js')}}"></script>
                            <script id="editor" type="text/plain" style="width:860px;height:500px;" name="art_content"></script>

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