@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
    @include('flash::message')
	<div>
    	<div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{$project->name}}</h3>
            <div class="panel-body">
                Users who can view project:
                @foreach($projectUsers as $user)
                    <div> {{ $user->name }} </div>
                    {!! Form::open(['url'=>'/projects/'.$project->id.'/permissions/'.$user->id, 'method'=>'PUT', 'class' => 'form-inline']) !!}
                    <div class="form-group">
                        {!! Form::label('open', 'Open:') !!}
                        {!! Form::hidden('open', 0) !!}
                        {!! Form::checkbox('open', true, $user->open, ['checked' => false]) !!}

                        {!! Form::label('edit', 'Edit:') !!}
                        {!! Form::hidden('edit', 0) !!}
                        {!! Form::checkbox('edit', true, $user->edit, ['type' => 'checkbox']) !!}

                        {!! Form::label('share', 'Share:') !!}
                        {!! Form::hidden('share', 0) !!}
                        {!! Form::checkbox('share', true, $user->share, ['type' => 'checkbox']) !!}
                    </div>
                    {!!Form::submit('Save Changes', ['class' => 'btn btn-default']) !!}
                    {!! Form::close() !!}
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
