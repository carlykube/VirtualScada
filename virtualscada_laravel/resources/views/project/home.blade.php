@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $project->name }}</div>

				<div class="panel-body">
					<ul>
						<li>Owned by: {{ $project->owner_id }}</li>
						<li>Created at: {{ $project->created_at }}</li>
						<li>Updated at: {{ $project->updated_at }}</li>
				</ul>
				</div>

				<div class="panel-footer">
					<a href="/project/{{ $project->id }}/edit">Edit</a> | <a href="/home">Back</a>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection