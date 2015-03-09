@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Current Projects</div>

				<div class="panel-body">
					Click a project below to edit it.

					<ul>
					@foreach ($projects as $prj)
						<li>{{ $prj->name }}</li>
					@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
