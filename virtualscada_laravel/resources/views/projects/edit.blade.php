@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
      		<div class="panel-body">
        		{!! Form::model($project, ['action'=>['ProjectController@update', $project->id], 
        						'method'=>'PATCH']) !!}

        		<div class="form-group">
        			{!! Form::label('name', 'Project Name:') !!}
					{!! Form::text('name', null, ['class'=>'input-group']) !!}
        			
				</div>

				<div class="form-group">
					{!! Form::submit('Update Project', ['class'=>'btn btn-primary btn-md']) !!}
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

	<footer class="footer" style="background-color:#0b1b3d;">
		<div class="container">
			<p class="text-muted">Place sticky footer content here.</p>
		</div>
	</footer>

@endsection
