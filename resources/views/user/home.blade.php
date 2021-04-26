@extends('user.main-template')
@section('home')

    <div class="row">
        <div class="col-4" style="text-align: center; background-color: #0e90d2">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="oilChart" width="600" height="300" style="align-items: center"></canvas>
        </div>
        <div class="col-8">
            <h7 style="text-align: center">Total Production at a glance</h7>
            <hr>
            <canvas id="line-chart" width="600" height="300" style="align-items: center"></canvas>
        </div>
    </div>


    {{--    Second graph section--}}
    <div class="row" style="margin-top: 50px">
        <div class="col-6">
            <span>
                <h7>Capture trend by location</h7>
                <select class="form-select" aria-label="Select Location" style="float: right">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </span>
            <hr>
            <canvas id="by-river-location" height="400" style="align-items: center;width: 100%"></canvas>
        </div>
        <div class="col-6">
            <h7>capture trend by spices</h7>
            <hr>
            <canvas id="by-river-spices"  height="400" style="align-items: center;width: 100%"></canvas>
        </div>
    </div>
@endsection

{{--@section('javascript')--}}
{{--    --}}
{{--@endsection--}}

@section('javascript')
    var options = {
    type: 'line',
    data: {
    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
    datasets: [
    {
    label: '# of Votes',
    data: [12, 19, 3, 5, 2, 3],
    borderWidth: 2,
    borderColor: '#b71705',
    fill: false
    },
    {
    label: '# of Points',
    data: [7, 11, 5, 8, 3, 7],
    borderWidth: 1
    }
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

    var ctx = document.getElementById('line-chart').getContext('2d');
    new Chart(ctx, options);
@endsection
