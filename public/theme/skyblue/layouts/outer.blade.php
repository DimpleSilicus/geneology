<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <meta name="description" content="">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
   		 <meta name="robots" content="all,follow">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        {!! Seo::render() !!}
        <!-- core CSS -->
        <!-- Latest compiled and minified CSS -->
        <link href="{{ url('/theme') }}/{{$theme}}/css/bootstrap.min.css" rel="stylesheet">
         <link href="{{ url('/theme') }}/{{$theme}}/css/style.default.css" rel="stylesheet">
        <link href="{{ url('/theme') }}/{{$theme}}/css/font-awesome.min.css" rel="stylesheet">
        <link href="{{ url('/theme') }}/{{$theme}}/css/pe-icon-7-stroke.css" rel="stylesheet">
        <!-- Google fonts - Roboto-->
   		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,700">
   		<link href="{{ url('/theme') }}/{{$theme}}/css/lightbox.min.css" rel="stylesheet">
   		<link href="{{ url('/theme') }}/{{$theme}}/css/custom.css" rel="stylesheet">
   		
   		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
   		<link rel="shortcut icon" href="fevicon.png">
   		<link href="{{ url('/theme') }}/{{$theme}}/css/form-style.css" rel="stylesheet">
		
		

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!--  <link rel="stylesheet" href="{{ url('/theme') }}/{{$adminTheme}}/css/AdminLTE.min.css"> -->
       
        @if(isset($cssFiles))
        @foreach($cssFiles as $src)
        <link href="{{$src}}{{$cssTimeStamp}}" rel="stylesheet" type="text/css" />
        @endforeach
        @endif
        <script>
            var themePath = "{{$url}}theme/{{$theme}}/";
            var siteUrl = "{{$url}}";
        </script>

    </head><!--/head-->

    <body>
       <!-- navbar-->
    <header class="header">
        <div role="navigation" class="navbar navbar-default">
            <div class="container">
               
                <div class="navbar-header">
                    <a href="{{ url('/') }}" class="navbar-brand"><img src="{{ url('/theme') }}/{{$theme}}/images/GNH-logo.png" alt="GNH Logo" /></a>
                    <div class="navbar-buttons">
                        <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle navbar-btn"><i class="fa fa-align-justify"></i></button>
                    </div>
                </div>
                @if (Auth::guest())
               
                @else
                <div class="profile-info">
                    <!--<img src="{{ url('/theme') }}/{{$theme}}/images/profile-pik.jpg" alt="profile image" class="profile-img" />-->
                    <p>Welcome, {{ Auth::user()->username}} | <a style=" color: #95b43c;" href="{{ url('/admin/logout') }}">Logout</a></p>
                </div>
                @endif
			    
			    <div id="navigation" class="collapse navbar-collapse navbar-right">
                    <div class="clearfix"></div>
					<ul class="nav navbar-nav">
					@if (Auth::guest())
					
					<!-- Nothing to Show -->
					
					@else
                        <li><a href="{{ url('admin/dashboard') }}" class="active">Home</a></li>
                        <li><a href="{{ url('admin/manage-user/list') }}">Manage Users</a></li>
                        <li><a href="{{ url('admin/manage-tutorial/list') }}">Manage Tutorials</a></li>
						<li><a href="{{ url('admin/change-password') }}">Change Password</a></li>
                  
                    @endif

					</ul>
					</div>
                </div>
				
			
			
			
			
        </div>
    </header>

        @yield('content')
    	<footer class="footer margin-T-100">
            <div class="footer__copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Copyrights &copy; 2017. Genealogy Network Hub. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
          

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="{{ url('/theme') }}/{{$theme}}/js/bootstrap.min.js"></script>
        <script src="{{ url('/theme') }}/{{$theme}}/js/jquery.cookie.js"> </script>
    	<script src="{{ url('/theme') }}/{{$theme}}/js/lightbox.min.js"></script>
        <script src="{{ url('/theme') }}/{{$theme}}/js/front.js"></script>
        
        <!-- for file uploader -->
        <script src="{{ url('/theme') }}/{{$theme}}/js/File-Upload/fileinput.js" type="text/javascript"></script>
        <!--form---->
        <script src="{{ url('/theme') }}/{{$theme}}/js/form-controls.js"></script>
        <script src="{{ url('/theme') }}/{{$theme}}/js/tab-accordion/ResponsiveTabToAccordion.js"></script>
        <!--date picker-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.0/js/bootstrap-datepicker.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>
        <script type="text/javascript">
            $('#AddPeople').modal({
                backdrop: 'static',
                keyboard: false
            });
    
            $(document).ready(function () {
                $('#GenDOB').datepicker({
                    autoclose: true
                });
               
            });
           
        </script>
    	<script src="{{ url('/theme') }}/{{$theme}}/js/app.js"></script>
        @if(isset($jsFiles))
        @foreach($jsFiles as $src)
        <script src="{{$src}}{{$jsTimeStamp}}"></script>
        @endforeach
        @endif

    </body>
</html>