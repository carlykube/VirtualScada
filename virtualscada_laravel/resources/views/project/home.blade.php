@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $project->name }}</div>

				<div class="panel-body">
					Created at: {{ $project->created_at }}
				</div>

				<div class="panel-body">
					<a href="/home">Back</a>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection