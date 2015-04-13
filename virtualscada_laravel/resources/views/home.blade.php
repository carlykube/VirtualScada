@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
    @include('flash::message')

	<div class="panel">
			<div class="panel-heading">Current Projects</div>

			<div class="panel-body">
				@if ( empty($projects) )
					<p>You do not have any projects.</p>
				@else
					<ul>
					@foreach ( $projects as $prj )
						<li><a href="/projects/{{ $prj->id }}"> {{ $prj->name }} </a>
						</li>
					@endforeach
					</ul>
				@endif
			</div>

            @if(Auth::user()->admin)
                <div class="panel-body">
                    {!! Form::open(['url'=>'/scheduleDownTime', 'method'=>'POST', 'class' => 'form-inline']) !!}
                    {!! Form::label('startdate', 'Chose date to start downtime:') !!}
                    {!! Form::input('datetime-local', 'startdate') !!}
                    {!! Form::label('enddate', 'Chose date to end downtime:') !!}
                    {!! Form::input('datetime-local', 'enddate') !!}
                    {!!Form::submit('Save Changes', ['class' => 'btn btn-default']) !!}
                    {!! Form::close() !!}
                </div>
            @endif

			<div class="panel-footer">
				<a href="/projects/create">Add A Project</a>
			</div>				
		</div>
	</div>
</div>
@endsection
