@extends('common.layout')

@section('css')

    <style>
        .list-group-item {
            font-size: large;
            border-color: black;
        }
        .fa-trash {
            color: red;
        }
        .fa-edit {
            color: green;
        }
        .fa {
            margin-left: 10px;
        }
        .btn-add {
            margin-bottom: 0px;
        }
        .breadcrumb {
            background-color: #ded8d8;
            margin-bottom: 5px;
        }
    </style>

@endsection

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
                    {{ $manual->manual_title }}
                </h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <ol class="breadcrumb">
                                @if(isset($breadcrumbarray))
                                    @foreach($breadcrumbarray as $breadcrumb)
                                        <li class="{{ $breadcrumb['class'] }}"><a href="{{ url($breadcrumb['id'].'/'.$breadcrumb['secret']) }}">{{ $breadcrumb['title'] }}</a></li>
                                    @endforeach
                                @endif
                                <li class="pull-right">使用手册ID：<input value="{{ $url }}" onfocus="this.select()"></li>
                            </ol>
                        </div>
                        <div class="x_content">
                            <ul class="list-group">
                                @if(isset($manual))
                                    @foreach($manual->manuals as $manual_list)
                                        <li class="list-group-item list">
                                            <i class="fa @if($manual_list->manual_type == 1)fa-folder @else fa-file-text @endif"></i>&nbsp;
                                            <a title="目录名称" href="{{ url($manual_list->id.'/'.$manual_list->manual_secret) }}" id="manual-{{ $manual_list->id }}" mat="{{ $manual_list->manual_authority }}" class="btn-link">{{ $manual_list->manual_title }}</a>&nbsp;
                                            @if($manual_list->manual_authority == 1)<i title="管理员页面" class="fa fa-lock"></i>@endif
                                            @if(session('mn_userrole') == session('mn_adminid'))
                                            <a title="删除" href="{{ url('delete/'.$manual_list->id) }}" class="trash pull-right"><i class="fa fa-trash"></i></a>
                                            <a title="编辑" href="#" mid="{{ $manual_list->id }}" class="edit pull-right" data-toggle="modal" data-target="#modal-edit"><i class="fa fa-edit"></i></a>
                                            <a title="向下移动" href="{{ url('down/'.$manual_list->id) }}" class="down pull-right"><i class="fa fa-arrow-down"></i></a>
                                            <a title="向上移动" href="{{ url('up/'.$manual_list->id) }}" class="up pull-right"><i class="fa fa-arrow-up"></i></a>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            @if(session('mn_userrole') == session('mn_adminid'))
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <button class="btn btn-add btn-sm btn-success" data-toggle="modal" data-target="#modal-add" onclick="$('#modal-add-type').val(1);">添加目录页面</button>
                                    <button class="btn btn-add btn-sm btn-info" data-toggle="modal" data-target="#modal-add" onclick="$('#modal-add-type').val(2);">添加说明页面</button>
                                </li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session('mn_userrole') == session('mn_adminid'))
    <div>
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="modal-title">
                            编辑
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="modal-edit-form" class="form-horizontal" role="form" action="{{ url('edit') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="link-title" class="col-sm-2 col-md-2 col-xs-2 control-label">名称</label>
                                    <div class="col-sm-10 col-md-10 col-xs-10 ">
                                        <input type="text" class="form-control" id="modal-edit-title" name="title" placeholder="请输入名称">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="link-title" class="col-sm-2 col-md-2 col-xs-2 control-label">权限</label>
                                    <div class="col-sm-10 col-md-10 col-xs-10 ">
                                        <select name="authority" id="modal-edit-authority" class="form-control">
                                            <option value="0">普通页面</option>
                                            <option value="1">管理员页面</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" onclick="$('#modal-edit-form').submit()">提交</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true" onchange="">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="modal-title">
                            添加
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="modal-add-form" class="form-horizontal" role="form" action="{{ url('add') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" id="modal-add-type" name="type" value="">
                                <input type="hidden" id="modal-add-parent-id" name="parentid" value="{{ $manual->id }}">
                                <div class="form-group">
                                    <label for="link-title" class="col-sm-2 col-md-2 col-xs-2 control-label">名称</label>
                                    <div class="col-sm-10 col-md-10 col-xs-10 ">
                                        <input type="text" class="form-control" id="modal-add-title" name="title" placeholder="请输入名称">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="link-title" class="col-sm-2 col-md-2 col-xs-2 control-label">权限</label>
                                    <div class="col-sm-10 col-md-10 col-xs-10 ">
                                        <select name="authority" class="form-control">
                                            <option value="0">普通页面</option>
                                            <option value="1">管理员页面</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" onclick="$('#modal-add-form').submit()">提交</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </div>
    @endif
@endsection

@section('javascript')
    @if(session('mn_userrole') == session('mn_adminid'))
    <script>
        $('.edit').click(function () {
            var id = '#manual-'+$(this).attr('mid');
            $('#modal-edit-title').val($(id).text().trim());
            $('#modal-edit-authority').val($(id).attr('mat'));
            $('#modal-edit-form').attr('action', '{{ url('edit') }}/'+$(this).attr('mid'));
        });
    </script>

    <script>
        $('.list:first').find('.up').remove();
        $('.list:last').find('.down').remove();
    </script>

    <script>
        $('.trash').click(function () {
            return confirm('请确认是否要删除');
        })
    </script>
    @endif
@endsection