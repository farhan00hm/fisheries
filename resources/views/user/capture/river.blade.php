@extends('user.capture.home')
@section('capture')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="river-production" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Culture trend for river By specie</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="river-species-selection" style="float: right">
                    @foreach($species as $specie)
                        <option value="{{ $specie }}">{{ $specie }}</option>
                    @endforeach
                </select>
                <canvas id="river-by-species" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('capture-javascript')
    <script>
        let colorArray = ["#4b77a9",
            "#5f255f",
            "#d21243",
            "#B27200",
            'Magenta']
        let riverByProductionWiseChart;
        let riverBySpeciesWiseChart;

        function riverByProduction(xAxisValues,yAxisValues){
            let riverByProductionOptions = {
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

            let riverByProductionCtx = document.getElementById('river-production').getContext('2d');
            riverByProductionWiseChart = new Chart(riverByProductionCtx, riverByProductionOptions);
            let yAxisValuesLength = Object.keys(yAxisValues).length;
            for (let i = 0; i < yAxisValuesLength; i++) {
                riverByProductionWiseChart.data.datasets.push(
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
            riverByProductionWiseChart.update();
        }

        function riverBySpecies(xAxisValues,yAxisValues){
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

            let ctx = document.getElementById('river-by-species').getContext('2d');
            riverBySpeciesWiseChart = new Chart(ctx, options);
            let yAxisValuesLength = Object.keys(yAxisValues).length;
            for (let i = 0; i < yAxisValuesLength; i++) {
                riverBySpeciesWiseChart.data.datasets.push(
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
            riverBySpeciesWiseChart.update();
        }

        $(document).ready(function(){
            let xAxisValuesOfRiverProductionWise = {!! json_encode($xAxisValuesOfRiverProductionWise) !!};
            let yAxisValuesOfRiverProductionWise = {!! json_encode($yAxisValuesOfRiverProductionWise) !!};
            let xAxisValuesOfRiverSpeciesWise = {!! json_encode($xAxisValuesOfRiverSpeciesWise) !!};
            let yAxisValuesOfRiverSpeciesWise = {!! json_encode($yAxisValuesOfRiverSpeciesWise) !!};

            {{--let xAxisValuesOfBeelBySpecies = {!! json_encode($xAxisValuesOfBeelBySpecies) !!};--}}
            {{--let yAxisValuesOfBeelBySpecies = {!! json_encode($yAxisValuesOfBeelBySpecies) !!};--}}
            {{--$("#beel-location-selection").change(function(){--}}

            {{--    let selectedLocation = $("#beel-location-selection option:selected").val();--}}
            {{--    let url = "{{ route('beel-by-location',':location') }}"--}}
            {{--    url = url.replace(':location',selectedLocation);--}}
            {{--    $.ajax({--}}
            {{--        url: url,--}}
            {{--        type: 'GET',--}}
            {{--    }).done(function (data) {--}}
            {{--        console.log(data)--}}
            {{--        let xAxisValue= data.xAxisValuesOfBeelProduction;--}}
            {{--        let yAxisValue = data.yAxisValuesOfBeelProduction;--}}
            {{--        beelDistrictChart.destroy();--}}
            {{--        beelByDistrictTrend(xAxisValue,yAxisValue);--}}
            {{--    }).fail(function (jqXHR, textStatus, errorThrown) {--}}
            {{--        console.log("fAILED")--}}
            {{--    });--}}
            {{--});--}}

            $("#river-species-selection").change(function(){
                let selectedSpecies = $("#river-species-selection option:selected").val();
                let url = "{{ route('river-by-species',':species') }}"
                url = url.replace(':species',selectedSpecies);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    let xAxisValue= data.xAxisValuesOfRiverSpeciesWise;
                    let yAxisValue = data.yAxisValuesOfRiverSpeciesWise;
                    riverBySpeciesWiseChart.destroy();
                    riverBySpecies(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            riverByProduction(xAxisValuesOfRiverProductionWise,yAxisValuesOfRiverProductionWise);
            riverBySpecies(xAxisValuesOfRiverSpeciesWise,yAxisValuesOfRiverSpeciesWise)
            // beelBySpeciesTrend(xAxisValuesOfBeelBySpecies,yAxisValuesOfBeelBySpecies);
        });
    </script>
@endsection
