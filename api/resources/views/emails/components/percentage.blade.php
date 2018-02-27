@php
	$color = isset($color) && $color ? HelperMail::getColor($slot) : 'inherit';
@endphp
<span style="color: {{ $color }}">{{ HelperMail::percentage($slot) }}</span>