@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
      		<div class="panel-body">
        		{!! Form::open(['url'=>'/project/add', 'method'=>'POST']) !!}

        		<div class="form-group">
					{!! Form::text('name', '', ['class'=>'input-group']) !!}
				</div>

				<div class="form-group">
						{!! Form::submit('Add Project', ['class'=>'btn btn-primary btn-md']) !!}
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
