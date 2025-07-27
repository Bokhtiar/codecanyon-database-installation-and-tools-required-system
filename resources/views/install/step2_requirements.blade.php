<h3>Requirements Check</h3>
<ul>
@foreach($requirements as $key => $status)
    <li>{{ $key }} - {!! $status ? '✅' : '❌' !!}</li>
@endforeach
</ul>
<a href="/install/env">Next</a>
