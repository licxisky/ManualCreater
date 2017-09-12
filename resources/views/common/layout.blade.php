<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>使用手册</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <!-- Bootstrap -->
    <link href="{{ asset('gentelella') }}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('gentelella') }}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('gentelella') }}/build/css/custom.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="{{ asset('gentelella') }}/vendors/jquery/dist/jquery.min.js"></script>
    {{--<!-- wangEditor-->--}}
    {{--<link href="http://cdn.bootcss.com/wangeditor/2.1.20/css/wangEditor.css" rel="stylesheet">--}}

    @section('css')
    @show


</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ url('/') }}" class="site_title"><i class="fa fa-paw"></i> <span>使用手册</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ asset('gentelella') }}/images/user.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ session('mn_username') }}</h2>
                        </div>
                    </div>

                    <br />

                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                @if(isset($menus))
                                @foreach($menus as $menu)
                                    <li @if($menu->id == $rootid)class="active"@endif><a href="{{ url($menu->id.'/'.$menu->manual_secret) }}"><i class="fa fa-dot-circle-o"></i> {{ $menu->manual_title }} </a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top_nav">
                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('gentelella') }}/images/user.png" alt="...">{{ session('mn_username') }}
                                    <span class="fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out pull-right"></i> 登出</a></li>
                                </ul>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">0</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="right_col" role="main"  style="color:darkslategray">
            @section('content')
            @show
            </div>
            <footer>
                <div class="pull-right">
                    苏州大学计算机学院教学事务管理系统 by SKLCC
                </div>
                <div class="clearfix"></div>
            </footer>
        </div>
    </div>

</body>
<!-- Javascript -->

<!-- Bootstrap -->
<script src="{{ asset('gentelella') }}/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset('gentelella') }}/build/js/custom.js"></script>
{{--<!-- wangEditor -->--}}
{{--<script src="http://cdn.bootcss.com/wangeditor/2.1.20/js/wangEditor.js"></script>--}}

@section('javascript')
@show

</html>