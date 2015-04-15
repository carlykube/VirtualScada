@extends('app')

@section('content')

<div id="container-fluid" class="container" style="margin-top:10%">
    @include('flash::message')
	<div>
    	<div class="panel">
                <h2 style="text-align:center;">{{ $project->name }} Permissions</h2>
                <div class="panel-body">

                    <div style="width:50%;float:left;text-align:center;">
                        <h3>Add to Current Permissions</h3>

                        {!! Form::open(['action'=>['ProjectPermissionController@store', $project->id], 'method'=>'POST', 'class' => 'form-inline']) !!}
                        <div class="form-group" style="width:100%; clear:both; margin-top:13px;">
                            <!-- {!! Form::label('email', 'New Users Email:') !!} -->
                            {!! Form::text('email', '', ['placeholder' => 'EMAIL ADDRESS OF USER', 'class' => 'wide-input']) !!}
                        </div>
                        <div class="form-group" style="margin-top: 15px; clear:both;">
                            {!!Form::submit('Share Project', ['class' => 'btn add-permission-button']) !!}
                        </div>
                        {!! Form::close() !!}
                        @include ('errors.list')
                    </div>

                    <div style="width:50%;float:right;text-align:center;border-left:1px solid #dddddd;">
                        <h3>Edit Current Permissions</h3>
                        <div class="table-responsive" style="text-align:center;">
                            <table class="table table-striped" >
                                <thead>
                                    <tr >
                                        <th style="text-align:center;">User</th>
                                        <th style="text-align:center;">Open</th>
                                        <th style="text-align:center;">Edit</th>
                                        <th style="text-align:center;">Share</th>
                                        <th style="text-align:center;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projectUsers as $user)
                                        <tr>
                                            <td> {{ $user->name }} </td>
                                            {!! Form::open(['url'=>'/projects/'.$project->id.'/permissions/'.$user->id, 'method'=>'PUT', 'class' => 'form-inline']) !!}
                                            <div class="form-group">
                                                <td>
                                                <!-- {!! Form::label('open', 'Open:') !!} -->
                                                {!! Form::hidden('open', 0) !!}
                                                {!! Form::checkbox('open', true, $user->open, ['type' => 'checkbox']) !!}
                                                </td>
                                                <td>
                                                <!-- {!! Form::label('edit', 'Edit:') !!} -->
                                                {!! Form::hidden('edit', 0) !!}
                                                {!! Form::checkbox('edit', true, $user->edit, ['type' => 'checkbox']) !!}
                                                </td>
                                                <td>
                                                <!-- {!! Form::label('share', 'Share:') !!} -->
                                                {!! Form::hidden('share', 0) !!}
                                                {!! Form::checkbox('share', true, $user->share, ['type' => 'checkbox']) !!}
                                                </td>
                                                <td>
                                                    {!!Form::submit('Save', ['class' => 'btn save-button']) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            </div>
                                            
                                        </tr>




                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>






























			</div>
            <div class="panel-footer" style="text-align:center;">
                <a href="/projects/{{ $project->id }}">Back to Project</a>
            </div>
		</div>
	</div>
</div>

@endsection
