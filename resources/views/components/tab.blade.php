@props(['name'])
<div
  x-data="{
    name: '{{ $name }}',
    show: false,
  }"
  x-cloak
  x-show="activeTab == name"
>
  @if (isset($icon))
  <template class="hidden">
    {{ $icon }}
  </template>
  @endif
  {{ $slot }}
</div>
