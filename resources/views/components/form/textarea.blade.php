<div class="form-group row">
    {!! Form::label($name, $label?:__('system.'.$name),['class'=>'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::textarea($name,$value,(!empty($attributes) AND is_array($attributes))?array_merge(['class' => 'form-control'], $attributes):['class' => 'form-control']) !!}
    </div>
</div>