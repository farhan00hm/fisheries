@extends('user.shrimp.home')
@section('shrimp')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="shrimp-production" width="600"  height="600" style="align-items: center"></canvas>
        </div>
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Culture trend for shrimp By sector</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="shrimp-sectors-selection" style="float: right">
                    @foreach($sectors as $sector)
                        <option value="{{ $sector }}">{{ $sector }}</option>
                    @endforeach
                </select>
                <canvas id="shrimp-by-sector" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 40px">
        <div class="col-6">
            <div id="explore-by-category-at-a-glance"></div>
            <div id="at-a-glance-chart">
                <h7 style="text-align: center">Culture trend for shrimp By specie</h7>
                <hr>
                <select class="form-select" aria-label="Select Location" id="shrimp-species-selection" style="float: right">
                    @foreach($species as $specie)
                        <option value="{{ $specie }}">{{ $specie }}</option>
                    @endforeach
                </select>
                <canvas id="shrimp-by-species" width="600" height="600" style="align-items: center"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('shrimp-javascript')
    <script>
        let colorArray = [
            "#4b77a9",
            "#5f255f",
            "#d21243",
            "#B27200",
            'Magenta',
            "#008B00",
            "#050505",
            "#42426F",
            "#4B0082",
            "#B0171F",
            "#660000",
        ]
        let shrimpByProductionWiseChart;
        let shrimpBySectorWiseChart;
        let shrimpBySpeciesWiseChart;

        function shrimpByProduction(xAxisValues,yAxisValues){
            let shrimpByProductionOptions = {
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

            let shrimpByProductionCtx = document.getElementById('shrimp-production').getContext('2d');
            shrimpByProductionWiseChart = new Chart(shrimpByProductionCtx, shrimpByProductionOptions);
            let yAxisValuesLength = Object.keys(yAxisValues).length;
            for (let i = 0; i < yAxisValuesLength; i++) {
                shrimpByProductionWiseChart.data.datasets.push(
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
            shrimpByProductionWiseChart.update();
        }

        function shrimpBySector(xAxisValues,yAxisValues){
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

            let ctx = document.getElementById('shrimp-by-sector').getContext('2d');
            shrimpBySectorWiseChart = new Chart(ctx, options);
            let yAxisValuesLength = Object.keys(yAxisValues).length;
            for (let i = 0; i < yAxisValuesLength; i++) {
                shrimpBySectorWiseChart.data.datasets.push(
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
            shrimpBySectorWiseChart.update();
        }

        function shrimpBySpecies(xAxisValues,yAxisValues){
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

            let ctx = document.getElementById('shrimp-by-species').getContext('2d');
            shrimpBySpeciesWiseChart = new Chart(ctx, options);
            let yAxisValuesLength = Object.keys(yAxisValues).length;
            for (let i = 0; i < yAxisValuesLength; i++) {
                shrimpBySpeciesWiseChart.data.datasets.push(
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
            shrimpBySpeciesWiseChart.update();
        }

        $(document).ready(function(){
            let xAxisValuesOfShrimpProductionWise = {!! json_encode($xAxisValuesOfshrimpProductionWise) !!};
            let yAxisValuesOfShrimpProductionWise = {!! json_encode($yAxisValuesOfshrimpProductionWise) !!};
            let xAxisValuesOfShrimpSectorWise = {!! json_encode($xAxisValuesOfShrimpSectorWise) !!};
            let yAxisValuesOfShrimpSectorsWise = {!! json_encode($yAxisValuesOfShrimpSectorWise) !!};
            let xAxisValuesOfShrimpSpeciesWise = {!! json_encode($xAxisValuesOfShrimpSpeciesWise) !!};
            let yAxisValuesOfShrimpSpeciesWise = {!! json_encode($yAxisValuesOfShrimpSpeciesWise) !!};


            $("#shrimp-sectors-selection").change(function(){
                let selectedSector = $("#shrimp-sectors-selection option:selected").val();
                let url = "{{ route('shrimp-by-sector',':sector') }}"
                url = url.replace(':sector',selectedSector);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    console.log(data)
                    let xAxisValue= data.xAxisValuesOfShrimpSectorWise;
                    let yAxisValue = data.yAxisValuesOfShrimpSectorWise;
                    shrimpBySectorWiseChart.destroy();
                    shrimpBySector(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            $("#shrimp-species-selection").change(function(){
                let selectedSpecies = $("#shrimp-species-selection option:selected").val();
                let url = "{{ route('shrimp-by-species',':species') }}"
                url = url.replace(':species',selectedSpecies);
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    console.log(data)
                    let xAxisValue= data.xAxisValuesOfShrimpSpeciesWise;
                    let yAxisValue = data.yAxisValuesOfShrimpSpeciesWise;
                    shrimpBySpeciesWiseChart.destroy();
                    shrimpBySpecies(xAxisValue,yAxisValue);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                });
            });

            shrimpByProduction(xAxisValuesOfShrimpProductionWise,yAxisValuesOfShrimpProductionWise);
            shrimpBySector(xAxisValuesOfShrimpSectorWise,yAxisValuesOfShrimpSectorsWise);
            shrimpBySpecies(xAxisValuesOfShrimpSpeciesWise,yAxisValuesOfShrimpSpeciesWise)

        });
    </script>
@endsection
