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
        .btn {
            margin-bottom: 0px;
        }
    </style>

@endsection

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3> 使用手册 </h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            {{--<h2><button class="btn btn-default" title="添加"><i class="fa fa-plus"></i></button></h2>--}}
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a href="#"><i class="fa fa-wrench"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-add" onclick="$('#modal-add-type').val(1)">添加目录页面</button>
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-add" onclick="$('#modal-add-type').val(2)">添加说明页面</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                <input type="hidden" id="modal-edit-id" name="id" value="">
                                <div class="form-group">
                                    <label for="link-title" class="col-sm-2 control-label">名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="modal-edit-title" name="title" placeholder="请输入链接名称">
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
        <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
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
                                <div class="form-group">
                                    <label for="link-title" class="col-sm-2 control-label">名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="modal-add-title" name="title" placeholder="请输入名称">
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
    </div>
@endsection

@section('javascript')

    <script>
        $('.edit').click(function () {
            var id = '#manual-'+$(this).attr('mid');
            $('#modal-edit-title').val($(id).text().trim());
        });
    </script>

@endsection