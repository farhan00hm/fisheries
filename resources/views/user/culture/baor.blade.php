@extends('user.culture.home')
@section('baor')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="baor-production" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Culture trend for Baor By District</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="baor-location-selection" style="float: right">
                    <option disabled selected>Select a location</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}">{{ $district }}</option>
                    @endforeach
                </select>
                <canvas id="baor-by-district" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <select class="form-select" aria-label="Select Location" id="baor-species-selection" style="float: right">
{{--                <option disabled selected>Select a species</option>--}}
                @foreach($species as $species)
                    <option value="{{ $species }}">{{ $species }}</option>
                @endforeach
            </select>
            <canvas id="baor-by-species" width="600"  height="600" style="max-height:600px;max-width:500px;align-items: center"></canvas>
        </div>
    </div>
@endsection

@section('baor-javascript')
    <script>

        {{--let xAxisValuesOfBaorProduction = {!! json_encode($xAxisValuesOfBaorProduction) !!};--}}
        {{--let yAxisValuesOfBaorProduction = {!! json_encode($yAxisValuesOfBaorProduction) !!};--}}

        let baorDistrictChart;
        let baorSpeciesChart;
        function baorByProductionTrend(xAxisValue,yAxisValue){
            new Chart(document.getElementById("baor-production"), {
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
                        text: 'Culture Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }

        function baorByDistrictTrend(xAxisValue,yAxisValue){
            baorDistrictChart = new Chart(document.getElementById("baor-by-district"), {
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
                        text: 'Culture Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
            // baorDistrictChart();
        }
        function baorBySpeciesTrend(xAxisValue,yAxisValue){
            baorSpeciesChart = new Chart(document.getElementById("baor-by-species"), {
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
                        text: 'Baor Trend By Species'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
            // baorDistrictChart();
        }

        $(document).ready(function(){
            let xAxisValuesOfBaorProduction = {!! json_encode($xAxisValuesOfBaorProduction) !!};
            let yAxisValuesOfBaorProduction = {!! json_encode($yAxisValuesOfBaorProduction) !!};
            let xAxisValuesOfBaorBySpecies = {!! json_encode($xAxisValuesOfBaorBySpecies) !!};
            let yAxisValuesOfBaorBySpecies = {!! json_encode($yAxisValuesOfBaorBySpecies) !!};
            $("#baor-location-selection").change(function(){

                let selectedLocation = $("#baor-location-selection option:selected").val();
                let url = "{{ route('culture-by-location',':location') }}"
                url = url.replace(':location',selectedLocation);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    console.log(data)
                    let xAxisValue= data.xAxisValuesOfBaorProduction;
                    let yAxisValue = data.yAxisValuesOfBaorProduction;
                    baorDistrictChart.destroy();
                    baorByDistrictTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            $("#baor-species-selection").change(function(){
                let selectedSpecies = $("#baor-species-selection option:selected").val();
                let url = "{{ route('baor-by-species',':species') }}"
                url = url.replace(':species',selectedSpecies);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    let xAxisValue= data.xAxisValue;
                    let yAxisValue = data.yAxisValue;
                    baorSpeciesChart.destroy();
                    baorBySpeciesTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            baorByProductionTrend(xAxisValuesOfBaorProduction,yAxisValuesOfBaorProduction);
            baorByDistrictTrend(xAxisValuesOfBaorProduction,yAxisValuesOfBaorProduction);
            baorBySpeciesTrend(xAxisValuesOfBaorBySpecies,yAxisValuesOfBaorBySpecies);
        });
    </script>
@endsection
