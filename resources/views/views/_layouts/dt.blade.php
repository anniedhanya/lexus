@extends('_layouts.default')

@section('head-assets')
    @parent
    <link href="{{ asset('plugins/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('footer-assets')
    @parent
    
    <script src="{{asset('plugins/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js')}}"></script>
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        if($('#datatable').length) {

            var $table = $('#datatable');
           
            var ajaxUrl = $table.data('datatable-ajax-url');

            if(typeof dt_settings != 'object')
                dt_settings = {};
            dt_table = $table.dataTable($.extend({
                // "scrollX": true,
                "processing": true,
                "serverSide": true,
                "ajax": ajaxUrl,
                columns: my_columns,
                'aoColumnDefs': [
                    { 'bSortable': false, 'sClass': "text-center", 'aTargets': ['nosort'] },
                    { "bSearchable": false, "aTargets": [ 'nosearch' ] }
                ],
                errMode: 'throw',
                "language": {
                    "search": "",
                    'searchPlaceholder': 'Search...',
                    'emptyTable': 'No data found!'
                },
                initComplete: function(settings, json) {
                    $(this).trigger('initComplete', [this]);
                    $(window).trigger('resize');
                },
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull){
                    update_slno(this);
                }
            }, dt_settings));
        }
        function update_slno(dt) {
            if (typeof dt != "undefined" && typeof slno_i != 'undefined') {
                table_rows = dt.fnGetNodes();
                var oSettings = dt.fnSettings();
                $.each(table_rows, function(index){
                    $("td:eq(" + slno_i + ")", this).html(oSettings._iDisplayStart+index+1);
                });
            }
        }

    </script>
@endsection


