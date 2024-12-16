@extends('_layouts.default')
@section('meta_title')
    {{ 'Dashboard' }}
@stop
@section('head-assets')

    @parent
@endsection

@section('content-area')
    <!-- page content -->
    <div class="">
   
           

    </div>


@endsection


@section('footer-assets')
    @parent

    {{-- <script type="text/javascript">
setTimeout(function() {
  location.reload();
}, 30000);
</script> --}}

    <!-- <script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="http://www.amcharts.com/lib/3/pie.js"></script> -->
    <script src="{{ asset('js/amcharts.js') }}"></script>
    <script src="{{ asset('js/pie.js') }}"></script>
  
    <style type="text/css">
        #graph_donut_chart {
            width: 100%;
            height: 160px;
            margin: 0 auto;
            background: transparent url(http://44.206.214.192/public/img/graph-cnt.png) no-repeat center 45px;
        }

        #graph_donut_chart a {
            top: -50px !important;
        }
    </style>
@endsection
