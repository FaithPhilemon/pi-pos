@extends('layouts.main') 
@section('title', 'Dashboard')
@section('content')
    <!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" href="{{ asset('plugins/weather-icons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/chartist/dist/chartist.min.css') }}">
    @endpush

    <div class="container-fluid">
    	<div class="row">
            <div class="col-xl-4 col-md-12">
                <div class="card analytic-card card-green">
                    <div class="card-body">
                        <div class="row align-items-center mb-30">
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart text-green f-18 analytic-icon"></i>
                            </div>
                            <div class="col text-right">
                                <h3 class="mb-5 text-white">15,678</h3>
                                <h6 class="mb-0 text-white">Total Sales</h6>
                            </div>
                        </div>
                        <p class="mb-0  text-white d-inline-block">Total Income : </p>
                        <h5 class=" text-white d-inline-block mb-0 ml-10">$2,451</h5>
                        <h6 class="mb-0 d-inline-block  text-white float-right"><i class="fas fa-caret-up mr-10 f-18"></i>10%</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card analytic-card card-blue">
                    <div class="card-body">
                        <div class="row align-items-center mb-30">
                            <div class="col-auto">
                                <i class="fas fa-users text-blue f-18 analytic-icon"></i>
                            </div>
                            <div class="col text-right">
                                <h3 class="mb-5 text-white">1,678</h3>
                                <h6 class="mb-0 text-white">Total Users</h6>
                            </div>
                        </div>
                        <p class="mb-0 text-white d-inline-block">Total Revenue : </p>
                        <h5 class="text-white d-inline-block mb-0 ml-10">$2,451</h5>
                        <h6 class="mb-0 d-inline-block text-white float-right"><i class="fas fa-caret-up mr-10 f-18"></i>30%</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card analytic-card card-red">
                    <div class="card-body">
                        <div class="row align-items-center mb-30">
                            <div class="col-auto">
                                <i class="fas fa-file-code text-red f-18 analytic-icon"></i>
                            </div>
                            <div class="col text-right">
                                <h3 class="mb-5 text-white">15,678</h3>
                                <h6 class="mb-0 text-white">Total Project</h6>
                            </div>
                        </div>
                        <p class="mb-0 d-inline-block text-white">Active Projects : </p>
                        <h5 class="text-white d-inline-block mb-0 ml-10">$2,451</h5>
                        <h6 class="mb-0 d-inline-block text-white float-right"><i class="fas fa-caret-down mr-10 f-18"></i>10%</h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- page statustic chart end -->
    </div>
	<!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/owl.carousel/dist/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('plugins/chartist/dist/chartist.min.js') }}"></script>
        <script src="{{ asset('plugins/flot-charts/jquery.flot.js') }}"></script>
        <!-- <script src="{{ asset('plugins/flot-charts/jquery.flot.categories.js') }}"></script> -->
        <script src="{{ asset('plugins/flot-charts/curvedLines.js') }}"></script>
        <script src="{{ asset('plugins/flot-charts/jquery.flot.tooltip.min.js') }}"></script>

        <script src="{{ asset('plugins/amcharts/amcharts.js') }}"></script>
        <script src="{{ asset('plugins/amcharts/serial.js') }}"></script>
        <script src="{{ asset('plugins/amcharts/themes/light.js') }}"></script>
       
        
        <script src="{{ asset('js/widget-statistic.js') }}"></script>
        <script src="{{ asset('js/widget-data.js') }}"></script>
        <script src="{{ asset('js/dashboard-charts.js') }}"></script>
        
    @endpush
@endsection