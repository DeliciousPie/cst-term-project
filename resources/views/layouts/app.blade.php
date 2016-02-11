
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        <!-- Custom Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- jQuery -->
        <script src="/js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/js/bootstrap.min.js"></script>

        <!-- JavaScripts -->
        {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

        <!-- Morris Charts JavaScript -->
        <script src="/js/plugins/morris/raphael.min.js"></script>
        <script src="/js/plugins/morris/morris.min.js"></script>
        <script src="/js/plugins/morris/morris-data.js"></script>
        
        @yield('title')
        <!-- Bootstrap Core CSS -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->

        <link href="/css/bootstrap.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="/css/sb-admin.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="/css/plugins/morris.css" rel="stylesheet">


    </head>


    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    @yield('navBarHeader')
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <!-- user Information drop down  -->
                    <ul class="nav navbar-right top-nav">
                        <!-- Authentication Links -->

                        @if (!Auth::check())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>

                        @endif
                    </ul>
                </div>


                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav side-nav">
                        <li><a href="{{ url('/home') }}">Home</a></li>


                        <li><a href="{{ url('/about') }}">About</a></li>


                        @if( Auth::user() !== null)

                        @if (Auth::user()->hasrole('CD'))

                        <li><a href="{{ url('CD/dashboard') }}">CD Dashboard</a></li>


                        <li><a href="{{ url('CD/CourseAssignmentMain') }}">Course Assignment</a></li>

                        @elseif ( Auth::user()->hasrole('Prof'))

                        <li><a href="{{ url('Prof/dashboard') }}">Professor Dashboard</a></li>

                        @elseif( Auth::user()->hasrole('Student'))

                        <li><a href="{{ url('Student/dashboard') }}">Student Dashboard</a></li>
                        <li><a href="{{ url('Student/activities') }}">Student Activities</a></li>
                        @endif
                        @endif
                    </ul>
                </div>
            </nav>

            <div id="page-wrapper" style="min-height: 50em">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row" >
                        <div class="col-sm-4">
                            <!-- this will call the body header for each page -->
                            @yield('bodyHeader')

                        </div>


                    </div>
                    <!-- /.row -->

                    <!-- this will render each pages body information-->
                    @yield('content')

                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->

            </div>
        </div>
        <!-- /#page-wrapper -->



        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center">
                        <h4><strong>CDP Development</strong>
                        </h4>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-phone fa-fw"></i>Footer Stuff</li>
                            <li><i class="fa fa-envelope-o fa-fw"></i> 

                                <a href="mailto:claypool5731@saskpolytech.com">email</a>
                            </li>
                        </ul>
                        <hr class="small">
                        <p class="text-muted">Copyright &copy; CDP - 2015</p>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</body>
<!-- /#wrapper -->

</html>
