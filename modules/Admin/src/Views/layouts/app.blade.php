<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        {!! Seo::render() !!}
        <link rel="stylesheet" href="{{ url('/theme') }}/{{$adminTheme}}/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{ url('/theme') }}/{{$adminTheme}}/css/AdminLTE.min.css">
        <link rel="stylesheet" href="{{ url('/theme') }}/{{$adminTheme}}/css/skins/skin-blue.min.css">
        <link rel="stylesheet" href="{{ url('/theme') }}/{{$adminTheme}}/css/style.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        @if(isset($cssFiles))
        @foreach($cssFiles as $src)
        <link href="{{$src}}{{$cssTimeStamp}}" rel="stylesheet" type="text/css" />
        @endforeach
        @endif
        <script>
            var themePath = "{{$url}}theme/{{$theme}}/";
            var adminThemePath = "{{$url}}/theme/admin/";
            var siteUrl = "{{$url}}";
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="{{ url('/admin/dashboard') }}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Admin</b></span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success">4</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 4 messages</li>
                                    <li>
                                        <!-- inner menu: contains the messages -->
                                        <ul class="menu">
                                            <li><!-- start message -->
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <!-- User Image -->
                                                        <img src="{{ url('/theme') }}/{{$adminTheme}}/images/avatar5.png" class="img-circle" alt="User Image">
                                                    </div>
                                                    <!-- Message title and timestamp -->
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <!-- The message -->
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <!-- end message -->
                                        </ul>
                                        <!-- /.menu -->
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                </ul>
                            </li>
                            <!-- /.messages-menu -->

                            <!-- Notifications Menu -->
                            <li class="dropdown notifications-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning notificationCount">0</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have <span class="notificationCount">0</span> unread notifications</li>
                                    <li>
                                        <!-- Inner Menu: contains the notifications -->
                                        <ul class="menu" id="notification">
                                            <!-- start notification -->

                                            <!-- end notification -->
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="{{url('/admin/notification/list')}}">View all</a></li>
                                </ul>
                            </li>
                            <!-- Tasks Menu -->
                            <li class="dropdown tasks-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o"></i>
                                    <span class="label label-danger">9</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 9 tasks</li>
                                    <li>
                                        <!-- Inner menu: contains the tasks -->
                                        <ul class="menu">
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <!-- Task title and progress text -->
                                                    <h3>
                                                        Design some buttons
                                                        <small class="pull-right">20%</small>
                                                    </h3>
                                                    <!-- The progress bar -->
                                                    <div class="progress xs">
                                                        <!-- Change the css width attribute to simulate progress -->
                                                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">20% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- end task item -->
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="#">View all tasks</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->

                                    <img src="/profile/{{isset($userInfo['avatar']) ? $userInfo['avatar'] : 'avatar.png'}}" class="user-image" alt="User Image">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="/profile/{{isset($userInfo['avatar']) ? $userInfo['avatar'] : 'avatar.png'}}" class="user-image" alt="User Image">
                                        <p>
                                            {{isset($userInfo['name']) ? ucfirst($userInfo['name']) : ''}} {{isset($userInfo['position']) ? ' - '. $userInfo['position'] : ''}}
                                            <small>Member since {{date('M, Y',strtotime($userInfo['created_at']))}}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <a href="{{url('/admin/profile')}}">Profile</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="{{url('/admin/change-password')}}">Password</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="{{url('/admin/logout')}}">Sign out</a>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                        <li class="{!! Request::is('admin/dashboard') ? 'active' : '' !!}"><a href="{{url('admin/dashboard')}}"><i class="glyphicon glyphicon-dashboard"></i> <span>Dashboard</span></a></li>
                        <li class=" treeview {!! ((Request::is('admin/acl*')) || (Request::is('admin/users/*'))) ? 'active' : '' !!}">
                            <a href="#"><i class="glyphicon glyphicon-paperclip"></i><span>Users</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{!! Request::is('admin/users/list') ? 'active' : '' !!}"><a href="{{ url('admin/users/list') }}"><i class="fa fa-file"></i>User List</a></li>
                                <li class="{!! Request::is('admin/aclroles/list') ? 'active' : '' !!}"><a href="{{ url('admin/aclroles/list') }}"><i class="fa fa-file"></i>Roles</a></li>
                                <li class="{!! Request::is('admin/aclpermissions/list') ? 'active' : '' !!}"><a href="{{ url('admin/aclpermissions/list') }}"><i class="fa fa-file"></i>Permissions</a></li>
                                <li class="{!! Request::is('admin/acluserroles/list') ? 'active' : '' !!}"><a href="{{ url('admin/acluserroles/list') }}"><i class="fa fa-file"></i>User Roles</a></li>
                            </ul>
                        </li>
                        <li class="{!! Request::is('admin/activity-log') ? 'active' : '' !!}"><a href="{{url('admin/activity-log')}}"><i class="fa fa-th"></i> <span>User's Log</span></a></li>
                        <li class="{!! (Request::is('admin/image-gallery/*') || Request::is('admin/image-gallery')) ? 'active' : '' !!}"><a href="{{url('admin/image-gallery')}}"><i class="glyphicon glyphicon-picture"></i> <span>Image Gallery</span></a></li>
                        <li class="{!! Request::is('admin/messages/*') ? 'active' : '' !!}"><a href="{{url('admin/messages/inbox')}}"><i class="glyphicon glyphicon-envelope"></i> <span>Message System</span></a></li>
                        <li class="{!! (Request::is('admin/slider/*') || Request::is('admin/slider')) ? 'active' : '' !!}"><a href="{{url('admin/slider')}}"><i class="glyphicon glyphicon-repeat"></i> <span>Slider</span></a></li>
                        <li class="treeview {!! Request::is('admin/graph/*') ? 'active' : '' !!}">
                            <a href="#"><i class="fa fa-bar-chart"></i> <span>Graph</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{!! Request::is('admin/graph/area-chart') ? 'active' : '' !!}"><a href="{{url('/admin/graph/area-chart')}}">Area Chart</a></li>
                                <li class="{!! Request::is('admin/graph/bar-chart') ? 'active' : '' !!}"><a href="{{url('/admin/graph/bar-chart')}}">Bar Chart</a></li>
                                <li class="{!! Request::is('admin/graph/column-chart') ? 'active' : '' !!}"><a href="{{url('/admin/graph/column-chart')}}">Column Chart</a></li>
                                <li class="{!! Request::is('admin/graph/donut-chart') ? 'active' : '' !!}"><a href="{{url('/admin/graph/donut-chart')}}">Donut Chart</a></li>
                                <li class="{!! Request::is('admin/graph/pie-chart') ? 'active' : '' !!}"><a href="{{url('/admin/graph/pie-chart')}}">Pie Chart</a></li>
                                <li class="{!! Request::is('admin/graph/line-chart') ? 'active' : '' !!}"><a href="{{url('/admin/graph/line-chart')}}">Line Chart</a></li>
                            </ul>
                        </li>
                        <li class="treeview {!! Request::is('admin/quiz/*') ? 'active' : '' !!}">
                            <a href="#"><i class="glyphicon glyphicon-briefcase"></i> <span>Quiz</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{!! Request::is('admin/quiz/category/*') || Request::is('admin/quiz/category') ? 'active' : '' !!}"><a href="{{url('/admin/quiz/category')}}">Categories</a></li>
                                <li class="{!! Request::is('admin/quiz/list/*') || Request::is('admin/quiz/list') ? 'active' : '' !!}"><a href="{{url('/admin/quiz/list')}}">Quiz List</a></li>
                                <li class="{!! Request::is('admin/quiz/review/*') || Request::is('admin/quiz/review') ? 'active' : '' !!}"><a href="{{url('/admin/quiz/review')}}">Quiz Review</a></li>
                            </ul>
                        </li>
                        <li class="{!! Request::is('admin/reports') ? 'active' : '' !!}"><a href="{{url('admin/reports')}}"><i class="glyphicon glyphicon-file"></i> <span>Reports</span></a></li>
                        <li class="treeview {!! Request::is('admin/reminder/*') ? 'active' : '' !!}">
                            <a href="#"><i class="glyphicon glyphicon-hourglass"></i> <span>Reminder</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li class="{!! Request::is('admin/reminder/template*') ? 'active' : '' !!}"><a data-name="Template" href="{{url('/admin/reminder/template')}}" class="template-cls">Template</a></li>
                                <li class="{!! Request::is('admin/reminder/email*') ? 'active' : '' !!}"><a href="{{url('/admin/reminder/email')}}" >Send Email</a></li>
                                <li class="{!! Request::is('admin/reminder/sms*') ? 'active' : '' !!}"><a data-name="SMS" href="{{url('/admin/reminder/sms')}}" class="sms-cls">Send SMS</a></li>
                                <li class="{!! Request::is('admin/reminder/push-notification*') ? 'active' : '' !!}"><a data-name="push_notification" href="{{url('/admin/reminder/notification')}}" class="push_notification_cls">Push Notification</a></li>
                            </ul>

                        </li>

                        <li class="treeview {!! Request::is('admin/news/*') ? 'active' : '' !!}">
                            <a href="#"><i class="glyphicon glyphicon-bullhorn"></i> <span>News</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{!! Request::is('admin/news/list') ? 'active' : '' !!} {!! Request::is('admin/news/edit/*') ? 'active' : '' !!}"><a href="{{url('admin/news/list')}}"><i class="glyphicon glyphicon-book"></i>List</a></li>
                                <li class="{!! Request::is('admin/news/category/*') ? 'active' : '' !!}"><a href="{{url('admin/news/category/list')}}"><i class="glyphicon glyphicon-tags"></i>Category</a></li>
                            </ul>
                        </li>
                        <li class="{!! Request::is('admin/portfolio/*') ? 'active' : '' !!}"><a href="{{url('admin/portfolio/list')}}"><i class="fa fa-clone"></i> <span>Portfolio</span></a></li>


                        <li class="treeview {!! Request::is('admin/pages/*') ? 'active' : '' !!}">

                            <a href="#"><i class="fa fa-file"></i> <span>Pages</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{!! Request::is('admin/pages/list') ? 'active' : '' !!}"><a href="{{url('admin/pages/list')}}"><i class="fa fa-file"></i>List</a></li>
                                <li class="{!! Request::is('admin/pages/category/list') ? 'active' : '' !!}"><a href="{{url('admin/pages/category/list')}}"><i class="fa fa-file"></i>Categories</a></li>
                            </ul>
                        </li>

                        <li class="{!! Request::is('admin/testimonials/list') ? 'active' : '' !!}"><a href="{{url('admin/testimonials/list')}}"><i class="glyphicon glyphicon-user"></i> <span>Testimonials</span></a></li>
                        <li class="{!! Request::is('admin/form/list') ? 'active' : '' !!}"><a href="{{url('admin/form/list')}}"><i class="glyphicon glyphicon-list-alt"></i> <span>Forms</span></a></li>
                        <li class="{!! Request::is('admin/menu/category/list') ? 'active' : '' !!}"><a href="{{url('admin/menu/category/list')}}"><i class="glyphicon glyphicon-align-left"></i> <span>Menus</span></a></li>
                        <li class="{!! Request::is('admin/newsletters/list') ? 'active' : '' !!}"><a href="{{url('admin/newsletters/list')}}"><i class="glyphicon glyphicon-tasks"></i> <span>News Letters</span></a></li>
                        <li class="{!! Request::is('admin/reviews/list') ? 'active' : '' !!}"><a href="{{url('admin/reviews/list')}}"><i class="glyphicon glyphicon-comment"></i> <span>Reviews</span></a></li>
                        <li class="{!! Request::is('admin/poll/list') ? 'active' : '' !!}"><a href="{{url('admin/poll/list')}}"><i class="glyphicon glyphicon-record"></i> <span>Poll</span></a></li>
                        <li class="{!! Request::is('admin/locations/list') ? 'active' : '' !!}"><a href="{{url('admin/locations/list')}}"><i class="glyphicon glyphicon-map-marker"></i> <span>Locations</span></a></li>
                        <li class="treeview {!! Request::is('admin/ticket/*') ? 'active' : '' !!}">
                            <a href="#"><i class="glyphicon glyphicon-barcode"></i> <span>Tickets</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{!! Request::is('admin/tickets/list') ? 'active' : '' !!}"><a href="{{url('admin/tickets/list')}}"><i class="glyphicon glyphicon-book"></i>List</a></li>
                                <li class="{!! Request::is('admin/tickets/category/list') ? 'active' : '' !!}"><a href="{{url('admin/tickets/category/list')}}"><i class="glyphicon glyphicon-tags"></i>Category</a></li>
                            </ul>
                        </li>

                        <li class=" treeview {!! Request::is('admin/vendor*') ? 'active' : '' !!} {!! Request::is('admin/banner*') ? 'active' : '' !!}">
                            <a href="#"><i class="glyphicon glyphicon-paperclip"></i><span>Banner</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{!! Request::is('admin/banners') ? 'active' : '' !!}"><a href="{{ url('admin/banners') }}"><i class="fa fa-file"></i>Banner List</a></li>
                                <!--<li class="{!! Request::is('admin/banner/create') ? 'active' : '' !!}"><a href="{{ url('admin/banner/create') }}"><i class="glyphicon glyphicon-book"></i>Add Banner</a></li>-->
                                <li class="{!! Request::is('admin/vendors') ? 'active' : '' !!}"><a href="{{ url('admin/vendors') }}"><i class="fa fa-file"></i>Vendor List</a></li>
                                <!--<li class="{!! Request::is('admin/vendor/create') ? 'active' : '' !!}"><a href="{{ url('admin/vendor/create') }}"><i class="glyphicon glyphicon-book"></i>Add Vendor</a></li>-->
                            </ul>
                        </li>

                        <li class="{!! Request::is('admin/faqs') ? 'active' : '' !!}"><a href="{{url('admin/faqs')}}"><i class="glyphicon glyphicon-question-sign"></i> <span>Faqs</span></a></li>
                        <li class="{!! Request::is('admin/pdf/template/list') ? 'active' : '' !!}"><a href="{{url('admin/pdf/template/list')}}"><i class="fa fa-file-pdf-o"></i> <span>PDF Templates List</span></a></li>

                        <li class="treeview {!! Request::is('admin/job/*') ? 'active' : '' !!}">
                            <a href="#"><i class="fa fa-file"></i> <span>Jobs</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{!! Request::is('admin/job/list') ? 'active' : '' !!}"><a href="{{url('admin/job/list')}}"><i class="fa fa-file"></i>Job List</a></li>
                                <li class="{!! Request::is('admin/job/category/list') ? 'active' : '' !!}"><a href="{{url('admin/job/category/list')}}"><i class="fa fa-file"></i>Job Category List</a></li>
                                <li class="{!! Request::is('admin/job/employer/list') ? 'active' : '' !!}"><a href="{{url('admin/job/employer/list')}}"><i class="fa fa-file"></i>Employer List</a></li>
                                <li class="{!! Request::is('admin/job/application/list') ? 'active' : '' !!}"><a href="{{url('admin/job/application/list')}}"><i class="fa fa-file"></i>Application List</a></li>
                            </ul>
                        </li>
                        <li class="treeview {!! Request::is('admin/events/*') ? 'active' : '' !!}">

                            <a href="#"><i class="fa fa-file"></i> <span>Events</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{!! (Request::is('admin/events/edit/*') || Request::is('admin/events/list')) ? 'active' : '' !!}"><a href="{{url('admin/events/list')}}"><i class="fa fa-file"></i>Event List</a></li>
                                <li class="{!! (Request::is('admin/events/category/list') || Request::is('admin/events/category/edit/*')) ? 'active' : '' !!}"><a href="{{url('admin/events/category/list')}}"><i class="fa fa-file"></i>Event Category</a></li>
                            </ul>
                        </li>

                        <li class="{!! Request::is('admin/notification/list') ? 'active' : '' !!}"><a href="{{url('admin/notification/list')}}"><i class="glyphicon glyphicon-bell"></i> <span>Notifications</span></a></li>
                        <li class="treeview {!! Request::is('admin/survey/*') ? 'active' : '' !!}">
                            <a href="#"><i class="glyphicon glyphicon-hourglass"></i> <span>Survey</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li class="{!! Request::is('admin/survey/list') ? 'active' : '' !!}"><a data-name="Template" href="{{url('/admin/survey/list')}}" class="template-cls">Survey</a></li>
                                <li class="{!! Request::is('admin/survey/category') ? 'active' : '' !!}"><a href="{{url('/admin/survey/category/list')}}" >Category</a></li>
                            </ul>

                        </li>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- Default to the left -->
                <strong>Copyright &copy; {{date('Y')}} <a href="https://www.silicus.com" target="_blank">Silicus Company</a>.</strong> All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane active" id="control-sidebar-home-tab">
                        <h3 class="control-sidebar-heading">Recent Activity</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript::;">
                                    <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                        <p>Will be 23 on April 24th</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                        <h3 class="control-sidebar-heading">Tasks Progress</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript::;">
                                    <h4 class="control-sidebar-subheading">
                                        Custom Template Design
                                        <span class="pull-right-container">
                                            <span class="label label-danger pull-right">70%</span>
                                        </span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                    </div>
                    <!-- /.tab-pane -->
                    <!-- Stats tab content -->
                    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                    <!-- /.tab-pane -->
                    <!-- Settings tab content -->
                    <div class="tab-pane" id="control-sidebar-settings-tab">
                        <form method="post">
                            <h3 class="control-sidebar-heading">General Settings</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Report panel usage
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Some information about this general settings option
                                </p>
                            </div>
                            <!-- /.form-group -->
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <div id="application-message">
            @if (isset($successMessage) || Session::has('successMessage'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> {{ isset($successMessage) ? $successMessage : Session::get('successMessage') }}
            </div>
            @endif

            @if (isset($infoMessage) || Session::has('infoMessage'))
            <div class="alert alert-info">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Info!</strong> {{ isset($infoMessage) ? $infoMessage : Session::get('infoMessage') }}
            </div>
            @endif

            @if (isset($warningMessage) || Session::has('warningMessage'))
            <div class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Warning!</strong> {{ isset($warningMessage) ? $warningMessage : Session::get('warningMessage') }}
            </div>
            @endif

            @if (isset($errorMessage) || Session::has('errorMessage'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Danger!</strong> {{ isset($errorMessage) ? $errorMessage : Session::get('errorMessage') }}
            </div>
            @endif
        </div>

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.2.3 -->
        <script src="{{ url('/theme') }}/{{$adminTheme}}/js/jquery.min.js"></script>
        <script src="{{ url('/theme') }}/{{$adminTheme}}/js/bootstrap.min.js"></script>
        <script src="{{ url('/theme') }}/{{$adminTheme}}/js/app.min.js"></script>
        <script src="{{ url('/theme') }}/{{$adminTheme}}/js/main.js"></script>
        @if(isset($jsFiles))
        @foreach($jsFiles as $src)
        <script src="{{$src}}{{$jsTimeStamp}}"></script>
        @endforeach
        @endif
    </body>
</html>
