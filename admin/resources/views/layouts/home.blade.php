<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="//cdn.bootcss.com/bootstrap-table/1.11.0/bootstrap-table.min.css" rel="stylesheet">

    <!-- 外联样式 -->
    @yield('css')

    <!-- 内联样式 -->
    @yield('style')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (!Auth::guest())
                            <li><a href="{{ url('/home') }}">首页</a></li>
                            @foreach ($menus as $menu)
                                @if ($menu->childMenus->isEmpty())

                                {{-- 一级菜单 --}}
                                <li class="{{$menu->active}}"><a href="{{ route($menu->route_name) }}">{{$menu->name}}</a></li>

                                @else

                                {{-- 二级菜单 --}}
                                <li class="dropdown {{$menu->active}}">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ $menu->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        @foreach ($menu->childMenus as $menu2)
                                        <li class="{{$menu2->active}}"><a href="{{ route($menu2->route_name) }}">{{$menu2->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>

                                @endif
                            @endforeach
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            {{-- <li><a href="{{ route('login') }}">登录</a></li> --}}
                            {{-- <li><a href="{{ route('register') }}">注册</a></li> --}}
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            退出
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    {{-- 面包屑导航 --}}
                    @yield('breadcrumb')

                    {{-- 操作提示 --}}
                    @include('home/common/message')

                    {{-- 表单错误 --}}
                    @include('home/common/validator')

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="//cdn.bootcss.com/bootstrap-table/1.11.0/bootstrap-table.min.js"></script> --}}

    <!-- 外联js -->
    @yield('js')

    <!-- 内联js -->
    <script>

    // set location.search to localStorage; get from localStorage to index
    function saveSearch() {
        localStorage.localSearch = location.search
    }

    $(function(){

        // 全选／反选
        $("#check_all").click(function(){
            $("#list :checkbox").each(function () {
                $(this).prop("checked", !$(this).prop("checked"))
            })
        })

        // 操作选中项
        $(".check_action").click(function(){
            var $this = $(this)
            var href = $this.attr('href')

            // 获取选中的参数
            var ids = []
            $('.multi_checkbox:checked').each(function() {
                ids.push($(this).val())
            })

            if (ids.length <= 0) {
                alert('请选择操作的项目')
                return false
            }

            var idsStr = ids.join(',')

            location.href = href + '?ids=' + idsStr

            return false
        })
    })
    </script>
    @yield('script')
</body>
</html>
