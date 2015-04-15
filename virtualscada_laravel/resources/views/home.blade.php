@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
    @include('flash::message')

	<div class="panel" style="text-align:center;">
			<h2>Project Dashboard</h2>
			<div class="panel-body">



				<div style="width:50%;float:left;text-align:center;">
					<h3>Create Project</h3>
					<p style="margin-top:13px;">
                    {!! Form::open(['url'=>'/projects', 'method'=>'POST']) !!}
                    @include ('projects.form', ['submitButtonText' => 'CREATE'])      		
        			{!! Form::close() !!}
                	@include ('errors.list')</p>
				</div>


				<div style="width:50%;float:right;text-align:center;border-left:1px solid #dddddd;">
					<h3>Current Projects</h3>
					@if ( empty($projects) )
						<p>You do not have any projects.</p>
					@else

					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr >
									<th style="text-align:center;">Project Name</th>
									<th style="text-align:center;">Date Created</th>
								</tr>
							</thead>
							<tbody>
								@foreach ( $projects as $prj )
								<tr>
									<td width="50%">
										<a href="/projects/{{ $prj->id }}"> {{ $prj->name }} </a>
									</td>
									<td width="50%">
										{{ date("M d, Y", strtotime($prj->created_at )) }}
									</td>
								</tr>
								@endforeach	
							</tbody>
						</table>
					</div>



					@endif
				</div>



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

<!-- 			<div class="panel-footer">
				<a href="/projects/create">Create Project</a>
			</div>	 -->			
		</div>
	</div>
</div>
@endsection
