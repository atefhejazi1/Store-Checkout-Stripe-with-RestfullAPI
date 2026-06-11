<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-semibold text-gray-800">Become a Vendor</h2>
        <p class="text-sm text-gray-500 mt-1">Create your store — approval takes up to 24 hours.</p>
    </div>

    <form method="POST" action="{{ route('vendor.register') }}" enctype="multipart/form-data">
        @csrf

        {{-- Account Details --}}
        <div class="mb-4">
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                          :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                          name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                          name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <hr class="my-6 border-gray-200">
        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-4">Store Details</p>

        <div class="mb-4">
            <x-input-label for="store_name" :value="__('Store Name')" />
            <x-text-input id="store_name" class="block mt-1 w-full" type="text" name="store_name"
                          :value="old('store_name')" required />
            <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="business_phone" :value="__('Business Phone')" />
            <x-text-input id="business_phone" class="block mt-1 w-full" type="text"
                          name="business_phone" :value="old('business_phone')" />
            <x-input-error :messages="$errors->get('business_phone')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="store_logo" :value="__('Store Logo (optional)')" />
            <input id="store_logo" name="store_logo" type="file" accept="image/*"
                   class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
            <x-input-error :messages="$errors->get('store_logo')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="text-sm text-gray-500 hover:text-gray-700 underline" href="{{ route('login') }}">
                Already have an account?
            </a>
            <x-primary-button>
                {{ __('Submit Application') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
