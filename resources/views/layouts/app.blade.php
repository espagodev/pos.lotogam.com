    @php
        $whitelist = ['127.0.0.1', '::1'];
    @endphp
<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap4 Dashboard Template">
    <meta name="author" content="Parkerpartialss">
    <link rel="shortcut icon" href="img/fav.png" />

    <!-- Title -->
    <title>SISTEMA POS</title>
    {{-- estilos css --}}
    @include('layouts.partials.style')


</head>

<body>
    @if(in_array($_SERVER['REMOTE_ADDR'], $whitelist))
        <input type="hidden" id="__is_localhost" value="true">
    @endif
    <!-- Loading starts -->
    <div id="loading-wrapper">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Loading ends -->

    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Sidebar wrapper start -->
        {{-- @include('layouts.partials.sidebar') --}}
        <!-- Sidebar wrapper end -->

        <!-- Page content start  -->
        <div class="page-content">

            <!-- Header start -->
            @include('layouts.partials.header')
            <!-- Header end -->

            <!-- Main container start -->
            <div class="main-container">
                <!-- Agregar campo relacionado con la moneda-->
                <input type="hidden" id="__code" value="{{session('monedaBanca')['code']}}">
                <input type="hidden" id="__symbol" value="{{session('monedaBanca')['symbol']}}">
                <input type="hidden" id="__thousand" value="{{session('monedaBanca')['thousand_separator']}}">
                <input type="hidden" id="__decimal" value="{{session('monedaBanca')['decimal_separator']}}">
                <input type="hidden" id="__symbol_placement" value="{{session('business.currency_symbol_placement')}}">
                <input type="hidden" id="__precision" value="{{config('constants.currency_precision', 2)}}">
                <input type="hidden" id="__quantity_precision" value="{{config('constants.quantity_precision', 2)}}">
                <!-- Fin del campo relacionado con la moneda-->
                @yield('content')


            </div>
            <!-- Main container end -->

        </div>
        <!-- Page content end -->

    </div>
    <!-- Page wrapper end -->
    <div class="modal fade view_register no-print" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
    </div>
    <div class="modal fade view_ticket_modal no-print" tabindex="-1" role="dialog"  aria-labelledby="myLargeModalLabel">
    </div>
    @include('layouts.partials.script')
    
</body>

</html>
