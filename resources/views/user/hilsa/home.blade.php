@extends('user.main-template')
@section('home')
    <div class="align-items-center">
        <h7 style="text-align: center">Total Production at a glance {{ $latestYear }}</h7>
        <hr>
        @if(count($latestDatas)>0)
            <div class="row">
                @foreach($latestDatas as $key=>$latestData)
                    @if($key != 'year')
                        <div class="col" style="text-align: center">
                            <div class="rounded) bg-light">
                                {{--                            <a href="/culture/{{ $key }}" class="list-group-item {{ request()->is('culture') && $key=='home' ? 'active' : '' }}">{{ $key }}</a>--}}
                                <a href="{{ route($key) }}">{{ $key }}</a><br>
                                {{--                            {{ $key }}<br>--}}
                                {{$latestData}}
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        @endif
    </div>
    @yield('hilsa')
@endsection

@section('javascript')
    @yield('hilsa-javascript')
@endsection
