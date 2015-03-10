@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Current Projects</div>

				<div class="panel-body">
					@if (empty($projects))
						<p>You do not have any projects.</p>
					@else
						<ul>
						@foreach ($projects as $prj)
							<li><a href="/project/{{ $prj->id }}"> {{ $prj->name }} </a>
							</li>
						@endforeach
						</ul>
					@endif
				</div>

				<div class="panel-footer">
					<a href="/project/add">Add A Project</a>
					| Delete Project(s)</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
