@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
    		<div class="panel-heading">Add a Project</div>
      		<div class="panel-body">
        		{!! Form::open(['url'=>'/projects', 'method'=>'POST']) !!}
                    @include ('projects.form', ['submitButtonText' => 'Add Project'])      		
        		{!! Form::close() !!}
        		
                @include ('errors.list')
			</div>
		</div>
	</div>
</div>

@stop