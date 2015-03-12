@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
      		<div class="panel-body">
        		{!! Form::model($project, ['action'=>['ProjectController@update', $project->id], 
        						'method'=>'PATCH']) !!}
  					@include ('projects.form', ['submitButtonText' => 'Update Project']) 			
        		{!! Form::close() !!}

        		@include ('errors.list')
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
