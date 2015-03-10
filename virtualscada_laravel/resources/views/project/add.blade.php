@extends('app')

@section('content')

<div id="login-container" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
      		<div class="panel-body">

        		<form class="addprojectform" role="form" method="POST" action="{{ url('') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
						<label class="sr-only">Project Name</label>
						<div class="input-group">
							<input type="text" class="form-control" name="prjname" placeholder="Project Name">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<button type="submit" class="btn btn-primary btn-md">Add Project</button>
						</div>
					</div>
				</form>

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
