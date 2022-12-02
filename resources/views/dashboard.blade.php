<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <div class="pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('paypal.bill') }}" method='POST'>
                        {{ csrf_field() }}
                        <x-text-input id="payment" class="" type="number" name="payment" :value="old('payment')" required autofocus />
                        <x-primary-button class="ml-3">
                            {{ __('Pay now with PayPal') }}
                        </x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
