@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Current Projects</div>

				<div class="panel-body">
					Click a project below to edit it.

					@if (empty($projects))
						<p>You do not have any projects.</p>
					@else
						<ul>
						@foreach ($projects as $prj)
							<li>{{ $prj->name }}
								(ID = {{ $prj->id }} | Owner_ID = {{ $prj->owner_id }})
							</li>
						@endforeach
						</ul>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
