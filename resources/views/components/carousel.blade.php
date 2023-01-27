@props([
  'carousel_name',
  'type',
  'per_page',
  'per_move',
  'gap',
  'speed',
  'arrows',
  'autoplay',
])
  <div {{ $attributes->merge(['class' => '']) }}>
    {{ $heading ?? null }}
    <div class="{{ $carousel_name }} splide" role="group" style="padding: 0;">
      <div class="splide__track">
        <div class="splide__list grid grid-cols-[{{ $per_page }}] items-start">
          {{ $items }}
        </div>
      </div>
    </div>
  </div>
  <script type="module">
    new Splide( `.{{ $carousel_name }}`, {
      type: `{{ $type }}`,
      perPage: `{{ $per_page }}`,
      perMove: `{{ $per_move }}`,
      pagination: false,
      easing: 'cubic-bezier(.64,.54,0,1)',
      wheel: false,
      gap: `{{ $gap }}em`,
      speed: `{{ $speed }}`,
      autoplay: `{{ $autoplay }}`,
      interval: 2000,
      arrows: {{ $arrows }},
      breakpoints: {
        640: {
          perPage: 1,
        },
        768: {
          perPage: 2,
        },
        1024: {
          perPage: 2,
        },
        1280: {
          perPage: 2,
        },
      }
    }).mount()
  </script>

