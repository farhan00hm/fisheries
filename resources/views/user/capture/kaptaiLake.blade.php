@extends('user.capture.home')
@section('capture')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="kaptaiLake-production" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Explore By Species</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="kaptaiLake-species-selection" style="float: right">
                    @foreach($species as $species)
                        <option value="{{ $species }}">{{ $species }}</option>
                    @endforeach
                </select>
                <canvas id="kaptaiLake-by-species" width="600"  height="600" style="max-height:600px;max-width:500px;align-items: center"></canvas>
            </div>
        </div>
    </div>

@endsection

@section('capture-javascript')
    <script>
        let kaptaiLakeSpeciesChart;
        function kaptaiLakeByProductionTrend(xAxisValue,yAxisValue){
            new Chart(document.getElementById("kaptaiLake-production"), {
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
                        text: 'kaptaiLake Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }


        function kaptaiLakeBySpeciesTrend(xAxisValue,yAxisValue){
            kaptaiLakeSpeciesChart = new Chart(document.getElementById("kaptaiLake-by-species"), {
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
                        text: 'kaptaiLake Trend By Species'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
            // kaptaiLakeDistrictChart();
        }

        $(document).ready(function(){
            let xAxisValuesOfKaptaiLakeProduction = {!! json_encode($xAxisValuesOfKaptaiLakeProduction) !!};
            let yAxisValuesOfKaptaiLakeProduction = {!! json_encode($yAxisValuesOfKaptaiLakeProduction) !!};
            let xAxisValuesOfkaptaiLakeBySpecies = {!! json_encode($xAxisValuesOfkaptaiLakeBySpecies) !!};
            let yAxisValuesOfkaptaiLakeBySpecies = {!! json_encode($yAxisValuesOfkaptaiLakeBySpecies) !!};


            $("#kaptaiLake-species-selection").change(function(){
                let selectedSpecies = $("#kaptaiLake-species-selection option:selected").val();
                let url = "{{ route('kaptai-lake-by-species',':species') }}"
                url = url.replace(':species',selectedSpecies);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    let xAxisValue= data.xAxisValue;
                    let yAxisValue = data.yAxisValue;
                    kaptaiLakeSpeciesChart.destroy();
                    kaptaiLakeBySpeciesTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            kaptaiLakeByProductionTrend(xAxisValuesOfKaptaiLakeProduction,yAxisValuesOfKaptaiLakeProduction);
            kaptaiLakeBySpeciesTrend(xAxisValuesOfkaptaiLakeBySpecies,yAxisValuesOfkaptaiLakeBySpecies);
        });
    </script>
@endsection
