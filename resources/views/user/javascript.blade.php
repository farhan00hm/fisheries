<script>
    // let colorArray = ['red','green','blue','orange','Magenta']
    let colorArray = ["#4b77a9",
        "#5f255f",
        "#d21243",
        "#B27200",
        'Magenta']

    let atAGlanceoptions = {
        type: 'line',
        data: {
            labels: {!! json_encode($totalProduction) !!},

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
            }
        }
    }

    let ctx = document.getElementById('line-chart').getContext('2d');
    let chart = new Chart(ctx, atAGlanceoptions);

    let yAxisValue = {!! json_encode($yAxisValues) !!};
    let objectLength = Object.keys(yAxisValue).length;
    for (let i = 0; i < objectLength; i++) {
        chart.data.datasets.push(
            {
                label: Object.keys(yAxisValue)[i],
                data: yAxisValue[Object.keys(yAxisValue)[i]],
                borderWidth: 2,
                borderColor:colorArray[i],
                backgroundColor: colorArray[i],
                fill: false

            },
        );
    }
    chart.update();



    //Graph for Capture Location wise
    let captureLocationWiseChart;
    let captureSpeciesWiseChart;
    let pieChart;
    let canvas = document.getElementById("at-a-glance-pie-chart");
    function atAGlancePieChart(values){
        let labels = Object.keys(values);
        let data = Object.values(values)
        console.log(data)
        data.splice(0,2)
        labels.splice(0,2);
        console.log(labels)
        let atAGlancePieChartOptions = {
            type: 'pie',
            // labels: ["capture", "culture", "marine", "hilsa", "shrimp/Prawn"],
            data: {
                labels: labels,
                datasets:[
                    {
                        label: "capture",
                        data:data,
                        backgroundColor:colorArray,
                    }
                ],
            },
            options: {
                legend: {
                    display: true,
                    labels:{
                        fontColor: 'black'
                    },
                },
                tooltips: {
                    enabled: false
                },
                plugins: {
                    datalabels: {
                        display: true,
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
                            dataArr.map(data => {
                                sum += data;
                            });
                            let percentage = (value*100 / sum).toFixed(2)+"%";
                            return percentage;
                        },
                        color: 'white',
                        font: {
                            size: 12,
                            weight: 'bold',
                        }
                    },
                },
            }
        }

        let ctx = document.getElementById('at-a-glance-pie-chart').getContext('2d');
        pieChart = new Chart(ctx, atAGlancePieChartOptions);

        pieChart.update();

    }
    function captureByLocation(xAxisValueOfCaptureLocationWise,yAxisValuesOfCaptureLocationWise){
        let captureByLocationOptions = {
            type: 'line',
            data: {
                labels: xAxisValueOfCaptureLocationWise,

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

        let captureByCtx = document.getElementById('capture-by-location').getContext('2d');
        captureLocationWiseChart = new Chart(captureByCtx, captureByLocationOptions);

        // let yAxisValuesOfCaptureLocationWise = yAxisValuesOfCaptureLocationWise;
        let yAxisValuesOfCaptureLocationWiseLength = Object.keys(yAxisValuesOfCaptureLocationWise).length;
        for (let i = 0; i < yAxisValuesOfCaptureLocationWiseLength; i++) {
            captureLocationWiseChart.data.datasets.push(
                {
                    label: Object.keys(yAxisValuesOfCaptureLocationWise)[i],
                    data: yAxisValuesOfCaptureLocationWise[Object.keys(yAxisValuesOfCaptureLocationWise)[i]],
                    borderWidth: 2,
                    borderColor:colorArray[i],
                    backgroundColor: colorArray[i],
                    fill: false,

                },
            );
        }

        captureLocationWiseChart.update();
    }

    function captureBySpecies(xAxisValueOfCaptureSpeciesWise,yAxisValuesOfCaptureSpeciesWise){
        let captureBySpeciesOptions = {
            type: 'line',
            data: {
                labels: xAxisValueOfCaptureSpeciesWise,

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

        let captureBySpeciesCtx = document.getElementById('capture-by-species').getContext('2d');
        captureBySpeciesWiseChart = new Chart(captureBySpeciesCtx, captureBySpeciesOptions);

        // let yAxisValuesOfCaptureLocationWise = yAxisValuesOfCaptureLocationWise;
        let yAxisValuesOfCaptureSpeciesWiseLength = Object.keys(yAxisValuesOfCaptureSpeciesWise).length;
        for (let i = 0; i < yAxisValuesOfCaptureSpeciesWiseLength; i++) {
            captureBySpeciesWiseChart.data.datasets.push(
                {
                    label: Object.keys(yAxisValuesOfCaptureSpeciesWise)[i],
                    data: yAxisValuesOfCaptureSpeciesWise[Object.keys(yAxisValuesOfCaptureSpeciesWise)[i]],
                    borderWidth: 2,
                    borderColor:colorArray[i],
                    backgroundColor: colorArray[i],
                    fill:false

                },
            );
        }

        captureBySpeciesWiseChart.update();
    }

    $(document).ready(function(){
        let valuesOfPieChart = {!! json_encode($valuesOfPieChart) !!};
        console.log(valuesOfPieChart)

        let xAxisValueOfCaptureLocationWise = {!! json_encode($xAxisValueOfCaptureLocationWise) !!};
        let yAxisValuesOfCaptureLocationWise = {!! json_encode($yAxisValuesOfCaptureLocationWise) !!};

        let xAxisValueOfCaptureSpeciesWise = {!! json_encode($xAxisValueOfCaptureSpeciesWise) !!};
        let yAxisValuesOfCaptureSpeciesWise = {!! json_encode($yAxisValuesOfCaptureSpeciesWise) !!};
        console.log(yAxisValuesOfCaptureSpeciesWise)

        $("#location-selection").change(function(){
            let selectedLocation = $("#location-selection option:selected").val();
            var APP_URL = $('meta[name="_base_url"]').attr('content');
            {{--let url ={{ route('capture-by-location', ['location' => 'dhaka']) }};--}}
            let url = "{{ route('capture-by-location',':location') }}"
            url = url.replace(':location',selectedLocation);
            $.ajax({
                url: url,
                type: 'GET',
            }).done(function (data) {
                console.log(data)
                let xAxisValueOfCaptureLocationWise= data.xAxisValueOfCaptureLocationWise;
                let yAxisValuesOfCaptureLocationWise = data.yAxisValuesOfCaptureLocationWise;
                console.log(data.yAxisValuesOfCaptureLocationWise);
                captureLocationWiseChart.destroy();
                captureByLocation(xAxisValueOfCaptureLocationWise,yAxisValuesOfCaptureLocationWise)
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("fAILED")
                // toastr.error("failed to load data");
            });
        });

        $("#species-selection").change(function (){
            let selectedSpecies = $("#species-selection option:selected").val();
            console.log(selectedSpecies);
            var APP_URL = $('meta[name="_base_url"]').attr('content');
            {{--let url ={{ route('capture-by-location', ['location' => 'dhaka']) }};--}}
            let url = "{{ route('capture-by-species',':species') }}"
            url = url.replace(':species',selectedSpecies);
            $.ajax({
                url: url,
                type: 'GET',
            }).done(function (data) {
                console.log(data)
                let xAxisValueOfCaptureSpeciesWise= data.xAxisValueOfCaptureSpeciesWise;
                let yAxisValuesOfCaptureSpeciesWise = data.yAxisValuesOfCaptureSpeciesWise;
                // console.log(data);
                captureBySpeciesWiseChart.destroy();
                captureBySpecies(xAxisValueOfCaptureSpeciesWise,yAxisValuesOfCaptureSpeciesWise)
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("fAILED")
                // toastr.error("failed to load data");
            });
        });


        atAGlancePieChart(valuesOfPieChart);
        captureByLocation(xAxisValueOfCaptureLocationWise,yAxisValuesOfCaptureLocationWise)
        captureBySpecies(xAxisValueOfCaptureSpeciesWise,yAxisValuesOfCaptureSpeciesWise)

        canvas.onclick = function(evt) {
            console.log("Ok")
            var activePoints = pieChart.getElementsAtEvent(evt);
            if (activePoints[0]) {
                let chartData = activePoints[0]['_chart'].config.data;
                let idx = activePoints[0]['_index'];
                let label = chartData.labels[idx];
                let url = "{{ route('at-a-glance-by-category-and-year',':category') }}"
                url = url.replace(':category',label)
                $.ajax({
                    url: url,
                    type: 'GET',
                }).done(function (data) {
                    $('#at-a-glance-chart').empty()
                    $('#explore-by-category-at-a-glance').html(data)
                    // captureBySpecies(xAxisValueOfCaptureSpeciesWise,yAxisValuesOfCaptureSpeciesWise)
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("fAILED")
                    // toastr.error("failed to load data");
                });
            }
        };
    });




</script>
