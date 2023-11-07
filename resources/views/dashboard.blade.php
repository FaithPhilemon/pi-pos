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
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-red">
                    <div class="card-body">
                        
                        <div class="row align-items-center mb-10">
                            <div class="col-auto">
                                <i class="fa fa-shopping-cart text-red f-18"></i>
                            </div>
                            <div class="col">
                                <h6 class="mb-5 fw-700 text-white text-uppercase">Gross Sales</h6>
                                <h3 class="mb-0 fw-700 text-white">{{ $settings->currency_symbol }}{{ number_format($grossSales) }}</h3>
                            </div>

                        </div>
                        {{-- <p class="mb-0 text-white"><span class="label label-danger mr-10">+11%</span>From Previous Month</p> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-blue">
                    <div class="card-body">
                        <div class="row align-items-center mb-10">
                            <div class="col">
                                <h6 class="mb-5 fw-700 text-white text-uppercase">Net Sales</h6>
                                <h3 class="mb-0 fw-700 text-white">{{ $settings->currency_symbol }}{{ number_format($netSales) }}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-database text-blue f-18"></i>
                            </div>
                        </div>
                        {{-- <p class="mb-0 text-white"><span class="label label-primary mr-10">+12%</span>From Previous Month</p> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-green">
                    <div class="card-body">
                        <div class="row align-items-center mb-10">
                            <div class="col">
                                <h6 class="mb-5 fw-700 text-white text-uppercase">Invoice Due</h6>
                                <h3 class="mb-0 fw-700 text-white">{{$invoiceDue}}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign text-green f-18"></i>
                            </div>
                        </div>
                        {{-- <p class="mb-0 text-white"><span class="label label-success mr-10">+52%</span>From Previous Month</p> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-yellow">
                    <div class="card-body">
                        <div class="row align-items-center mb-10">
                            <div class="col">
                                <h6 class="mb-5 fw-700 text-white text-uppercase">Sales Return</h6>
                                <h3 class="mb-0 fw-700 text-white">{{$totalSellReturn}}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tags text-warning f-18"></i>
                            </div>
                        </div>
                        {{-- <p class="mb-0 text-white"><span class="label label-warning mr-10">+52%</span>From Previous Month</p> --}}
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