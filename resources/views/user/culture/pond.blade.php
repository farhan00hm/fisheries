@extends('user.culture.home')
@section('culture')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="pond-production" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Culture trend for pond By District</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="pond-location-selection" style="float: right">
                    <option disabled selected>Select a location</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}">{{ $district }}</option>
                    @endforeach
                </select>
                <canvas id="pond-by-district" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <select class="form-select" aria-label="Select Location" id="pond-species-selection" style="float: right">
                {{--                <option disabled selected>Select a species</option>--}}
                @foreach($species as $species)
                    <option value="{{ $species }}">{{ $species }}</option>
                @endforeach
            </select>
            <canvas id="pond-by-species" width="600"  height="600" style="max-height:600px;max-width:500px;align-items: center"></canvas>
        </div>
    </div>
@endsection

@section('culture-javascript')
    <script>


        let pondDistrictChart;
        let pondSpeciesChart;
        function pondByProductionTrend(xAxisValue,yAxisValue){
            new Chart(document.getElementById("pond-production"), {
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
                        text: 'Pond Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }

        function pondByDistrictTrend(xAxisValue,yAxisValue){
            pondDistrictChart = new Chart(document.getElementById("pond-by-district"), {
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
                        text: 'pond Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }

        function pondBySpeciesTrend(xAxisValue,yAxisValue){
            pondSpeciesChart = new Chart(document.getElementById("pond-by-species"), {
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
                        text: 'pond Trend By Species'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
            // pondDistrictChart();
        }

        $(document).ready(function(){
            let xAxisValuesOfPondProduction = {!! json_encode($xAxisValuesOfPondProduction) !!};
            let yAxisValuesOfPondProduction = {!! json_encode($yAxisValuesOfPondProduction) !!};
            let xAxisValuesOfPondBySpecies = {!! json_encode($xAxisValuesOfPondBySpecies) !!};
            let yAxisValuesOfPondBySpecies = {!! json_encode($yAxisValuesOfPondBySpecies) !!};
            console.log(yAxisValuesOfPondBySpecies);

            $("#pond-location-selection").change(function(){

                let selectedLocation = $("#pond-location-selection option:selected").val();
                let url = "{{ route('pond-by-location',':location') }}"
                url = url.replace(':location',selectedLocation);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    console.log(data)
                    let xAxisValue= data.xAxisValuesOfPondProduction;
                    let yAxisValue = data.yAxisValuesOfPondProduction;
                    pondDistrictChart.destroy();
                    pondByDistrictTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            $("#pond-species-selection").change(function(){
                let selectedSpecies = $("#pond-species-selection option:selected").val();
                let url = "{{ route('pond-by-species',':species') }}"
                url = url.replace(':species',selectedSpecies);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    let xAxisValue= data.xAxisValue;
                    let yAxisValue = data.yAxisValue;
                    pondSpeciesChart.destroy();
                    pondBySpeciesTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            pondByProductionTrend(xAxisValuesOfPondProduction,yAxisValuesOfPondProduction);
            pondByDistrictTrend(xAxisValuesOfPondProduction,yAxisValuesOfPondProduction);
            pondBySpeciesTrend(xAxisValuesOfPondBySpecies,yAxisValuesOfPondBySpecies);
        });
    </script>
@endsection
