@extends('app')

@section('content')
<div id="login-container" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
      		<div class="panel-body">
			<h2>{{ $project->name }}</h2>
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

@endsection