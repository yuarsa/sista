@extends('layouts.print')
@section('content')
    <style>
        .title-faktur {
            padding: 10px;
            text-align: center;
        }
    </style>
    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="title-faktur">MONITORING KOMPLAIN</h4>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-xs-12">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Kerugian</th>
                                <th>Identitas</th>
                                <th>Alamat</th>
                                <th>Uraian</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->complain_code }}</td>
                                    <td>{{ $row->complain_failure }}</td>
                                    <td>{{ $row->complain_name }}</td>
                                    <td>{{ $row->complain_address }}</td>
                                    <td>{{ $row->complain_desc }}</td>
                                    <td>
                                        @if ($row->complain_status == '1')
                                            Open
                                        @elseif($row->complain_status == '2')
                                            close
                                        @endif
                                    </td>
                                    <td>{{ $row->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection