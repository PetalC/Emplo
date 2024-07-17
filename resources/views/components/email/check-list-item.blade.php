@props([
    'icon' => 'zondicon-checkmark',
    'icon_color' => '#4d8c27',
])
<li style="margin-bottom: 5px;">
<x-icon style="background-color:#4d8c27; width:22px; height:22px; padding-top:3px; padding-bottom:3px; padding-left:6px; padding-right:6px; margin-right:5px; border-radius: 100%; display:inline-block; color: #FFF;" name="zondicon-checkmark"></x-icon>
<p style="display:inline; position:relative; top:-5px; font-size:16px; font-weight:600;">{{ $slot }}</p>
</li>
