@extends('app')

@section('content')

<div id="login-container" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
      		<div class="panel-body">
        		{!! Form::model($project, ['url'=>'/project/' . $project->id, 'method'=>'PATCH']) !!}

        		<div class="form-group">
					Name: {!! Form::text('name', null, ['class'=>'input-group']) !!}
				</div>

				<div class="form-group">
					Owner: {!! Form::text('owner_id', null, ['class'=>'input-group']) !!}
				</div>

				<div class="form-group">
						{!! Form::submit('Update Project', ['class'=>'btn btn-primary btn-md']) !!}
				</div>        		

        		{!! Form::close() !!}

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
