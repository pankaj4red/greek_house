<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Admin Area</title>

        <link href="{{ asset('admin-resources/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin-resources/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin-resources/sb-admin2/css/sb-admin-2.css') }}" rel="stylesheet">
        <link href="{{ asset('admin-resources/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
              type="text/css">
        <link href="{{ asset('admin-resources/custom/style.css') . '?v=' . config('greekhouse.css_version') }}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!--[if lt IE 9]>
        <script src="{{ static_asset('js/html5shiv.min.js') }}"></script>
        <script src="{{ static_asset('js/respond.min.js') }}"></script>
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('admin::index') }}">Greek House Admin Panel</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <li><a href="{{ route('dashboard::index') }}"><i class="fa fa-power-off fa-fw"></i></a></li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="{{ route('admin::index') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            @if (Auth::user()->isType(['admin', 'support']))
                            <li>
                                <a href="{{ route('admin::campaign::list') }}"><i class="fa fa-th fa-fw"></i> Campaigns</a>
                            </li>
                            <li>
                                <a href="{{ route('admin::user::list') }}"><i class="fa fa-users fa-fw"></i> Users</a>
                            </li>
                            <li>
                                <a href="{{ route('admin::order::list') }}"><i class="fa fa-credit-card fa-fw"></i>
                                    Orders</a>
                            </li>
                            <li>
                                <a href="{{ route('admin::store::list') }}"><i class="fa fa-archive fa-fw"></i>
                                    Manage Stores</a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ route('admin::product::list') }}"><i class="fa fa-cubes fa-fw"></i> Products</a>
                            </li>
                            @if (Auth::user()->isType(['admin', 'product_qa', 'product_manager']))
                            <li>
                                <a href="{{ route('admin::garment_brand::list') }}"><i class="fa fa-tags fa-fw"></i> Garment
                                    Brands</a>
                            </li>
                            <li>
                                <a href="{{ route('admin::garment_category::list') }}"><i class="fa fa-folder fa-fw"></i>
                                    Garment Categories</a>
                            </li>
                            @endif
                            @if (Auth::user()->isType(['support', 'admin']))
                            <li>
                                <a href="{{ route('admin::design::list') }}"><i class="fa fa-picture-o fa-fw"></i>
                                    Designs</a>
                            </li>
                            <li>
                                <a href="{{ route('admin::design::trending') }}"><i class="fa fa-comments-o fa-fw"></i>
                                    Trending</a>
                            </li>
                            <li>
                                <a href="{{ route('admin::supplier::list') }}"><i class="fa fa-sitemap fa-fw"></i> Supplies</a>
                            </li>
                            @endif

                            @if (Auth::user()->isType(['admin']))
                            <li>
                                <a href="{{ route('admin::log::list') }}"><i class="fa fa-bug fa-fw"></i>
                                    Logs</a>
                            </li>
                            @endif
                            @if (Auth::user()->isType(['admin']))
                            <li>
                                <a href="{{ route('admin::slider::list') }}"><i class="fa fa-image fa-fw"></i>
                                    Home Page Slider</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (messages_exist())
                            {!! messages_output() !!}
                            @endif
                            @yield('content')
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <script src="{{ static_asset('admin-resources/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ static_asset('admin-resources/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ static_asset('admin-resources/metisMenu/dist/metisMenu.min.js') }}"></script>
        <script src="{{ static_asset('admin-resources/sb-admin2/js/sb-admin-2.js') }}"></script>
        @yield('javascript')

    </body>

</html>
