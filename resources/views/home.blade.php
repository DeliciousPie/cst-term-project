@extends('layouts.app')

@section('title')
<title>Home Page</title>
@stop

@section('navBarHeader')
<a class="navbar-brand" href="{{ url('/home') }}">Curricular Densitometer  </a>
@stop

@section('bodyHeader')
<div>

    <h1 class="page-header">Welcome To Curricular Developer </h1>

</div>

@endsection

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">


                @if( Auth::user() !== null)
                <div class="panel-heading">
                    <h1>Welcome Back {{ Auth::user()->name }}! </h1>
                </div>


                <div class="row" style="padding: 2em; ">
                    @if (Auth::user()->hasrole('CD'))

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row" style="height: 75px;">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div><h3>Course Assignment</h3></div>
                                    </div>
                                </div>
                            </div>
                            <a  href="{{ url('CD/CourseAssignmentMain') }}">
                                <div class="panel-footer"style="height: 200px;">
                                    <span class="pull-left"><p style="color: black;">
                                            You can use this to add courses, professors, and students
                                            into the Database to 
                                            create new Course sections, and assign students 
                                            and professors to those course sections. 
                                            Click Here. </p></span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row" style="height: 75px;">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div><h3>Dash Board</h3></div>
                                    </div>
                                </div>
                            </div>
                            <a  href="{{ url('CD/dashboard') }}">
                                <div class="panel-footer" style="height: 200px;">
                                    <span class="pull-left"><p style="color: black;">
                                            View and analyze the data 
                                            that has been entered in from the students</p></span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row" style="height: 75px;">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div><h3>Add Task, Assignment</h3></div>
                                    </div>
                                </div>
                            </div>
                            <a  href="{{ url('CD/manageActivity') }}">
                                <div class="panel-footer" style="height: 200px;">
                                    <span class="pull-left"><p style="color: black;">
                                            You can add new tasks and assignments 
                                            to each Course section so that the 
                                            students can fill out there survey. </p></span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>


                    @elseif ( Auth::user()->hasrole('Prof'))


                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row" style="height: 75px;">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div><h3>Dash Board</h3></div>
                                    </div>
                                </div>
                            </div>
                            <a  href="{{ url('Prof/dashboard') }}">
                                <div class="panel-footer" style="height: 200px;">
                                    <span class="pull-left"><p style="color: black;">
                                            View and analyze the data 
                                            that you and your students have entered. </p></span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div> 

                    @elseif( Auth::user()->hasrole('Student'))

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row" style="height: 75px;">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div><h3>Dash Board</h3></div>
                                    </div>
                                </div>
                            </div>
                            <a  href="{{ url('Student/dashboard') }}">
                                <div class="panel-footer" style="height: 200px;">
                                    <span class="pull-left"><p style="color: black;">
                                            View and analyze the data 
                                            that you have entered. </p></span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row" style="height: 75px;">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div><h3>Activities</h3></div>
                                    </div>
                                </div>
                            </div>
                            <a  href="{{ url('Student/activities') }}">
                                <div class="panel-footer" style="height: 200px;">
                                    <span class="pull-left"><p style="color: black;">
                                            View and Enter in you 
                                            your estimates for the course section you 
                                            have been assigned to.</p></span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @elseif( Auth::user() === null)
                    <div class="panel-heading">
                        <h1>What does this web site do?</h1>
                    </div>

                    <div class="panel-body">
                        <p> This web site is designed to help track the time, effort level,
                            and stress of student during assignments, labs, or studying. 
                            With the information that is gather Curriculum Developers
                            can analyze the data and adjust class content so that they can better design 
                            the programs offered to the students. 
                        </p> 


                    </div>
                    @endif

                    <image src=' http://phpserver/images/group-of-university-students.jpg' 
                           height="30%" width="90%">
                </div>


            </div>
        </div>
    </div>
    @endsection
