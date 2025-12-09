<x-frontend-user :assets="$assets ?? []">

    <div class="container-fluid pt-4 pb-4 section-color">
        <div class="container pb-5">
            <div class="row">
                <div class="col-md-3 side-bar">
                    <div class="card border-0">
                        @include('frontend::frontend.partials._body_sidebar')
                    </div>
                </div>
                <div class="col-lg-9 col-12">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                                    <div class="d-sm-flex align-items-center">
                                        <img src="{{ getSingleMedia($data,'profile_image', null) }}" alt="Avatar" class="rounded-circle user-img">
                                        <div class="ms-2 user-info">
                                            <h5 class="card-title font-h5">{{ $data->display_name }}</h5>
                                            <p class="font-p custom-email">{{ $data->email }}</p>
                                            <p class="font-p">{{ $data->phone_number }}</p>
                                        </div>
                                    </div>
                                </div>
                
                                <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                                    <div class="row text-center">
                                        <div class="col-3 text-center mb-2">
                                            <div class="small font-p">{{ __('message.gender') }}</div>
                                            <span class="font-span">{{ ucfirst($data->gender) }}</span>
                                        </div>
                                        <div class="col-3 border-start text-center mb-2">
                                            <div class="small font-p">{{ __('message.weight') }}</div>
                                            <div class="font-span">{{ optional($data->userProfile)->weight ?? '-' }} {{ optional($data->userProfile)->weight_unit }}</div>
                                        </div>
                                        <div class="col-3 border-start text-center mb-2">
                                            <div class="small font-p">{{ __('message.height') }}</div>
                                            <div class="font-span">{{ optional($data->userProfile)->height ?? '-' }} {{ optional($data->userProfile)->height_unit }}</div>
                                        </div>
                                        <div class="col-3 border-start text-center">
                                            <div class="small font-p">{{ __('message.age') }}</div>
                                            <div class="font-span">{{ optional($data->userProfile)->age ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                
                                <div class="col-lg-2 col-md-2 col-sm-12 text-md-right text-center float-right">
                                    <a href="{{ route('profile') }}" class="btn btn-sm mt-2 btn-info text-white border-0">{{ __('frontend::message.edit_info') }} <img src="{{ asset('frontend-section/images/pen.png') }}" alt="Pen"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 text-center">
                        <div class="col-md-4 mb-3">
                            <div class="card border-0">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('frontend-section/images/bmi.png') }}" alt="BMI Image" height="60px" width="60px">
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="font-p">{{__('message.bmi')}}</p>
                                        <h6 class="font-h6">{{ optional($data->userProfile)->bmi ?? '-'}}</h6>
                                        <p class="font-p">{{ __('message.kcal') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-0">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('frontend-section/images/bmr.png') }}" alt="BMR Image" height="60px" width="60px">
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="font-p">{{__('message.bmr')}}</p>
                                        <h6 class="font-h6">{{ optional($data->userProfile)->bmr ?? '-' }}</h6>
                                        <p class="font-p">{{ __('message.calories') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-0">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('frontend-section/images/weight.png') }}" alt="Weight Image" height="60px" width="60px">
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="font-p">{{__('message.ideal_weight')}}</p>
                                        <h6 class="font-h6">{{ optional($data->userProfile)->ideal_weight ?? '-' }}</h6>
                                        <p class="font-p">{{ optional($data->userProfile)->ideal_weight != null ? optional($data->userProfile)->weight_unit : ''}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if( $metrics_setting['weight'] == null || $metrics_setting['weight'] == 1 )
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between flex-wrap graph-header">
                                    <div class="header-title">
                                        <h4 class="card-title mt-1 chart-title">{{__('message.weight_analysis')}}</h4>
                                    </div>
                                    <div class="d-flex align-items-center  ml-10">
                                        <div class="d-flex align-items-center text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="#f16a1b">
                                                <g id="Solid dot2">
                                                    <circle id="Ellipse 65" cx="12" cy="12" r="8" fill="#f16a1b"></circle>
                                                </g>
                                            </svg>
                                            <div class="ms-1">
                                                <h5 class="font-h5 mb-1 title-color">{{__('message.weight')}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown  border-0">
                                        <select name="weight-overview" id="weight-overview" class="form-control">
                                            <option value="week">{{ __('message.this_week') }}</option>
                                            <option value="month">  {{ __('message.this_month') }}</option>
                                            <option value="year">{{ __('message.this_year') }}</option>
                                            <option value="every">{{ __('message.all_data') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <div id="apex-line-area-weight"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if( $metrics_setting['heart_rate'] == null || $metrics_setting['heart_rate'] == 1 )
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between flex-wrap graph-header">
                                    <div class="header-title">
                                        <h4 class="card-title mt-1 chart-title">{{__('message.heart_rate_analysis')}}</h4>
                                    </div>
                                    <div class="d-flex align-items-center  ml-10">
                                        <div class="d-flex align-items-center text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="#f16a1b">
                                                <g id="Solid dot2">
                                                    <circle id="Ellipse 65" cx="12" cy="12" r="8" fill="#f16a1b"></circle>
                                                </g>
                                            </svg>
                                            <div class="ms-1">
                                                <h5 class="font-h5 mb-1 title-color">{{__('message.heart_rate')}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown  border-0">
                                        <select name="heart-rate-overview" id="heart-rate-overview" class="form-control">
                                            <option value="week">{{ __('message.this_week') }}</option>
                                            <option value="month">  {{ __('message.this_month') }}</option>
                                            <option value="year">{{ __('message.this_year') }}</option>
                                            <option value="every">{{ __('message.all_data') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <div id="apex-line-area-heart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if( $metrics_setting['push_up'] == null || $metrics_setting['push_up'] == 1 )
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between flex-wrap graph-header">
                                    <div class="header-title">
                                        <h4 class="card-title mt-1 chart-title">{{__('message.push_up_min')}}</h4>
                                    </div>
                                    <div class="d-flex align-items-center  ml-10">
                                        <div class="d-flex align-items-center text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="#f16a1b">
                                                <g id="Solid dot2">
                                                    <circle id="Ellipse 65" cx="12" cy="12" r="8" fill="#f16a1b"></circle>
                                                </g>
                                            </svg>
                                            <div class="ms-1">
                                                <h5 class="font-h5 mb-1 title-color">{{__('message.push_up')}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown  border-0">
                                        <select name="push-up-overview" id="push-up-overview" class="form-control">
                                            <option value="week">{{ __('message.this_week') }}</option>
                                            <option value="month">  {{ __('message.this_month') }}</option>
                                            <option value="year">{{ __('message.this_year') }}</option>
                                            <option value="every">{{ __('message.all_data') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <div id="apex-line-area-push-ups"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @section('bottom_script')
        <!-- apexchart JavaScript -->
        <script>
            $(document).ready(function () {
    
                @if( $metrics_setting['weight'] == null || $metrics_setting['weight'] == 1 )
                    let weight_chart_options = generateChartOptions( "{{__('message.weight')}}" , [], []);
                    let weightChart = createChart('#apex-line-area-weight', weight_chart_options);
                    weightChart.render();
        
                    ajaxForChart(weightChart, 'week', 'weight', 'kg' )
                @endif
    
                @if( $metrics_setting['heart_rate'] == null || $metrics_setting['heart_rate'] == 1 )
                // create Heart chart
                    let heart_rate_chart_option = generateChartOptions("{{__('message.heart_rate')}}", [], []);
                    let heartChart = createChart('#apex-line-area-heart', heart_rate_chart_option);
                    heartChart.render();
                    ajaxForChart(heartChart, 'week', 'heart-rate', 'bpm' )
                @endif
    
                @if( $metrics_setting['push_up'] == null || $metrics_setting['push_up'] == 1 )
                    // create Push Up chart
                    let pushups_chart_option = generateChartOptions( "{{__('message.push_up')}}", [], []);
                    let pushUpsChart = createChart('#apex-line-area-push-ups', pushups_chart_option);
                    pushUpsChart.render();
                    ajaxForChart(pushUpsChart, 'week', 'push-up-min', 'Reps' );
                @endif
    
                // Weight Chart Ajax
                $(document).on('change','#weight-overview', function() {
                    let weight_value = $('#weight-overview :selected').val();
                    ajaxForChart(weightChart, weight_value, 'weight', 'kg');
                });
    
                // Heart Chart Ajax
                $(document).on('change','#heart-rate-overview', function() {
                    let heart_value = $('#heart-rate-overview :selected').val();
                    ajaxForChart(heartChart, heart_value, 'heart-rate', 'bpm');
                });
    
                // Push Ups Chart Ajax
                $(document).on('change','#push-up-overview', function() {
                    let pushup_value = $('#push-up-overview :selected').val();
                    ajaxForChart(pushUpsChart, pushup_value, 'push-up-min', 'Reps');
                });
    
            });
    
            function ajaxForChart(chart, dateValue = 'week', type, unit)
            {
                $.ajax({
                    type: 'get',
                    url: "{{ route('user.fetchGraph') }}",
                    data: { 
                        type: type,
                        unit: unit,
                        dateValue: dateValue,
                        id: {{ $data->id }}
                    },
                    dataType : 'json',
                    success: function (response) {
                        let data = response.data;
                        let category = response.category;
                        
                        updateChart(chart,data, category);
                    }
                });
            }
    
            // Function to update chart data and categories
            function updateChart(chart, data, categories)
            {
                chart.updateOptions({
                    xaxis: {
                        categories: categories
                    },
                    series: [{
                        data: data
                    }]
                });
            }
    
            function generateChartOptions(seriesName, yAxisData, xAxisData) {
                let totalXAxis = xAxisData.length;
                let maxLabels = 10;
                let step = Math.ceil(totalXAxis / maxLabels);
    
                return {
                    series: [{
                        name: seriesName,
                        data: yAxisData
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false,
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                    },
                    xaxis: {
                        labels: {
                            rotate: -45,
                            step: step
                        },
                        categories: xAxisData,
                        tickPlacement: 'on'
                    },
                    // yaxis: {
                    //     labels: {
                    //     style: {
                    //         colors: '#EC7E4A',
                    //     }
                    //     }
                    // },
                    colors: ['#F16A1B', '#EC7E4A'],
                };
            }
            // Function to create a new ApexCharts instance
            function createChart(elementId, options) {
                return new ApexCharts(document.querySelector(elementId), options);
            }
        </script>
    @endsection
</x-frontend-user>
