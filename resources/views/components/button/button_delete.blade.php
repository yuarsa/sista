@php
    $page = explode('/', $url)[1];

    $text = $text ? $text : $page;

    $name = addslashes($row);
@endphp

{!! Form::open([
    'id' => str_singular($page) . '-' . $row,
    'method' => 'DELETE',
    'url' => [$url, $row],
    'class' => 'pull-right',
    'style' => 'display:inline'
]) !!}
{!! Form::button('<i class="fa fa-trash"></i>', array(
    'type'    => 'button',
    'class'   => 'btn btn-sm btn-danger',
    'onclick' => 'confirmDelete("' . '#' . str_singular($page) . '-' . $row . '", "Hapus", "Yakin Menghapus Data Ini?", "Hapus")'
)) !!}
{!! Form::close() !!}