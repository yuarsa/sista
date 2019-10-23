@extends('layouts.admin')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-filter"></i> Filter</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <form method="post" id="frmFilter">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Awal</label>
                        {!! Form::hidden('filter_from', request('filter_from'), ['class' => 'from']) !!}
                        {!! Form::text('filter_from_alt', request('filter_from_alt'), ['class' => 'form-control from_alt', 'placeholder' => 'Tanggal Awal', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Akhir</label>
                        {!! Form::hidden('filter_to', request('filter_to'), ['class' => 'to']) !!}
                        {!! Form::text('filter_to_alt', request('filter_to_alt'), ['class' => 'form-control to_alt', 'placeholder' => 'Tanggal Akhir', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status</label>
                        {{ Form::select('status_id', $status, null, ['id' => 'status_id', 'placeholder' => 'Status']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Shift</label>
                        {{ Form::select('shift_id', $shift, null, ['id' => 'shift_id', 'placeholder' => 'Shift']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::button('<span class="fa fa-filter"></span> Filter', ['type' => 'submit', 'class' => 'btn btn-sm btn-info btn-filter']) !!}
        </div>
    </form>
</div>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Monitoring Komplain</h3>
        <div class="box-tools pull-right">
            <a href="#" class="btn btn-sm btn-default" title="Print" data-toggle="modal" data-target="#export-data"><i class="fa fa-print"></i> Cetak</a>
        </div>
    </div>
    <div class="box-body table-responsive">
        <table id="table-data2" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Kerugian</th>
                    <th>Identitas</th>
                    <th>Alamat</th>
                    <th>Uraian</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th style="width: 50px"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="export-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Filter Print Data</h4>
            </div>
            <form id="frmExport" action="{{ url('monitor/complaints_print') }}" role="form" class="form-horizontal" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Shift</label>
                            {{ Form::select('export_shift', $shift, null, ['id' => 'export_shift', 'class' => 'form-control', 'placeholder' => 'Pilih Shift']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Status</label>
                            {{ Form::select('export_status', $status, null, ['id' => 'export_status', 'class' => 'form-control', 'placeholder' => 'Pilih Status']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Tanggal</label>
                            {!! Form::hidden('export_from', request('export_from'), ['class' => 'export_from']) !!}

                            {!! Form::text('export_from_alt', request('export_from_alt'), ['class' => 'form-control export_from_alt', 'placeholder' => 'Tanggal Awal', 'autocomplete' => 'off']) !!}
                            <br>
                            {!! Form::hidden('export_to', request('export_to'), ['class' => 'export_to']) !!}

                            {!! Form::text('export_to_alt', request('export_to_alt'), ['class' => 'form-control export_to_alt', 'placeholder' => 'Tanggal Akhir', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#status_id').select2({placeholder: "Status", width:'100%'});
            $('#export_shift').select2({placeholder: "Shift", width:'100%'});
            $('#export_status').select2({placeholder: "Status", width:'100%'});

            $('#from').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

            $('.from_alt').datepicker({
                format: 'dd-M-yyyy',
                autoclose: true
            }).on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $('.to_alt').datepicker('setStartDate', minDate);

                var from = selected.format('yyyy-mm-dd');
                $('.from').val(from);

                var start_date = $('.from_alt').val();
                $('.to_alt').val(start_date);
                $('.to').val(from);
            });

            $(".to_alt").datepicker({
                format: 'dd-M-yyyy',
                autoclose: true
            }).on('changeDate', function (selected) {
                var maxDate = new Date(selected.date.valueOf());
                $('.from_alt').datepicker('setEndDate', maxDate);

                var to = selected.format('yyyy-mm-dd');
                $('.to').val(to);
            });

            $('.export_from_alt').datepicker({
                format: 'dd-M-yyyy',
                autoclose: true
            }).on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $('.export_to_alt').datepicker('setStartDate', minDate);

                var from = selected.format('yyyy-mm-dd');
                $('.export_from').val(from);

                var start_date = $('.export_from_alt').val();
                $('.export_to_alt').val(start_date);
                $('.export_to').val(from);
            });

            $(".export_to_alt").datepicker({
                format: 'dd-M-yyyy',
                autoclose: true
            }).on('changeDate', function (selected) {
                var maxDate = new Date(selected.date.valueOf());
                $('.export_from_alt').datepicker('setEndDate', maxDate);

                var to = selected.format('yyyy-mm-dd');
                $('.export_to').val(to);
            });

            var oTable = $('#table-data2').DataTable({
                processing : true,
                serverSide : true,
                ajax : {
                    url: '{{ url('monitor/complaints_data') }}',
                    data: function(d) {
                        d.from = $('input[name=filter_from]').val();
                        d.to = $('input[name=filter_to]').val();
                        d.status_id = $('select[name=status_id]').val();
                    }
                },
                columns: [
                    { data: 'complain_code', name: 'complain_code' },
                    { data: 'complain_failure', name: 'complain_failure' },
                    { data: 'complain_name', name: 'complain_name' },
                    { data: 'complain_address', name: 'complain_address' },
                    { data: 'complain_desc', name: 'complain_desc'},
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#frmFilter').on('submit', function(e) {
                oTable.draw();

                e.preventDefault();
            });
        });
    </script>
@endpush
