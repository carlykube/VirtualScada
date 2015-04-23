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
                    <p>Scheuled Downtimes</p>
                    <ul>
                    @foreach($downtimes as $downtime)
                        <li>{{ date("M d, Y g:i A",strtotime($downtime->start_time)) }}</li>
                    @endforeach
                    </ul>
                    {!! Form::open(['url'=>'/scheduleDownTime', 'method'=>'POST', 'class' => 'form-inline']) !!}
                    {!! Form::label('start_time', 'Chose date to start downtime:') !!}
                    {!! Form::input('datetime-local', 'start_time') !!}
                    {!! Form::label('end_time', 'Chose date to end downtime:') !!}
                    {!! Form::input('datetime-local', 'end_time') !!}
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
