@extends('app')

@section('content')
<div id="container-fluid" class="container" style="margin-top:10%">
    @include('flash::message')
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
</div>

@endsection