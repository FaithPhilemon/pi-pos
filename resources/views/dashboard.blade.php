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



            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Sales last 30 Days')}}</h3>
                    </div>
                    <div class="card-block text-center">
                        <div id="line_chart_30_days" class="chart-shadow"></div>
                    </div>
                </div>
            </div>


            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Sales last 12 Months')}}</h3>
                    </div>
                    <div class="card-block text-center">
                        <div id="line_chart_12_months" class="chart-shadow"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
        </div> --}}
    </div>
	<!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/owl.carousel/dist/owl.carousel.min.js') }}"></script>
        {{-- <script src="{{ asset('plugins/chartist/dist/chartist.min.js') }}"></script> --}}
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

        <script>

            var chart30Days = AmCharts.makeChart("line_chart_30_days", {
                "type": "serial",
                "theme": "light",
                "dataDateFormat": "YYYY-MM-DD",
                "precision": 2,
                "valueAxes": [{
                    "id": "v1",
                    "position": "left",
                    "autoGridCount": false,
                    "labelFunction": function(value) {
                        return "₦" + Math.round(value) + "M";
                    }
                }, {
                    "id": "v2",
                    "gridAlpha": 0,
                    "autoGridCount": false
                }],
                "graphs": [{
                    "id": "g1",
                    "valueAxis": "v2",
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "bulletSize": 8,
                    "hideBulletsCount": 50,
                    "lineThickness": 3,
                    "lineColor": "#2ed8b6",
                    "title": "Sales",
                    "useLineColorForBulletBorder": true,
                    "valueField": "total_sales",
                    "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
                }, 
                
                // {
                //     "id": "g2",
                //     "valueAxis": "v2",
                //     "bullet": "round",
                //     "bulletBorderAlpha": 1,
                //     "bulletColor": "#FFFFFF",
                //     "bulletSize": 8,
                //     "hideBulletsCount": 50,
                //     "lineThickness": 3,
                //     "lineColor": "#e95753",
                //     "title": "Market Days ALL",
                //     "useLineColorForBulletBorder": true,
                //     "valueField": "market2",
                //     "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
                // }
            
                ],
                "chartCursor": {
                    "pan": true,
                    "valueLineEnabled": true,
                    "valueLineBalloonEnabled": true,
                    "cursorAlpha": 0,
                    "valueLineAlpha": 0.2
                },
                "categoryField": "date",
                "categoryAxis": {
                    "parseDates": true,
                    "minPeriod": "DD", 
                    "dashLength": 1,
                    "minorGridEnabled": true,
                    // "equalSpacing": false
                },
                "legend": {
                    "useGraphSettings": true,
                    "position": "top"
                },
                "balloon": {
                    "borderThickness": 1,
                    "shadowAlpha": 0
                },
                "dataProvider": {!! json_encode($salesLast30Days) !!}
            });

            // console.log({!! json_encode($salesLast30Days) !!});

            var chart30Days = AmCharts.makeChart("line_chart_12_months", {
                "type": "serial",
                "theme": "light",
                "dataDateFormat": "YYYY-MM-DD",
                "precision": 2,
                "valueAxes": [{
                    "id": "v1",
                    "position": "left",
                    "autoGridCount": false,
                    "labelFunction": function(value) {
                        return "₦" + Math.round(value) + "M";
                    }
                }, {
                    "id": "v2",
                    "gridAlpha": 0,
                    "autoGridCount": false
                }],
                "graphs": [{
                    "id": "g1",
                    "valueAxis": "v2",
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "bulletSize": 8,
                    "hideBulletsCount": 50,
                    "lineThickness": 3,
                    "lineColor": "#e95753",
                    "title": "Sales",
                    "useLineColorForBulletBorder": true,
                    "valueField": "total_sales",
                    "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
                }
                
                // , {
                //     "id": "g2",
                //     "valueAxis": "v2",
                //     "bullet": "round",
                //     "bulletBorderAlpha": 1,
                //     "bulletColor": "#FFFFFF",
                //     "bulletSize": 8,
                //     "hideBulletsCount": 50,
                //     "lineThickness": 3,
                //     "lineColor": "#e95753",
                //     "title": "Market Days ALL",
                //     "useLineColorForBulletBorder": true,
                //     "valueField": "market2",
                //     "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
                // }
                
                ],
                "chartCursor": {
                    "pan": true,
                    "valueLineEnabled": true,
                    "valueLineBalloonEnabled": true,
                    "cursorAlpha": 0,
                    "valueLineAlpha": 0.2
                },
                "categoryField": "month_year",
                "categoryAxis": {
                    "parseDates": true,
                    "dashLength": 1,
                    "minorGridEnabled": true,
                    // "minPeriod": "MM",
                },
                "legend": {
                    "useGraphSettings": true,
                    "position": "top"
                },
                "balloon": {
                    "borderThickness": 1,
                    "shadowAlpha": 0
                },
                "dataProvider": {!! json_encode($salesLast12Months) !!}
            });

            console.log({!! json_encode($salesLast12Months) !!});

        </script>
        
    @endpush
@endsection