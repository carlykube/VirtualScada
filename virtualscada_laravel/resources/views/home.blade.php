@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
	<div class="panel">
			<div class="panel-heading">Current Projects</div>

			<div class="panel-body">
				@if ( empty($projects) )
					<p>You do not have any projects.</p>
				@else
					<ul>
					@foreach ( $projects as $prj )
						<li><a href="/project/{{ $prj->id }}"> {{ $prj->name }} </a>
						</li>
					@endforeach
					</ul>
				@endif
			</div>

			<div class="panel-footer">
				<a href="/project/create">Add A Project</a>
				| Delete Project(s)</a>
			</div>				
		</div>
	</div>
</div>
@endsection
