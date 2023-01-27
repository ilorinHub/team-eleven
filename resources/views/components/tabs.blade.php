@props(['active', 'route'])
<div
  x-data="{
    activeTab: `{{ $active }}`,
    allowedRoute: `{{ $route }}`,
    tabHeadings: [],
    getTabName(tab) {
      return {
        name: eval(`(${tab.getAttribute('x-data')})`)['name'],
        icon: (tab.children[0].tagName === `TEMPLATE`) ? tab.children[0].innerHTML : null,
      }
    },
    isAllowedRoute() {
      const currentURL = (window.location.hash) ?
        window.location.href.split('#')[0] :
        window.location.href
      return this.allowedRoute == currentURL
    },
    loadTab(tab = null) {
      if (!this.isAllowedRoute()) return
      if (tab === null) {
          if (window.location.hash) {
            const hash = window.location.hash
            if (this.activeTab == hash) return
            this.activeTab = (hash.startsWith('#')) ? hash.substr(1): hash
          }
          return
      }
      if (this.activeTab == tab) return
      this.activeTab = tab
    }
  }"
  x-cloak
  x-init="async () => {
    await $nextTick()
    loadTab()
    const tabs = [...$refs.tabs.children]
    tabHeadings = tabs.map(tab => getTabName(tab))
    $watch('activeTab', () => window.location.hash = activeTab)
  }"
  @popstate.window="loadTab()"
>
  <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] min-h-screen">
    <div class="">
      <template x-for="(tab, index) in tabHeadings" :key="index">
        <button
          @click="loadTab(tab.name)"
          class="flex items-center justify-start w-full capitalize text-lg font-medium space-x-1 tracking-wide px-6 py-3 rounded-lg"
          :class="tab.name === activeTab ? `text-purple-600` : ``"
        >
          <span x-show="tab.icon" x-html="tab.icon" class="w-5 h-5 text-inherit"></span>
          <span x-text="(tab.name.startsWith('#')) ? tab.name.substr(1): tab.name"></span>
        </button>
      </template>
    </div>
    <div x-ref="tabs" class="">
      {{ $slot }}
    </div>
  </div>
</div>
