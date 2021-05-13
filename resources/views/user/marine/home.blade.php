@extends('user.main-template')
@section('home')
    <div class="align-items-center">
        <h7 style="text-align: center">Total Production at a glance {{ $latestDatas['year'] }}</h7>
        <hr>
        @if(count($latestDatas)>0)
            <div class="row">
                @foreach($latestDatas as $key=>$latestData)
                    @if($key != 'year')
                        <div class="col" style="text-align: center">
                            <div class="rounded) bg-light">
                                <a href="#">{{ $key }}</a><br>
                                {{$latestData}}
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        @endif
    </div>
    @yield('industrial')
    @yield('artisanal')
@endsection

@section('javascript')
    @yield('industrial-javascript')
    @yield('artisanal-javascript')
@endsection
