@extends('app')

@section('content')
<div id="container-fluid" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
    		<div class="panel-heading">{{ $project->name }}</div>
      		<div class="panel-body">
				<ul>
					<li>Owned by: {{ $owner->name }}</li>
					<li>Created on: {{ date("M d, Y",strtotime($project->created_at )) }}</li>
                    <li>HMIs: {{ $project->number_hmi}}</li>
                    <li>RTUs: {{ $project->number_rtu}}</li>
                    <li>PLCs: {{ $project->number_plc}}</li>
                    <li>Sensors: {{ $project->number_sensor}}</li>
					{{--<li>Updated at: {{ $project->updated_at }}</li>--}}
				</ul>
			</div>

			<div class="panel-footer">
				<a href="/projects/{{ $project->id }}/edit">Edit</a> |
                <a href="/home">Back</a> |
                <a href="open/{{ $project->id }}">Open</a> |
                <a href="/projects/{{ $project->id }}/permissions">Permissions</a>
                {!! Form::open(['method'=>'DELETE']) !!}
                <div class="form-group">
                    {!! Form::submit('DELETE', ['class'=>'btn btn-primary btn-md']) !!}
                </div>
                {!! Form::close() !!}
			</div>

		</div>
	</div>
</div>
<script src="/js/jquery/jquery.js"></script>

@endsection