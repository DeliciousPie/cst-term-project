@extends('layouts.app')

@section('title')
<title>Curricular Developer Activity Manager</title>
@stop

@section('navBarHeader')
<a class="navbar-brand" href="{{ url('/') }}">Curricular Developer Activity Manager </a>
@stop


@section('bodyHeader')
<br>
@stop


@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Curricular Developer Activity Manager</div>

                <div class="row">
                    <form method="post" action=''>
                        <input type="hidden" name='_token' value="{!! csrf_token() !!}">
                        @foreach ($errors->all() as $error)
                        <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div class="col-md-1">
                        </div>

                        <div class="col-md-3">
                            <h2>Professors</h2>

                            <select multiple class="form-control">
                            </select>
                        </div>

                        <div class="col-md-1">
                        </div>

                        <div class="col-md-6">
                            <h2>Assigned Courses</h2>

                            <select multiple class="form-control">
                            </select>
                        </div>

                        <div class="col-md-1">
                        </div>

                    </form>





                    <div class="panel-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection