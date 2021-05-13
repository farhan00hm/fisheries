@extends('user.culture.home')
@section('culture')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="seasonal-production" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Culture trend for seasonal By District</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="seasonal-location-selection" style="float: right">
                    <option disabled selected>Select a location</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}">{{ $district }}</option>
                    @endforeach
                </select>
                <canvas id="seasonal-by-district" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <select class="form-select" aria-label="Select Location" id="seasonal-species-selection" style="float: right">
                {{--                <option disabled selected>Select a species</option>--}}
                @foreach($species as $species)
                    <option value="{{ $species }}">{{ $species }}</option>
                @endforeach
            </select>
            <canvas id="seasonal-by-species" width="600"  height="600" style="max-height:600px;max-width:500px;align-items: center"></canvas>
        </div>
    </div>
@endsection

@section('culture-javascript')
    <script>


        let seasonalDistrictChart;
        let seasonalSpeciesChart;
        function seasonalByProductionTrend(xAxisValue,yAxisValue){
            new Chart(document.getElementById("seasonal-production"), {
                type: 'line',
                data: {
                    labels: xAxisValue,
                    datasets: [{
                        data: yAxisValue,
                        label: "Production",
                        borderColor: "#3e95cd",
                        color:"red",
                        fill: false
                    },
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'seasonal Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }

        function seasonalByDistrictTrend(xAxisValue,yAxisValue){
            seasonalDistrictChart = new Chart(document.getElementById("seasonal-by-district"), {
                type: 'line',
                data: {
                    labels: xAxisValue,
                    datasets: [{
                        data: yAxisValue,
                        label: "Production",
                        borderColor: "#3e95cd",
                        color:"red",
                        fill: false
                    },
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'seasonal Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }

        function seasonalBySpeciesTrend(xAxisValue,yAxisValue){
            seasonalSpeciesChart = new Chart(document.getElementById("seasonal-by-species"), {
                type: 'line',
                data: {
                    labels: xAxisValue,
                    datasets: [{
                        data: yAxisValue,
                        label: "Production",
                        borderColor: "#3e95cd",
                        color:"red",
                        fill: false
                    },
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'seasonal Trend By Species'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
            // seasonalDistrictChart();
        }

        $(document).ready(function(){
            let xAxisValuesOfSeasonalProduction = {!! json_encode($xAxisValuesOfSeasonalProduction) !!};
            let yAxisValuesOfSeasonalProduction = {!! json_encode($yAxisValuesOfSeasonalProduction) !!};
            let xAxisValuesOfSeasonalBySpecies = {!! json_encode($xAxisValuesOfSeasonalBySpecies) !!};
            let yAxisValuesOfSeasonalBySpecies = {!! json_encode($yAxisValuesOfSeasonalBySpecies) !!};

            $("#seasonal-location-selection").change(function(){

                let selectedLocation = $("#seasonal-location-selection option:selected").val();
                let url = "{{ route('seasonal-by-location',':location') }}"
                url = url.replace(':location',selectedLocation);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    console.log(data)
                    let xAxisValue= data.xAxisValuesOfSeasonalProduction;
                    let yAxisValue = data.yAxisValuesOfSeasonalProduction;
                    seasonalDistrictChart.destroy();
                    seasonalByDistrictTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            $("#seasonal-species-selection").change(function(){
                let selectedSpecies = $("#seasonal-species-selection option:selected").val();
                let url = "{{ route('seasonal-by-species',':species') }}"
                url = url.replace(':species',selectedSpecies);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    let xAxisValue= data.xAxisValue;
                    let yAxisValue = data.yAxisValue;
                    seasonalSpeciesChart.destroy();
                    seasonalBySpeciesTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            seasonalByProductionTrend(xAxisValuesOfSeasonalProduction,yAxisValuesOfSeasonalProduction);
            seasonalByDistrictTrend(xAxisValuesOfSeasonalProduction,yAxisValuesOfSeasonalProduction);
            seasonalBySpeciesTrend(xAxisValuesOfSeasonalBySpecies,yAxisValuesOfSeasonalBySpecies);
        });
    </script>
@endsection
