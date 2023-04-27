@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="http://eurekacyberspace.com.ng/Assets/img/eureka%20logo.png" class="logo" alt="Website Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
