<div class="form-group {{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : '' }}">
    {!! Form::label($name, $text, ['class' => 'control-label col-sm-2']) !!}
    <div class="{{ $col }}">
        {!! Form::textarea($name, $value, array_merge(['id' => $id, 'class' => 'form-control', 'placeholder' => $text], $attributes)) !!}
        {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
    </div>
</div>