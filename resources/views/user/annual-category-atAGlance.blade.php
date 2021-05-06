<div class="align-items-center">
    <h7 style="text-align: center">Total Production at a glance [{{ $year }}]</h7>
    <hr>
    @if(count($atAGlanceByCategoryAndYear)>0)
        <div class="row">
            @foreach($atAGlanceByCategoryAndYear as $category=>$value)
                <div class="col">
                    {{ $category }}<br>
                    {{ $value }}
                </div>
            @endforeach
        </div>

    @endif
</div>
