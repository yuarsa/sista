<div class="{{ $col }}">
    <div class="form-group text-center">
        {!! Form::button('<span class="fa fa-save"></span> &nbsp; Simpan', ['type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'id' => 'btn-save-submit']) !!}
        &nbsp;
        <a href="{{ url($cancel) }}" class="btn btn-sm btn-default"><span class="fa fa-times-circle"></span> &nbsp;Batal</a>
    </div>
</div>