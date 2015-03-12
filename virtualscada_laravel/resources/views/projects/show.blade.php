@extends('app')

@section('content')
<div id="container-fluid" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
    		<div class="panel-heading">{{ $project->name }}</div>
      		<div class="panel-body">
				<ul>
					<li>Owned by: {{ $project->user_id }}</li>
					<li>Created at: {{ $project->created_at }}</li>
					<li>Updated at: {{ $project->updated_at }}</li>
				</ul>
			</div>

			<div class="panel-footer">
				<a href="/projects/{{ $project->id }}/edit">Edit</a> | 
				Delete | <a href="/home">Back</a>
			</div>
		</div>
	</div>
</div>

@endsection