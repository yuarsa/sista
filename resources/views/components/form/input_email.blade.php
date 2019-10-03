<div class="form-group {{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : '' }}">
    {!! Form::label($name, $text, ['class' => 'control-label col-sm-2']) !!}
    <div class="{{ $col }}">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-{{ $icon }}"></i></div>
            {!! Form::email($name, $value, array_merge(['id' => $id, 'class' => 'form-control', 'placeholder' => $text], $attributes)) !!}
        </div>
        {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
    </div>
</div>