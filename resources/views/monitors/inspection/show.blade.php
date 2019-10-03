@extends('layouts.admin')
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Detail Data Inspeksi</h3>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-bordered table-condensed table-striped">
            <tr>
                <th style="width: 200px">Kode</th>
                <td>{{ $data->insp_code }}</td>
            </tr>
            <tr>
                <th>Area</th>
                <td>{{ $data->area->area_name }}</td>
            </tr>
            <tr>
                <th>Kelompok Aset</th>
                <td>{{ $data->kelompok->assetgrp_name }}</td>
            </tr>
            <tr>
                <th>Aset</th>
                <td>[{{ $data->aset->code }}] - {{ $data->aset->asset_name }}</td>
            </tr>
            <tr>
                <th>Volume</th>
                <td>{{ $data->insp_volume }}</td>
            </tr>
            <tr>
                <th>Matrik</th>
                <td>{{ $data->matrik->matrik_name }}</td>
            </tr>
            <tr>
                <th>Kategori Kerusakan</th>
                <td>{{ $data->matrik->fault->fault_name }}</td>
            </tr>
            <tr>
                <th>Prioritas</th>
                <td>{{ $data->matrik->repair->repair_name }}</td>
            </tr>
            <tr>
                <th>Uraian</th>
                <td>{{ $data->insp_desc }}</td>
            </tr>
            <tr>
                <th>Gambar</th>
                <td>
                    <div class="row" style="margin-bottom: 20px">
                        <div class="col-md-6">
                            @if ($data->insp_image == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->insp_image) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($data->insp_image1 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->insp_image1) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @if ($data->insp_image2 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->insp_image2) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($data->insp_image3 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->insp_image3) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Follow Up</th>
                <td>{{ $data->insp_follow_up }}</td>
            </tr>
            <tr>
                <th>Gambar Folloow Up</th>
                <td>
                    <div class="row" style="margin-bottom: 20px">
                        <div class="col-md-6">
                            @if ($data->insp_follow_up_image == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->insp_follow_up_image) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($data->insp_follow_up_image1 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->insp_follow_up_image1) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @if ($data->insp_follow_up_image2 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->insp_follow_up_image2) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($data->insp_follow_up_image3 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->insp_follow_up_image3) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="box-footer">
        <div class="col-md-12">
            <div class="form-group text-center">
                <a href="{{ url('monitor/inspections') }}" class="btn btn-sm btn-default"><span class="fa fa-times-circle"></span> &nbsp;Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
