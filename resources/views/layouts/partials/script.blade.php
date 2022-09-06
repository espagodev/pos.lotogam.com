<script type="text/javascript">
    base_path = "{{url('/')}}";

</script>

   <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js?v=$asset_v"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js?v=$asset_v"></script>
<![endif]-->
<!--**************************  Required JavaScript Files **************************-->
<!-- Required jQuery first, then Bootstrap Bundle JS -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<!-- Moment-Timezone -->
<script src="{{ asset('js/plugins/moment-timezone-with-data.min.js') }}"></script>

<!-- initializeSocket -->
<script src="{{ asset('js/app/printer.js?v=' . $asset_v) }}"></script>

@php
    $business_date_format = session('empresa.date_format', config('constants.default_date_format'));
    
    $datepicker_date_format = str_replace('d', 'dd', $business_date_format);
    $datepicker_date_format = str_replace('m', 'mm', $datepicker_date_format);
    $datepicker_date_format = str_replace('Y', 'yyyy', $datepicker_date_format);

    $moment_date_format = str_replace('d', 'DD', $business_date_format);
    $moment_date_format = str_replace('m', 'MM', $moment_date_format);
    $moment_date_format = str_replace('Y', 'YYYY', $moment_date_format);

    $business_time_format = session('empresa.time_zone');

    $moment_time_format = 'HH:mm';
    if($business_time_format == 12){
        $moment_time_format = 'hh:mm A';
    }

    $emp_ajustes_comunes = !empty(session('empresa.emp_ajustes_comunes')) ? session('empresa.emp_ajustes_comunes') : [];

    $datos_pagina_predeterminado = !empty($emp_ajustes_comunes['datos_pagina_predeterminado']) ? $emp_ajustes_comunes['datos_pagina_predeterminado'] : 50;

    $datos_tipo_impresora = session('banca.impresora');
    
    $business_time_format = session('business.time_format');

    $moment_time_format = 'HH:mm';
    if($business_time_format == 12){
        $moment_time_format = 'hh:mm A';
    }
   
    @endphp



    <script>
        moment.tz.setDefault('{{ Session::get("empresa.time_zone") }}');
        
    
        var datepicker_date_format = "{{$datepicker_date_format}}";
        var moment_date_format = "{{$moment_date_format}}";
        var moment_time_format = "{{$moment_time_format}}";

        var app_locale = "{{ config('app.locale') }}";

        var __datos_pagina_predeterminado = "{{$datos_pagina_predeterminado}}";

        var __datos_tipo_impresora = "{{$datos_tipo_impresora}}";

    </script>

 

<!--**************************  Required JavaScript Files **************************-->


<script src="{{ asset('js/functions.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/accounting.min.js') }}"></script>

<!-- *************   Vendor Js Files  ************* -->
<!-- Slimscroll JS -->
<script src="{{ asset('vendor/slimscroll/slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/slimscroll/custom-scrollbar.js') }}"></script>

<!-- Daterange -->
<script src="{{ asset('vendor/daterange/daterange.js') }}"></script>
{{-- <script src="{{ asset('vendor/daterange/custom-daterange.js') }}"></script> --}}


<!-- Toastr js -->
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>


<!-- Main JS -->
<script src="{{ asset('js/main.js') }}"></script>

<!-- validate JS -->
<script src="{{ asset('vendor/jquery-validation/dist/jquery.validate.js') }}"></script>

{{-- sweetalert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- modal --}}
<script src="{{ asset('js/modal.js') }}"></script>

<!-- Data Tables -->
<script src="{{ asset('vendor/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/custom/custom-datatables.js') }}"></script>

<!-- html2canvas -->
<script src="{{ asset('vendor/html2canvas/html2canvas.js') }}"></script>

<!-- Datepickers -->
<script src="{{ asset('vendor/datepicker/js/picker.js') }}"></script>
<script src="{{ asset('vendor/datepicker/js/picker.date.js') }}"></script>
<script src="{{ asset('vendor/datepicker/js/custom-picker.js') }}"></script>

<!-- Custom Data tables -->
{{-- <script src="{{ asset('vendor/datatables/custom/custom-datatables.js') }}"></script>
<script src="{{ asset('vendor/datatables/custom/fixedHeader.js') }}"></script> --}}

<!-- Download / CSV / Copy / Print -->
{{-- <script src="{{ asset('vendor/datatables/buttons.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('vendor/datatables/html5.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.print.min.js') }}"></script> --}}

@yield('scripts')