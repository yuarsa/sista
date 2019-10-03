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
                    <h4 class="title-faktur">MONITORING INSPEKSI</h4>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-xs-12">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Kelompok</th>
                                <th>Kode Aset</th>
                                <th>Nama Aset</th>
                                <th>Lokasi</th>
                                <th>Uraian Kerusakan</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->kelompok->assetgrp_name }}</td>
                                    <td>{{ $row->aset->code }}</td>
                                    <td>{{ $row->aset->asset_name }}</td>
                                    <td>{{ $row->area->area_name }}</td>
                                    <td>{{ $row->insp_desc }}</td>
                                    <td>
                                        @if ($row->insp_status == '1')
                                            Open
                                        @elseif($row->insp_status == '2')
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