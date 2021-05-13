@extends('user.capture.home')
@section('capture')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="beel-production" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Culture trend for beel By District</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="beel-location-selection" style="float: right">
                    <option disabled selected>Select a location</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}">{{ $district }}</option>
                    @endforeach
                </select>
                <canvas id="beel-by-district" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <select class="form-select" aria-label="Select Location" id="beel-species-selection" style="float: right">
                {{--                <option disabled selected>Select a species</option>--}}
                @foreach($species as $species)
                    <option value="{{ $species }}">{{ $species }}</option>
                @endforeach
            </select>
            <canvas id="beel-by-species" width="600"  height="600" style="max-height:600px;max-width:500px;align-items: center"></canvas>
        </div>
    </div>

@endsection

@section('capture-javascript')
    <script>
        let beelDistrictChart;
        let beelSpeciesChart;
        function beelByProductionTrend(xAxisValue,yAxisValue){
            new Chart(document.getElementById("beel-production"), {
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
                        text: 'beel Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }

        function beelByDistrictTrend(xAxisValue,yAxisValue){
            beelDistrictChart = new Chart(document.getElementById("beel-by-district"), {
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
                        text: 'beel Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }

        function beelBySpeciesTrend(xAxisValue,yAxisValue){
            beelSpeciesChart = new Chart(document.getElementById("beel-by-species"), {
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
                        text: 'beel Trend By Species'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
            // beelDistrictChart();
        }

        $(document).ready(function(){
            let xAxisValuesOfBeelProduction = {!! json_encode($xAxisValuesOfBeelProduction) !!};
            let yAxisValuesOfBeelProduction = {!! json_encode($yAxisValuesOfBeelProduction) !!};
            let xAxisValuesOfBeelBySpecies = {!! json_encode($xAxisValuesOfBeelBySpecies) !!};
            let yAxisValuesOfBeelBySpecies = {!! json_encode($yAxisValuesOfBeelBySpecies) !!};

            $("#beel-location-selection").change(function(){

                let selectedLocation = $("#beel-location-selection option:selected").val();
                let url = "{{ route('beel-by-location',':location') }}"
                url = url.replace(':location',selectedLocation);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    console.log(data)
                    let xAxisValue= data.xAxisValuesOfBeelProduction;
                    let yAxisValue = data.yAxisValuesOfBeelProduction;
                    beelDistrictChart.destroy();
                    beelByDistrictTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            $("#beel-species-selection").change(function(){
                let selectedSpecies = $("#beel-species-selection option:selected").val();
                let url = "{{ route('beel-by-species',':species') }}"
                url = url.replace(':species',selectedSpecies);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    let xAxisValue= data.xAxisValue;
                    let yAxisValue = data.yAxisValue;
                    beelSpeciesChart.destroy();
                    beelBySpeciesTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            beelByProductionTrend(xAxisValuesOfBeelProduction,yAxisValuesOfBeelProduction);
            beelByDistrictTrend(xAxisValuesOfBeelProduction,yAxisValuesOfBeelProduction);
            beelBySpeciesTrend(xAxisValuesOfBeelBySpecies,yAxisValuesOfBeelBySpecies);
        });
    </script>
@endsection
