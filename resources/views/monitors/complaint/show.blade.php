@extends('layouts.admin')
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Detail Data Komplain</h3>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-bordered table-condensed table-striped">
            <tr>
                <th style="width: 200px">Kode</th>
                <td>{{ $data->complain_code }}</td>
            </tr>
            <tr>
                <th>Kerugian Material</th>
                <td>{{ $data->complain_failure }}</td>
            </tr>
            <tr>
                <th>Nama Identitas</th>
                <td>{{ $data->complain_name }}</td>
            </tr>
            <tr>
                <th>Alamat Identitas</th>
                <td>{{ $data->complain_address }}</td>
            </tr>
            <tr>
                <th>Uraian</th>
                <td>{{ $data->complain_desc }}</td>
            </tr>
            <tr>
                <th>Gambar</th>
                <td>
                    <div class="row" style="margin-bottom: 20px">
                        <div class="col-md-6">
                            @if ($data->complain_image == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->complain_image) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($data->complain_image1 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->complain_image1) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @if ($data->complain_image2 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->complain_image2) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($data->complain_image3 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->complain_image3) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Follow Up</th>
                <td>
                    @if ($data->complain_status == 1)
                        <label class="label label-success">Open</label>
                    @elseif($data->complain_status == 2)
                        <label class="label label-warning">Close</label>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Gambar Follow Up</th>
                <td>
                    <div class="row" style="margin-bottom: 20px">
                        <div class="col-md-6">
                            @if ($data->complain_follow_up_image == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->complain_follow_up_image) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($data->complain_follow_up_image1 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->complain_follow_up_image1) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @if ($data->complain_follow_up_image2 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->complain_follow_up_image2) }}" style="width:410px;height:300px">
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($data->complain_follow_up_image3 == '')
                                <img class="img-responsive" src="{{ asset('storage/img/no_image_available.jpg') }}" style="width:410px;height:300px">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/'.$data->complain_follow_up_image3) }}" style="width:410px;height:300px">
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
                <a href="{{ url('monitor/complaints') }}" class="btn btn-sm btn-default"><span class="fa fa-times-circle"></span> &nbsp;Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
