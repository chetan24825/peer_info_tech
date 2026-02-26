@include("includes.mainhead")

</head>

<body>

    @include("includes.switcher")
    @include("includes.loader")

    <div class="page">
        @include("includes.header")
        @include("includes.sidebar")

        <!-- Start::app-content -->
        <div class="main-content app-content">
        
            <div class="container-fluid">


              @yield('content')

            </div>
            <!-- End::app-content-->

        @include("includes.footer")
        @include("includes.responsive-search-modal")

    </div>

    @include("includes.commonjs")

    <!-- Apex Charts JS -->
    <script src="{{asset("assets/libs/apexcharts/apexcharts.min.js")}}"></script>

    <!-- Analytics Dashboard --> 
    <script src="{{asset("assets/js/analytics-dashboard.js")}}"></script>

  {{-- not template script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   {{-- .......................................... --}}
   
   
    <script src="{{asset("assets/js/custom.js")}}"></script>
 
    @include("includes.custom_switcherjs")
    @stack('scripts');
</body>

</html> 