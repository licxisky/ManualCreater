@extends('common.layout')

@section('css')

    <style>
        .fa-edit, .fa-check {
            color: green;
        }
        .fa {
            margin-left: 10px;
        }
        .breadcrumb {
            background-color: #ded8d8;
            margin-bottom: 5px;
        }
    </style>
    @if(session('mn_userrole') == session('mn_adminid'))
    <link href="{{ asset('ckeditor') }}/plugins/codesnippet/lib/highlight/styles/default.css" rel="stylesheet">
    @endif
@endsection

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
                    {{ $manual->manual_title }}
                    @if(session('mn_userrole') == session('mn_adminid'))
                        @if($type == 'edit')
                        <a href="#" onclick="update()"><i class="fa fa-check"></i></a>
                        @else
                        <a href="{{ url($manual->id.'/'.$manual->manual_secret.'?type=edit') }}"><i class="fa fa-edit"></i></a>
                        @endif
                    @endif
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
                            <div id="editor" @if(session('mn_userrole') == session('mn_adminid'))@if($type == 'edit')contenteditable="true"@endif @endif>
                                {!! $manual->manual_description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('mn_userrole') == session('mn_adminid'))
    <div class="hidden">
        <form id="update-manual" method="post" action="{{ url('edit/'.$manual->id) }}">
            {{ csrf_field() }}
            <input type="hidden" id="input_manual_description" value="" name="description">
        </form>
    </div>
    @endif

@endsection

@section('javascript')

    @if(session('mn_userrole') == session('mn_adminid'))
        <script src="{{ asset('ckeditor') }}/ckeditor.js"></script>
        <script src="{{ asset('ckeditor') }}/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>

        <script>hljs.initHighlightingOnLoad();</script>
        @if($type == 'edit')
        <script>
            CKEDITOR.disableAutoInline = true;
            CKEDITOR.inline( 'editor', {
                filebrowserImageUploadUrl : '{{ url('imageupload') }}?_token={{ csrf_token() }}',
                extraPlugins: 'uploadimage,sourcedialog,image2,widget,dialog,codesnippet,button,panelbutton,floatpanel,colorbutton',
                codeSnippet_languages : {
                    php: 'PHP',
                    html: 'Html',
                    javascript: 'JavaScript'
                },
                colorButton_enableMore: false
            });
            function update() {
                $('#input_manual_description').val( CKEDITOR.instances.editor.getData());
                $('#update-manual').submit();
            }

        </script>
        @endif
    @endif

@endsection