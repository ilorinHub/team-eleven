<x-guest-layout>
  <div
    x-data="{
      products: [],
      pagination: {
        prev: null,
        next: null,
        page: null,
      },
      prepareResponse(responseObject) {
        const {products, links, meta} = responseObject
        this.products = products
        this.pagination.prev = links.prev
        this.pagination.next = links.next
        this.pagination.page = meta.from
      },
      async getPage(url = null) {
        if (url == null) return
        try {
          Nprogress.start()
          const response = await axios.get(url);
          this.prepareResponse(response.data)
          Nprogress.done()
        } catch(error) {
          Nprogress.done()
          console.log(error)
        }
      },
      async loadProducts() {
        const response = await axios.get('/products')
        this.prepareResponse(response.data)
      },
      async init() {
        await $nextTick();
        await this.loadProducts()
      }
    }"
    class="grid min-h-full px-4 py-4 sm:px-6 lg:px-8">
    <div class="hero max-w-7xl min-h-[55vh] mx-auto grid lg:grid-cols-2 gap-4 place-items-center">
      <div>
        <div>
          <h2 class="font-title font-bold text-5xl lg:text-6xl mb-1" style="line-height: 1.1">The Best Place To Source and Buy Garments</h2>
          <span class="text-gray-500 font-light text-xl">Affordable and Quality garments delivered in 3-5 days.</span>
          <span class="text-sm inline-block line-through">No more waiting for months</span>
        </div>
        <x-custom-button class="mt-5 text-2xl py-3">Shop Now</x-custom-button>

      </div>


    </div>
    <div class="max-w-7xl mx-auto">
      <div class="pagination">
        <div class="flex items-center font-light gap-2">
          <button
            @click="getPage(pagination.prev)"
            class="flex items-center"
            :class="{
              'text-gray-300 cursor-not-allowed' : !pagination.prev,
              'text-conpay-purple font-medium' : pagination.prev
            }"
          >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
            </svg>
            <span>prev</span>
          </button>
          <button
            @click="getPage(pagination.next)"
            class="flex items-center"
            :class="{
              'text-gray-300 cursor-not-allowed' : !pagination.next,
              'text-conpay-purple font-medium' : pagination.next
            }"
          >
            <span>next</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
            </svg>

          </button>
        </div>
      </div>
    </div>
    <div
      class="max-w-7xl mx-auto grid lg:grid-cols-4 lg:gap-10 my-24 w-full"
    >
      <template x-for="(product, index) in products" :key="product.sku">
        <div class="flex flex-col relative">
          <img :src="product.photo_url" :alt="product.name">
          <h4 x-text="product.name" class="text-lg font-light capitalize mb-1"></h4>
          <span class="flex text-lg gap-1 absolute top-2 left-2">
            <template x-for="category in product.categories" :key="category.slug">
              <a :href="`/category/${category.slug}`" class="text-sm px-2 bg-purple-100 rounded-lg" x-text="category.name"></a>
            </template>
          </span>
          <div class="flex justify-between">
            <span class="flex">
              <span class="text-xl">&#8358;</span>
              <span x-text="product.cost_per_unit" class="text-xl inline-block mr-1" ></span> /<span x-text="product.priceable_type"></span>
            </span>
            <span>
              <span class="text-xs">MIN</span>
              <span x-text="product.minimum"></span>

            </span>
          </div>
{{--           <x-custom-button class="flex py-2 justify-center items-center bg-orange-700 before:bg-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <span>Add to card</span>
          </x-custom-button> --}}

        </div>

      </template>

    </div>
    <div class="max-w-7xl mx-auto">
      <div class="pagination">
        <div class="flex items-center font-light gap-2">
          <button
            @click="getPage(pagination.prev)"
            class="flex items-center"
            :class="{
              'text-gray-300 cursor-not-allowed' : !pagination.prev,
              'text-conpay-purple font-medium' : pagination.prev
            }"
          >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
            </svg>
            <span>prev</span>
          </button>
          <button
            @click="getPage(pagination.next)"
            class="flex items-center"
            :class="{
              'text-gray-300 cursor-not-allowed' : !pagination.next,
              'text-conpay-purple font-medium' : pagination.next
            }"
          >
            <span>next</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
            </svg>

          </button>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
