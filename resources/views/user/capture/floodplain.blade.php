@extends('user.capture.home')
@section('capture')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="floodPlain-production" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Culture trend for floodPlain By District</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="floodPlain-location-selection" style="float: right">
                    <option disabled selected>Select a location</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}">{{ $district }}</option>
                    @endforeach
                </select>
                <canvas id="floodPlain-by-district" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <select class="form-select" aria-label="Select Location" id="floodPlain-species-selection" style="float: right">
                {{--                <option disabled selected>Select a species</option>--}}
                @foreach($species as $species)
                    <option value="{{ $species }}">{{ $species }}</option>
                @endforeach
            </select>
            <canvas id="floodPlain-by-species" width="600"  height="600" style="max-height:600px;max-width:500px;align-items: center"></canvas>
        </div>
    </div>

@endsection

@section('capture-javascript')
    <script>
        let floodPlainDistrictChart;
        let floodPlainSpeciesChart;
        function floodPlainByProductionTrend(xAxisValue,yAxisValue){
            new Chart(document.getElementById("floodPlain-production"), {
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
                        text: 'floodPlain Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }

        function floodPlainByDistrictTrend(xAxisValue,yAxisValue){
            floodPlainDistrictChart = new Chart(document.getElementById("floodPlain-by-district"), {
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
                        text: 'floodPlain Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }

        function floodPlainBySpeciesTrend(xAxisValue,yAxisValue){
            floodPlainSpeciesChart = new Chart(document.getElementById("floodPlain-by-species"), {
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
                        text: 'floodPlain Trend By Species'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
            // floodPlainDistrictChart();
        }

        $(document).ready(function(){
            let xAxisValuesOfFloodPlainProduction = {!! json_encode($xAxisValuesOfFloodPlainProduction) !!};
            let yAxisValuesOfFloodPlainProduction = {!! json_encode($yAxisValuesOfFloodPlainProduction) !!};
            let xAxisValuesOfFloodPlainBySpecies = {!! json_encode($xAxisValuesOfFloodPlainBySpecies) !!};
            let yAxisValuesOfFloodPlainBySpecies = {!! json_encode($yAxisValuesOfFloodPlainBySpecies) !!};

            $("#floodPlain-location-selection").change(function(){

                let selectedLocation = $("#floodPlain-location-selection option:selected").val();
                let url = "{{ route('floodPlain-by-location',':location') }}"
                url = url.replace(':location',selectedLocation);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    let xAxisValue= data.xAxisValuesOfFloodPlainProduction;
                    let yAxisValue = data.yAxisValuesOfFloodPlainProduction;
                    console.log(yAxisValue)
                    // floodPlainDistrictChart.destroy();
                    floodPlainByDistrictTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            $("#floodPlain-species-selection").change(function(){
                let selectedSpecies = $("#floodPlain-species-selection option:selected").val();
                let url = "{{ route('floodPlain-by-species',':species') }}"
                url = url.replace(':species',selectedSpecies);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    let xAxisValue= data.xAxisValue;
                    let yAxisValue = data.yAxisValue;
                    floodPlainSpeciesChart.destroy();
                    floodPlainBySpeciesTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            floodPlainByProductionTrend(xAxisValuesOfFloodPlainProduction,yAxisValuesOfFloodPlainProduction);
            floodPlainByDistrictTrend(xAxisValuesOfFloodPlainProduction,yAxisValuesOfFloodPlainProduction);
            floodPlainBySpeciesTrend(xAxisValuesOfFloodPlainBySpecies,yAxisValuesOfFloodPlainBySpecies);
        });
    </script>
@endsection
