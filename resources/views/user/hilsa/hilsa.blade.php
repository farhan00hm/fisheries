@extends('user.hilsa.home')
@section('hilsa')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By District</h7>
            <hr>
            <select class="form-select" aria-label="Select Location" id="hilsa-location-selection" style="float: right">
                @foreach($locations as $location)

                    <option value="{{ $location }}">{{ $location }}</option>
                @endforeach
            </select>
            <canvas id="hilsa-district" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Hilsa trend for river</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="hilsa-river-selection" style="float: right">
                    @foreach($rivers as $river)
                        <option value="{{ $river }}">{{ $river }}</option>
                    @endforeach
                </select>
                <canvas id="hilsa-river" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('hilsa-javascript')
    <script>
        let colorArray = ["#4b77a9",
            "#5f255f",
            "#d21243",
            "#B27200",
            'Magenta']
        let hilsaByDistrictWiseChart;
        let hilsaByRiverWiseChart;

        function hilsaByDistrict(xAxisValues,yAxisValues){
            let hilsaByDistrictOptions = {
                type: 'line',
                data: {
                    labels: xAxisValues,

                    datasets: [

                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                reverse: false
                            }
                        }]
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            }

            let hilsaByDistrictCtx = document.getElementById('hilsa-district').getContext('2d');
            hilsaByDistrictWiseChart = new Chart(hilsaByDistrictCtx, hilsaByDistrictOptions);
            let yAxisValuesLength = Object.keys(yAxisValues).length;
            for (let i = 0; i < yAxisValuesLength; i++) {
                hilsaByDistrictWiseChart.data.datasets.push(
                    {
                        label: Object.keys(yAxisValues)[i],
                        data: yAxisValues[Object.keys(yAxisValues)[i]],
                        borderWidth: 2,
                        borderColor:colorArray[i],
                        backgroundColor: colorArray[i],
                        fill:false

                    },
                );
            }
            hilsaByDistrictWiseChart.update();
        }

        function hilsaByRiver(xAxisValues,yAxisValues){
            let options = {
                type: 'line',
                data: {
                    labels: xAxisValues,

                    datasets: [

                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                reverse: false
                            }
                        }]
                    },
                    plugins:{
                        datalabels: {
                            display:false
                        }
                    }
                }
            }

            let ctx = document.getElementById('hilsa-river').getContext('2d');
            hilsaByRiverWiseChart = new Chart(ctx, options);
            let yAxisValuesLength = Object.keys(yAxisValues).length;
            for (let i = 0; i < yAxisValuesLength; i++) {
                hilsaByRiverWiseChart.data.datasets.push(
                    {
                        label: Object.keys(yAxisValues)[i],
                        data: yAxisValues[Object.keys(yAxisValues)[i]],
                        borderWidth: 2,
                        borderColor:colorArray[i],
                        backgroundColor: colorArray[i],
                        fill:false

                    },
                );
            }
            hilsaByRiverWiseChart.update();
        }

        $(document).ready(function(){
            let xAxisValuesOfHilsaLocationWise = {!! json_encode($xAxisValuesOfHilsaLocationWise) !!};
            let yAxisValuesOfHilsaLocationWise = {!! json_encode($yAxisValuesOfHilsaLocationWise) !!};
            let xAxisValuesOfHilsaRiverWise = {!! json_encode($xAxisValuesOfHilsaRiverWise) !!};
            let yAxisValuesOfHilsaRiverWise = {!! json_encode($yAxisValuesOfHilsaRiverWise) !!};


            $("#hilsa-location-selection").change(function(){
                let selectedLocation = $("#hilsa-location-selection option:selected").val();
                let url = "{{ route('hilsa-by-district',':district') }}"
                url = url.replace(':district',selectedLocation);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    let xAxisValue= data.xAxisValuesOfHilsaLocationWise;
                    let yAxisValue = data.yAxisValuesOfHilsaLocationWise;
                    hilsaByDistrictWiseChart.destroy();
                    hilsaByDistrict(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            $("#hilsa-river-selection").change(function(){
                let selectedRiver = $("#hilsa-river-selection option:selected").val();
                let url = "{{ route('hilsa-by-river',':river') }}"
                url = url.replace(':river',selectedRiver);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    let xAxisValue= data.xAxisValuesOfHilsaRiverWise;
                    let yAxisValue = data.yAxisValuesOfHilsaRiverWise;
                    hilsaByRiverWiseChart.destroy();
                    hilsaByRiver(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            hilsaByDistrict(xAxisValuesOfHilsaLocationWise,yAxisValuesOfHilsaLocationWise);
            hilsaByRiver(xAxisValuesOfHilsaRiverWise,yAxisValuesOfHilsaRiverWise)
            // beelBySpeciesTrend(xAxisValuesOfBeelBySpecies,yAxisValuesOfBeelBySpecies);
        });
    </script>
@endsection
