<div class="form-group">
	{!! Form::label('name', 'Project name:') !!} {!! Form::text('name', null, ['class'=>'input-group']) !!}
	
</div>

<div class="form-group">
	{!! Form::submit($submitButtonText, ['class'=>'btn btn-primary btn-md']) !!}
</div>  