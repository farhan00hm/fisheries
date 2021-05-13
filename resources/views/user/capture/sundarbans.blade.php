@extends('user.capture.home')
@section('capture')
    <div class="row" style="margin-top: 40px">
        <div class="col-6" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="sundarbans-production" width="600"  height="600" style="align-items: center"></canvas>
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
        let sundarbansByProductionWiseChart;

        function sundarbansByProduction(xAxisValues,yAxisValues){
            let sundarbansByProductionOptions = {
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

            let sundarbansByProductionCtx = document.getElementById('sundarbans-production').getContext('2d');
            sundarbansByProductionWiseChart = new Chart(sundarbansByProductionCtx, sundarbansByProductionOptions);
            let yAxisValuesLength = Object.keys(yAxisValues).length;
            for (let i = 0; i < yAxisValuesLength; i++) {
                sundarbansByProductionWiseChart.data.datasets.push(
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
            sundarbansByProductionWiseChart.update();
        }

        $(document).ready(function(){
            let xAxisValues = {!! json_encode($xAxisValues) !!};
            let yAxisValues = {!! json_encode($yAxisValues) !!};

            sundarbansByProduction(xAxisValues,yAxisValues);

        });
    </script>
@endsection
