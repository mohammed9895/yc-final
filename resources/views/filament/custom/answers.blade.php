<div>
    @foreach($record->answers as $answer)
        @foreach($answer as $q => $a)
            @if(is_array($a))
                @foreach($a as $answerss)
                    {{ $answerss }}
                @endforeach
            @else
                <div>
                    @if(str_contains($a, 'answers'))
                        {{$q}} : <a target="_blank" href="/storage/{{ $a }}" class="text-primary-600">Show File</a>
                    @elseif($a == 1)
                        {{$q}} : Yes
                    @elseif($a == 0)
                        {{$q}} : No
                    @else
                        {{$q}} : {{$a}}
                    @endif
                </div>
            @endif
        @endforeach
    @endforeach
</div>
