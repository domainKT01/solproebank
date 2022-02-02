
{{--navigation menu--}}
<nav class="bg-gray-100">
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    
    <div class="relative flex items-center justify-between h-16">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                
        <!-- Start Mobile menu button-->
        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
          <span class="sr-only">Open main menu</span>

          <!-- Start  Icon when menu is closed. Heroicon name: outline/menu, Menu open: "hidden", Menu closed: "block"  -->
          <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <!-- End  Icon when menu is closed. Heroicon name: outline/menu, Menu open: "hidden", Menu closed: "block"  -->

          <!-- Start Icon when menu is open. Heroicon name: outline/x    Menu open: "block", Menu closed: "hidden"  -->
          <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
          <!-- End Icon when menu is open. Heroicon name: outline/menu, Menu open: "hidden", Menu closed: "block"  -->

        </button>
        <!-- End Mobile menu button-->

      </div>

      <div class="flex items-center justify-center sm:items-stretch sm:justify-start">

        <!-- Start of Logo-->
        <a href="/" class="flex-shrink-0 flex items-center ">
          <div class="logo p-2">
              <img class="block lg:hidden h-12 w-24 brand-image img-circle elevation-3" src="vendor/adminlte/dist/img/Solproe.png" width="100%" alt="Solproe.SAS">
              <img class="hidden lg:block h-12 w-24 brand-image img-circle elevation-3" src="vendor/adminlte/dist/img/Solproe.png" width="100%" alt="Solproe.SAS">
          </div>
          
        </a>
        <!-- End of Logo-->

        {{-- start main menu--}}
        <div class="hidden sm:block sm:ml-6">
          <div class="flex space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="#" class="text-gray-900 hover:bg-gray-300 hover:text-white px-3 py-2 rounded-md text-xl font-medium" aria-current="page">Dashboard</a>

            <a href="#" class="text-gray-900 hover:bg-gray-300 hover:text-white px-3 py-2 rounded-md text-xl font-medium">
              Donor recruitment</a>

            <a href="#" class="text-gray-900 hover:bg-gray-300 hover:text-white px-3 py-2 rounded-md text-xl font-medium">
              Production process</a>

            <a href="#" class="text-gray-900 hover:bg-gray-300 hover:text-white px-3 py-2 rounded-md text-xl font-medium">
              Distribution</a>
          </div>
        </div>
        {{--end main menu--}}
        
      </div>

      <!-- Start Authentication -->
     @auth       
     
      <div class="absolute inset-y-0 right-0 flex items-center >
        <button type="button" class="bg-gray-100 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
          <!--<span class="sr-only">Notifications</span>-->
          <!-- Heroicon name: outline/bell -->
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
        </button>

        <!-- Start Profile dropdown -->
        <div class="ml-3 relative" x-data="{open:false}">
          <div>
            <button x-on:click ="open = true" type="button" class="bg-gray-100 flex items-center rounded-full focus:outline-none focus:ring-4 focus:ring-offset-4 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <!--<span class="sr-only ">User menu</span>-->
              <img class="h-12 w-12 rounded-full " src= "{{auth()->user()->profile_photo_url}}" alt="">
            </button>
          </div>

          <!-- Start Authentication menu -->

          <div x-show="open" x-on:click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
            <!-- Active: "bg-gray-100", Not Active: "" -->
            <a href="{{route('profile.show')}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
            <a href="{{route('admin.home')}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Dashboar</a>
            <!--<a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>-->
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2" onclick="event.preventDefault();
              this.closest('form').submit();">Sign out</a>
            </form>
          </div>
          <!-- end Authentication menu -->

        </div>
        <!-- End Profile dropdown -->

      </div>

      @else 

        <div class="flex items-center justify-center sm:items-stretch sm:justify-start">
            
          <a href="{{route('login')}}" class="text-gray-900 hover:bg-gray-300 hover:text-white px-3 py-2 rounded-md text-xl text-right font-medium">
          Login</a>
          <a href="{{route('register')}}" class="text-gray-900 hover:bg-gray-300 hover:text-white px-3 py-2 rounded-md text-xl text-right font-medium">
          Register</a>

        </div>  
      @endauth
      <!-- end Authentication-->
    </div>

  </div>

  <!-- Mobile menu, show/hide based on menu state. -->
  <div class="sm:hidden" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
      <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium" aria-current="page">Dashboard</a>

      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Donor recruitment</a>

      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Production process</a>

      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Distribution</a>
    </div>
  </div>
</nav>
