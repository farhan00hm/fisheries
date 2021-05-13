@extends('user.marine.home')
@section('industrial')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="pen-production" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Culture trend for pen By District</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="pen-location-selection" style="float: right">
                    <option disabled selected>Select a location</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}">{{ $district }}</option>
                    @endforeach
                </select>
                <canvas id="pen-by-district" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('culture-javascript')
    <script>


        let penDistrictChart;
        function penByProductionTrend(xAxisValue,yAxisValue){
            new Chart(document.getElementById("pen-production"), {
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

        function penByDistrictTrend(xAxisValue,yAxisValue){
            penDistrictChart = new Chart(document.getElementById("pen-by-district"), {
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
                        text: 'pen Trend By Production'
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
            let xAxisValuesOfPenProduction = {!! json_encode($xAxisValuesOfPenProduction) !!};
            let yAxisValuesOfPenProduction = {!! json_encode($yAxisValuesOfPenProduction) !!};
            console.log("OK");

            $("#pen-location-selection").change(function(){

                let selectedLocation = $("#pen-location-selection option:selected").val();
                let url = "{{ route('pen-by-location',':location') }}"
                url = url.replace(':location',selectedLocation);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    console.log(data)
                    let xAxisValue= data.xAxisValuesOfPenProduction;
                    let yAxisValue = data.yAxisValuesOfPenProduction;
                    penDistrictChart.destroy();
                    penByDistrictTrend(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            penByProductionTrend(xAxisValuesOfPenProduction,yAxisValuesOfPenProduction);
            penByDistrictTrend(xAxisValuesOfPenProduction,yAxisValuesOfPenProduction);
        });
    </script>
@endsection
