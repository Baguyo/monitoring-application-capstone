<td>
    @if ($record == '04:00:00')
        {{ 'Brownout' }}
    @elseif($record != null)
        {{ date('h:i:A', strtotime($record)) }}
    @else
    @endif
</td>
