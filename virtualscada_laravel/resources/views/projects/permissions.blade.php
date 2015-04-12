@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
    @include('flash::message')
	<div>
    	<div class="panel">
      		<div class="panel-body">
                Project Name:
                <div>{{$project->name}}</div>
                Users who can view project:
                @foreach($permissionUserData as $user)
                    <div> {{ $user->name }} </div>
                @endforeach
                <p> Share this project with a user</p>
                {!! Form::open(['action'=>['ProjectPermissionController@store', $project->id], 'method'=>'POST', 'class' => 'form-inline']) !!}
                <div class="form-group">
                    {!! Form::label('email', 'New Users Email:') !!}
                    {!! Form::text('email', '', []) !!}
                </div>
                <div class="form-group">
                    {!!Form::submit('Share Project', ['class' => 'btn btn-default']) !!}
                </div>
                {!! Form::close() !!}
                @include ('errors.list')
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
