@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
    		<div class="panel-heading">Add a Project</div>
      		<div class="panel-body">
        		{!! Form::open(['url'=>'/projects', 'method'=>'POST']) !!}

        		<div class="form-group">
        			{!! Form::label('name', 'Name:') !!}
					{!! Form::text('name', '', ['class'=>'input-group']) !!}
        			
				</div>

				<div class="form-group">
					{!! Form::submit('Add Project', ['class'=>'btn btn-primary btn-md']) !!}
				</div>        		

        		{!! Form::close() !!}

        		@if($errors->any())
        			<ul class="alert alert-danger">
        			@foreach($errors->all() as $error)
        				<li>{{ $error }}</li>
    				@endforeach	
        			</ul>
        		@endif
			</div>
		</div>
	</div>
</div>

@stop