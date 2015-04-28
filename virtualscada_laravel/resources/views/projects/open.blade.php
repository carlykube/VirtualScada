@extends('app')

@section('header')

<link href="{{ asset('/css/projectdash.css') }}" rel="stylesheet">

@endsection

@section('content')

<div id="container-fluid" class="container">
    <!-- @include('flash::message') -->
    <!-- Taking this out to replace with main project dashboard
	<div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Add a module</h3>
            </div>
            {{-- can the buttons be side-by-side? --}}
            <div class="panel-body">
                {{-- Add RTU --}}
                {!! Form::open(['url'=>'/modules', 'method'=>'POST']) !!}
                {!! Form::input('hidden', 'module', 'rtu') !!}
                {!! Form::input('hidden', 'projectId', $project->id) !!}
                <div class="form-group">
                    {!! Form::submit('Add RTU', ['class'=>'btn btn-primary btn-md']) !!}
                </div>
                {!! Form::close() !!}

                {{-- Add HMI --}}
                {!! Form::open(['url'=>'/modules', 'method'=>'POST']) !!}
                {!! Form::input('hidden', 'module', 'hmi') !!}
                {!! Form::input('hidden', 'projectId', $project->id) !!}
                <div class="form-group">
                    {!! Form::submit('Add HMI', ['class'=>'btn btn-primary btn-md']) !!}
                </div>
                {!! Form::close() !!}
                <p> Output from script: {{ $output }} </p>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Current Modules</div>
                <div class="panel-body">
                    @foreach($modules as $module)
                        <span class="module">
                            <h4>{{ $module->name }}</h4>
                            <p>{{ $module->file_loc }}</p>
                            {!! Form::open(['url' => '/modules/' . $module->id, 'method'=>'DELETE']) !!}
                            <div class="form-group">
                                {!! Form::submit('DELETE', ['class'=>'btn btn-primary btn-md']) !!}
                            </div>
                            {!! Form::close() !!}
{{--                            <a href="{{ action('ModuleController@destroy', array('id' => $module->id)) }}"> DELETE </a>--}}
                        </span>
                    @endforeach
                </div>
        </div>
	</div>
    End takeout-->
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 projectpanel">
            <div class="row">
            <div class="col-md-3 left-side">

                <div class-"panel-group" id="left-accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title" data-toggle="collapse" data-target="#collapseOne" data-parent="#left-accordion">
                                HMI Modules
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <p>This is where we put our HMIs</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title" data-toggle="collapse" data-target="#collapseTwo" data-parent="#left-accordion">
                                RTU Modules
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>This is where we put our RTUs</p>
                            </div>
                        </div>
                    </div> 

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title" data-toggle="collapse" data-target="#collapseThree" data-parent="#left-accordion">
                                PLC Modules
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>This is where we put our PLCs</p>
                            </div>
                        </div>
                    </div> 

                </div>
            </div>
            <div style="height: 100%" class="col-md-6 centerproj">
            </div>
            <div class="col-md-3 right-side">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Properties</a></li>
                    <li><a href="#">Links</a></li>
                    <li><a href="#">Output</a></li>
                </ul>
                <div id="right-content">
                    content things go in here
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection