@extends('layouts.app')

@section('title')
<title>About Us</title>
@stop

@section('navBarHeader')
<a class="navbar-brand" href="{{ url('/home') }}">Curricular Densitometer   </a>
@stop

@section('bodyHeader')
<div>

    <h1 class="page-header"> About Us </h1>

</div>

@endsection

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>About Curricular Densitometer Project</h4></div>

                <div class="panel-body">
                    <div>
                        <p>The Curricular Densitometer web site is a tool to 
                            measure the distribution of curriculum based on 
                            student workload and preparation for courses.  </p>
                        <p>
                            Students will be able to enter the time they spend 
                            preparing for particular classes.
                        </p>
                        <p>The tool will give 
                            a visual depiction of the preparation time needed by students.
                            It will also help the developers find periods in time that the
                            students are the most stressed, and have higher loads, 
                            or basically the peak times.
                        </p>
                        <p>The outcome will help 
                            curriculum developers to adjust the curriculum to make 
                            the learning environment more conducive to student 
                            learning and engagement. </p>
                    </div>

                    <image src=' http://phpserver/images/Lecture01.jpg' 
                           height="30%" width="90%">
                </div>
            </div>



        </div>
    </div>
    @endsection
