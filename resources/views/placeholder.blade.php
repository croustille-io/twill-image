@php
$attributes = 'aria-hidden="true" data-placeholder-image';
@endphp
@if(isset($src) && !!$src)
  @include('image::picture', [
      'fallback' => $src,
      'alt' => "",
      'attributes' => $attributes,
      'sizes' => $sizes,
      'style' => $style,
  ])
@else
    <div style="{{$style}}" {!! $attributes !!}></div>
@endif
