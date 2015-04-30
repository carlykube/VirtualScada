<div class="form-group">
    <!-- {!! Form::label('name', 'Project name:') !!}  -->
    {!! Form::text('name', null, ['placeholder' => 'PROJECT NAME','class'=>'wide-input']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class'=>'btn add-permission-button']) !!}
</div>