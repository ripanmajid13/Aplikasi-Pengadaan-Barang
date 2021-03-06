@extends('layouts.app')

@push('style_plugin')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endpush

@push('style_inline')
@endpush

@push('script_plugin')
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
@endpush

@push('script_inline')
    <script>
        let dataTable = $("#dataTable").DataTable({
            "responsive": true,
            "autoWidth": false,
            processing: true,
            serverSide: true,
            ajax: "{{ $urlTable }}",
            columns: [
                {data: "DT_RowIndex", class: "align-middle"},
                {data: "date", class: "align-middle"},
                {data: "code", class: "align-middle"},
                {data: "item_id", class: "align-middle"},
                {data: "supplier_id", class: "align-middle"},
                {data: "qty", class: "align-middle"},
                @canany([$canEdit, $canDelete])
                    {data: "action", searchable: false, orderable: false}
                @endcanany
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: -1 },
            ],
            responsive: {
                details: {
                    renderer: function ( api, rowIdx, columns ) {
                        var data = $.map( columns, function ( col, i ) {
                            if (col.title.length == 0) {
                                var title = 'Action',
                                    padding = 'class="pt-2 pb-1"';
                            } else {
                                var title = col.title,
                                    padding = 'class="pt-1 pb-1"';
                            }
                            return col.hidden ?
                                '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'" class="text-sm">'+
                                    '<td '+padding+'>'+title+' <span class="float-right">:</span>'+'</td> '+
                                    '<td class="pt-1 pb-1">'+col.data+'</td>'+
                                '</tr>' :
                                '';
                        } ).join('');

                        return data ?$('<table/>').append( data ) :false;
                    }
                }
            },
            pageLength: 10,
            lengthMenu: [[5, 10, 50, 100, -1], [5, 10, 50, 100, "All"]],
            "language": {
                "emptyTable": '<p class="my-3">Tidak ada data yang tersedia pada tabel ini</p>'
            }
        });

        $('body').on('click', '.btn-form', function(e) {
            e.preventDefault();

            $('#body-table').hide();
            $('#btn-create').addClass('collapse');
            $('#card').append(`
                <div id="body-form">
                    <div class="card-body p-1">
                        <p class="text-center my-5 py-5">Loading &nbsp; <i class="fas fa-spinner fa-pulse"></i></p>
                    </div>
                </div>
            `);
            $.post($(this).attr('href'), { "_token" : $('meta[name="csrf-token"]').attr('content') },  function(response) {
                $('.card-title').html(`${$(this).attr('title') ? 'Edit' :'Create'} Data`);
                $('#body-form').html(response);
                $('#date').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
                $('.select2').select2({
                    placeholder: "Silahkan Pilih"
                });
            })
            .fail(function(xhr) {
                const data = JSON.parse(xhr.responseText);
                $('#body-form').html(`
                    <div class="card-body p-1">
                        <p class="text-center text-danger my-5 py-5">Error : ${data.message}</p>
                    </div>
                `);
            });
        });

        $('body').on('submit', '#form-action', function(e) {
            e.preventDefault();

            const me =  $(this),
                  text = $(this).find('.btn-submit').html(),
                  url = $(this).attr('action');

            me.find('.form-control').removeClass('is-invalid');
            me.find('.error').remove();
            me.find('.form-group .select2-container .selection .select2-selection').removeClass('error-select2');

            me.find('.btn-submit').html(text+'&nbsp; <i id="loading" class="fas fa-spinner fa-pulse"></i>');
            me.find('.btn-submit').attr('type', 'button');
            me.find('.btn-reset').attr('type', 'button');
            me.find('.btn-back').attr('type', 'button');

            $.post(url, me.serialize(), function(response) {
                const data = JSON.parse(response);
                const {sts, icon, msg} = data;

                if (sts == 'errors') {
                    if ($.isEmptyObject(data) == false) {
                        form_validation(data);
                    }
                } else {
                    dataTable.ajax.reload();
                    alert_toast(icon, msg);

                    if (sts =='store') {
                        me.find('#item_id').val('').trigger('change');
                        me.find('#supplier_id').val('').trigger('change');
                        me.find('#qty').val('');
                        me.find('.date').val("{{ date('d/m/Y') }}");
                    }
                }

                me.find('.btn-submit').html(text);
                me.find('.btn-submit').attr('type', 'submit');
                me.find('.btn-reset').attr('type', 'reset');
                me.find('.btn-back').attr('type', 'reset');
            })
            .fail(function(xhr) {
                const data = JSON.parse(xhr.responseText);
                alert_toast('error', data.message);

                me.find('.btn-submit').html(text);
                me.find('.btn-submit').attr('type', 'submit');
                me.find('.btn-reset').attr('type', 'reset');
                me.find('.btn-back').attr('type', 'reset');
            });
        });

        $('body').on('click', '.btn-reset', function(e) {
            e.preventDefault();

            if ($(this).attr('type') == 'reset') {
                $('#form-action').find('.form-control').removeClass('is-invalid');
                $('#form-action').find('.error').remove();
                $('#form-action').find('.form-group .select2-container .selection .select2-selection').removeClass('error-select2');

                $('#form-action').find('#name').val('');
                $('#form-action').find('#username').val('');
                $('#form-action').find('#email').val('');
                $('#form-action').find('#password').val('');
            }
        });

        $('body').on('click', '.btn-back', function(e) {
            e.preventDefault();

            if ($(this).attr('type') == 'reset') {
                $('#body-form').remove();
                $('.card-title').html(`List Data`);
                $('#btn-create').removeClass('collapse');
                $('#body-table').show();
            }
        });

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();

            const me = $(this),
                  url = me.attr('href'),
                  text = me.attr('data-text'),
                  btn = me.html();

            Swal.fire({
                icon: 'warning',
                title: 'Apakah kamu yakin ?',
                text: `Hapus satuan ${text}.`,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                focusCancel: true,
                width: '30%',
                position: 'top'
                // padding: '5px',
            }).then((result) => {
                if (result.value) {
                    me.html('<i class="fas fa-spinner fa-pulse"></i>').addClass('disabled').css("opacity", 5);
                    $('.btn-form').addClass('disabled').css("opacity", 5);
                    $('.btn-roles').addClass('disabled').css("opacity", 5);

                    $.post(url, { "_method" : "DELETE", "_token" : $('meta[name="csrf-token"]').attr('content') }, function(response) {
                        const data = JSON.parse(response);
                        const { icon, msg} = data;

                        if(icon == 'success') {
                            dataTable.ajax.reload();
                        }

                        alert_toast(icon, msg);

                        me.html(btn).removeClass('disabled');
                        $('.btn-form').removeClass('disabled');
                        $('.btn-roles').removeClass('disabled');
                    })
                    .fail(function(xhr) {
                        const data = JSON.parse(xhr.responseText);
                        alert_toast('error', data.message);

                        me.html(btn).removeClass('disabled');
                        $('.btn-form').removeClass('disabled');
                        $('.btn-roles').removeClass('disabled');
                    });
                }
            })
        });
    </script>
@endpush

@section('content')
    <div id="card" class="card">
        <div class="card-header p-1">
            <div class="d-flex justify-content-between">
                <h4 class="card-title text-md" style="padding-top: 1px;">List Data</h4>
                @can($canCreate)
                    <a href="{{ $urlCreate }}" id="btn-create" class="btn btn-primary btn-form btn-xs px-1 py-0">Create</a>
                @endcan
            </div>
        </div>

        <div id="body-table" class="card-body p-1">
            <table id="dataTable" class="table table-sm table-bordered table-hover text-xs dt-responsive nowrap mb-0" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>No Transaksi</th>
                        <th>Barang</th>
                        <th>Supplier</th>
                        <th>Jumlah</th>
                        @canany([$canEdit, $canDelete])
                            <th style="width: 5%;"></th>
                        @endcanany
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td colspan="6" class="py-5">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
