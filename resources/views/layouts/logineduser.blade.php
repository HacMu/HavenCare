<style>
    #pro{
        text-decoration: none;
    }
    #pro:hover{
        color: #111;
    }
</style>
<div hidden>
    <x-app-layout>

    </x-app-layout>
</div>
<div class="ml-3 relative">
    <x-jet-dropdown align="right" width="48">
        <x-slot name="trigger">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <button
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                    <img class="h-8 w-8 rounded-full object-cover"
                        src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->name }}" />
                </button>
            @else
                <span class="inline-flex rounded-md">
                    <button type="button" style="font-size: 16px; color:white;background-color:#00a099;font-weight:normal"
                        class="inline-flex items-center px-3 py-2  border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition">

                        {{ Auth::user()->name }}

                        <svg class="ml-3 -mr-0.5 h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </span>
            @endif
        </x-slot>

        <x-slot name="content">
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('My Account') }}
            </div>


            @if(Auth::user()->user_type == '2')
            <x-jet-dropdown-link  id="pro" href="{{ route('admin.dashboard') }}">
                {{ __('Dashboard') }}
            </x-jet-dropdown-link>
            @elseif (Auth::user()->user_type == '0')
            <x-jet-dropdown-link  id="pro" href="{{ route('patient.profile') }}">
                {{ __('Profile') }}
            </x-jet-dropdown-link>
            @elseif (Auth::user()->user_type == '1')
            <x-jet-dropdown-link  id="pro" href="{{ route('doctor.profile') }}">
                {{ __('Profile') }}
            </x-jet-dropdown-link>
            @endif


            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                    {{ __('API Tokens') }}
                </x-jet-dropdown-link>
            @endif

            <div class="border-t border-gray-100"></div>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf

                <x-jet-dropdown-link  id="pro"  href="{{ route('logout') }}"
                    @click.prevent="$root.submit();">
                    {{ __('Log Out') }}
                </x-jet-dropdown-link>
            </form>
        </x-slot>
    </x-jet-dropdown>
</div>
