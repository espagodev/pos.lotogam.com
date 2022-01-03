<!doctype html>
<html lang="en">

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
        @include('layouts.partials.sidebar')
        <!-- Sidebar wrapper end -->

        <!-- Page content start  -->
        <div class="page-content">

            <!-- Header start -->
            @include('layouts.partials.header')
            <!-- Header end -->

            <!-- Main container start -->
            <div class="main-container">
                @yield('content')

                
            </div>
            <!-- Main container end -->

        </div>
        <!-- Page content end -->

    </div>
    <!-- Page wrapper end -->
   
    @include('layouts.partials.script')

</body>

</html>
