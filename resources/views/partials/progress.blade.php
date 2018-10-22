<div class="row">
    <div class="col-xs-12 progress-step-bar">
        <ul>
            @for ($i = 0; $i < count($steps); $i++)
                <li class="{{ $i==0?'first':'' }} {{ $i==$stepActive?'active':'' }} {{ $i<$stepActive?'processing':'' }} {{ ($i==count($steps)-1)?'last':'' }} step-{{ $i+1 }}"
                    @if ($i != count($steps)-1)
                    style="width: {{ round(97/(count($steps)-1), 2) }}%"
                        @endif
                >
                    <p>
                        <strong>{{ $steps[$i]['title'] }}</strong><br/>
                        <span>{{ $steps[$i]['text'] }}</span>
                    </p>
                    <span class="progress-bar-dot"></span> <span class="progress-bar-line"></span>
                </li>
            @endfor
        </ul>
    </div>
</div>