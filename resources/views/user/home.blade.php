@extends('user.main-template')
@section('home')

    <div class="row">
        <div class="col-4" style="text-align: center;">
            <h7 style="text-align: center">Explore By Category</h7>
            <hr>
            <canvas id="at-a-glance-pie-chart" width="600"  height="600" style="align-items: center"></canvas>
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
                <select class="form-select" aria-label="Select Location" id="location-selection" style="float: right">
                    <option disabled selected>Select a location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location }}">{{ $location }}</option>
                    @endforeach
                </select>
            </span>
            <hr>
            <canvas id="capture-by-location"  style="align-items: center;width: 100%"></canvas>

        </div>
        <div class="col-6">
            <span>
                <h7>Capture trend by spices</h7>
                <select class="form-select" aria-label="Select Species" id="species-selection" style="float: right">
                    <option disabled selected>Select a spices</option>
                    @foreach($species as $specie)
                        <option value="{{ $specie }}">{{ $specie }}</option>
                    @endforeach
                </select>
            </span>
            <hr>
            <canvas id="capture-by-species" style="align-items: center;width: 100%"></canvas>
        </div>
    </div>
@endsection

