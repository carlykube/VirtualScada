@extends('app')

@section('content')
<div id="container-fluid" class="container" style="margin-top:10%">
	<div>
    	<div class="panel">
    		<h2 style="text-align:center;">The {{ $project->name }} Project</h2>
      		<div class="panel-body">
                <div style="position:relative; width:75%; margin-left:auto; margin-right:auto;">
<!--                     <ul>
                        <li>Owned by: {{ $owner->name }}</li>
                        <li>Created on: {{ date("M d, Y",strtotime($project->created_at )) }}</li>
                        <li>HMIs: {{ $project->number_hmi}}</li>
                        <li>RTUs: {{ $project->number_rtu}}</li>
                        <li>PLCs: {{ $project->number_plc}}</li>
                        <li>Sensors: {{ $project->number_sensor}}</li>
                        {{--<li>Updated at: {{ $project->updated_at }}</li>--}}
                    </ul> -->

                    <div class="table-responsive">
                        <table class="table table-striped" >
                            <tbody style="text-align:center;">
                                <tr>
                                    <th>Owner</th>
                                    <td>{{ $owner->name }}</td>
                                </tr>
                                <tr>
                                    <th>Date Created</th>
                                    <td>{{ date("M d, Y",strtotime($project->created_at )) }}</td>
                                </tr>
                                <tr>
                                    <th>HMIs</th>
                                    <td>{{ $project->number_hmi}}</td>
                                </tr>
                                
                                <tr>
                                    <th>RTUs</th>
                                    <td>{{ $project->number_rtu}}</td>
                                </tr>
                                
                                <tr>
                                    <th>PLCs</th>
                                    <td>{{ $project->number_plc}}</td>
                                </tr>
                                
                                <tr>
                                    <th>Sensors</th>
                                    <td>{{ $project->number_sensor}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-group" role="group" aria-label="..." style="position: relative; width:100%; margin-left:auto; margin-right:auto;">
                        <a href="/projects/{{ $project->id }}/edit" class="btn project-button-bar" role="button" style="width:33.33%;"><p>Edit</p></a>
                        <a href="open/{{ $project->id }}" class="btn project-button-bar" role="button" style="width:33.33%;"><p>Open</p></a>
                        <a href="/projects/{{ $project->id }}/permissions" class="btn project-button-bar" role="button" style="width:33.33%;"><p>Permissions</p></a>
                    </div>

                    <div>
                        {!! Form::open(['method'=>'DELETE']) !!}
                            <div class="form-group" style="width=100%; text-align:center;">
                                {!! Form::submit('DELETE', ['class'=>'btn project-delete-button']) !!}
                            </div>
                        {!! Form::close() !!}  
                    </div>

                </div>


			</div>








			<div class="panel-footer" style="text-align:center;">		
                <a href="/home">Back to Dashboard</a>
			</div>

		</div>
	</div>
</div>
<script src="/js/jquery/jquery.js"></script>

@endsection