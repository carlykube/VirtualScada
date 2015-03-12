@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Projects</div>

				<div class="panel-body">
				@foreach($projects as $project)
					<ul>						
						<li>{{ $project->name }}</li>
					</ul>
				@endforeach
				</div>

				<div class="panel-footer">
					<a href="/projects/{{ $project->id }}/edit">Edit</a> | <a href="/home">Back</a>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection