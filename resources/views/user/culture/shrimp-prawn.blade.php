@extends('user.culture.home')
@section('culture')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="cage-production" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Culture trend for Cage By District</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="cage-location-selection" style="float: right">
                    <option disabled selected>Select a location</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}">{{ $district }}</option>
                    @endforeach
                </select>
                <canvas id="cage-by-district" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('culture-javascript')
    <script>


        let cageDistrictChart;
        function cageByProductionTrend(xAxisValue,yAxisValue){
            new Chart(document.getElementById("cage-production"), {
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

        function cageByDistrictTrend(xAxisValue,yAxisValue){
            cageDistrictChart = new Chart(document.getElementById("cage-by-district"), {
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
                        text: 'Cage Trend By Production'
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            });
        }



        $(document).ready(function(){
            let xAxisValuesOfCageProduction = {!! json_encode($xAxisValuesOfCageProduction) !!};
            let yAxisValuesOfCageProduction = {!! json_encode($yAxisValuesOfCageProduction) !!};

            $("#cage-location-selection").change(function(){

                let selectedLocation = $("#cage-location-selection option:selected").val();
                let url = "{{ route('cage-by-location',':location') }}"
                url = url.replace(':location',selectedLocation);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    console.log(data)
                    let xAxisValue= data.xAxisValuesOfCageProduction;
                    let yAxisValue = data.yAxisValuesOfCageProduction;
                    cageDistrictChart.destroy();
                    cageByDistrictTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            cageByProductionTrend(xAxisValuesOfCageProduction,yAxisValuesOfCageProduction);
            cageByDistrictTrend(xAxisValuesOfCageProduction,yAxisValuesOfCageProduction);
        });
    </script>
@endsection
