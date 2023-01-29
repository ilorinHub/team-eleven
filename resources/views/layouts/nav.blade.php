<header
    x-ref="nav"
    class="sticky top-0 z-40">
    <nav class="bg-sky-50">
        <!-- Primary Navigation Menu -->
        <div class="flex justify-between items-center max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <div>
                <a href="{{ route('home') }}">
                  <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                </a>
            </div>
            <div class="hidden lg:flex items-center space-x-10 font-medium text-lg">
{{--                 <a
                    href="{{ route('home') }}"
                    class="py-2 {{ request()->routeIs('home') ? 'text-indigo-500' : '' }}"
                    title="home"
                >
                  Home
                </a> --}}

                <a
                    href="#"
                    class="py-2"
                    title="About"
                >
                  About
                </a>

                <a
                    href="#"
                    class="py-2"
                    title="Pricing"
                >
                  Pricing
                </a>

                <a
                    href="#"
                    class="py-2"
                    title="Shipping"
                >
                  Shipping
                </a>

                <a
                    href="#"
                    class="py-2"
                    title="Contact"
                >
                  Contact
                </a>

                <a
                    href="{{ route('login') }}"
                    class="py-2 {{ request()->routeIs('login') ? 'text-indigo-500' : '' }}"
                    title="sign in"
                >
                  Sign In
                </a>

                <a
                    href="{{ route('register') }}"
                    class="py-2 bg-gray-700 text-gray-50 rounded-lg px-8"
                    title="sign up"
                >
                  Sign Up
                </a>
            </div>
            <button @click="open = !open" class="lg:hidden">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" x-bind:class="!open ? 'block' : 'hidden'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" x-bind:class="!open ? 'hidden' : 'block'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
        </div>
    </nav>
    <div x-show="open" @click.outside="open = false">
        <!-- Mobile Navigation Menu -->
        <div class="lg:hidden grid grid-cols-1 px-4 md:px-2 space-y-2 pb-4 absolute w-full  bg-sky-50 font-medium text-xl">
            <a
                href="#"
                class="py-3"
                title="services"
            >
              About
            </a>

            <a
                href="#"
                class="py-3"
                title="Pricing"
            >
              Pricing
            </a>

            <a
                href="#"
                class="py-3"
                title="Shipping"
            >
              Shipping
            </a>

            <a
                href="#"
                class="py-3"
                title="Contact"
            >
              Contact
            </a>

            <a
                href="{{ route('login') }}"
                class="py-3 {{ request()->routeIs('login') ? 'text-indigo-500' : '' }}"
                title="sign in"
            >
              Sign In
            </a>

            <a
                href="{{ route('register') }}"
                class="py-3 bg-indigo-600 rounded-lg text-indigo-50 pl-4 text-center"
                title="sign up"
            >
              Sign Up
            </a>
        </div>
    </div>

</header>
