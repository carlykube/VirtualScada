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
                                <i class="fa fa-arrow-left pull-right"></i>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="module col-md-4 col-md-offset-1">
                                </div>
                                <div class="module col-md-4 col-md-offset-right-1 pull-right">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title" data-toggle="collapse" data-target="#collapseTwo" data-parent="#left-accordion">
                                RTU Modules
                                <i class="fa fa-arrow-left pull-right"></i>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="module col-md-4 col-md-offset-1">
                                </div>
                                <div class="module col-md-4 col-md-offset-right-1 pull-right">
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title" data-toggle="collapse" data-target="#collapseThree" data-parent="#left-accordion">
                                PLC Modules
                                <i class="fa fa-arrow-left pull-right"></i>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="module col-md-4 col-md-offset-1">
                                </div>
                                <div class="module col-md-4 col-md-offset-right-1 pull-right">
                                </div>
                            </div>
                        </div>
                    </div> 

                </div>
            </div>
            <div id="messagebox" class="col-md-4 col-md-offset-1">
                You have added an RTU module to the project.
            </div>
            <div class="col-md-3 pull-right right-side">
                <ul class="nav nav-tabs">
                    <li id="screenOneLink" class="active"><a href="#">Properties</a></li>
                    <li id="screenTwoLink"><a href="#">Links</a></li>
                    <li id="screenThreeLink"><a href="#">Output</a></li>
                </ul>
                <div id="right-content">
                    <div class="screen screenOne row">
                        <div class="label-group col-xs-12">
                            <span class="label col-xs-3">Name:</span>
                            <input type="text" class="col-xs-8 col-xs-offset-1">
                        </div>

                        <div class="label-group col-xs-12">
                            <span class="label col-xs-3">Vendor:</span>
                            <input type="text" class="col-xs-8 col-xs-offset-1" disabled>
                        </div>

                        <div class="label-group col-xs-12">
                            <span class="label col-xs-4">Date Added:</span>
                            <input type="text" class="col-xs-8" disabled>
                        </div>

                        <div class="label-group col-xs-12">
                            <span class="label col-xs-5">Last Test Result:</span>
                            <input type="text" class="col-xs-7" disabled>
                        </div>

                        <div class="label-group col-xs-12">
                            <span class="label col-xs-3">Linked To:</span>
                            <input type="text" class="col-xs-2 col-xs-offset-1" disabled>
                        </div>
                    </div>
                    <div style="display: none;" class="screen screenTwo row">
                        <div class="label-group col-xs-12">
                            <span class="label col-xs-3">Linked To:</span>
                            <input type="text" class="col-xs-8 col-xs-offset-1" disabled>
                        </div>
                        <div class="label-group col-xs-12">
                            <span class="label col-xs-3">Linked To:</span>
                            <input type="text" class="col-xs-8 col-xs-offset-1" disabled>
                        </div>
                        <div class="label-group col-xs-12">
                            <span class="label col-xs-3">Linked To:</span>
                            <input type="text" class="col-xs-8 col-xs-offset-1" disabled>
                        </div>
                    </div>
                    <div style="display: none;" class="screen screenThree row">
                        <div class="label-group col-xs-12">
                            <textarea rows="25" class="col-xs-10 col-xs-offset-1" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="draggable ui-widget-content">
                <p id="draggable5" class="ui-widget-header">This is in the header.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footerscr')

<script src="{{ asset('/js/projectdash.js') }}"></script>

@endsection