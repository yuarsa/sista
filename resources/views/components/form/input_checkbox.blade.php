<div class="form-group {{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : '' }}">
    {!! Form::label($name, $text, ['class' => 'control-label col-sm-2']) !!}
    <div class="{{ $col }}">
        @foreach($items as $item)
            {{ Form::checkbox($name . '[]', $item->$id) }} &nbsp; {{ $item->$value }} &nbsp;
        @endforeach
        {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
    </div>
</div>