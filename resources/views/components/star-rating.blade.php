@if($rating)
@for($i = 1; $i <= 5; $i++)
    @if($i <= $rating )
        <span class="text-yellow-400">★</span>
    @elseif($rating >= $i - 0.5)
        <span class="text-yellow-300">⯪</span>
    @else
        <span class="text-gray-300">☆</span>
    @endif
@endfor
@else

@endif
