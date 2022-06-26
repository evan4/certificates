<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 hidden"
                    id="alert-danger" role="alert">
                    <ul class="list-unstyled"></ul>
                </div>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 hidden"
                    id="alert-success" role="alert">
                    <p></p>
                </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <div>
                                <h2 class="text-3xl font-bold">My certificates</h2>
                                <p>To activate the certificate enter secret code</p>
                                <form id="cert-activate" class="mt-2">
                                @csrf
                                    <x-label for="cert-code" value="Certificate's secret code:" />
                                    <x-input id="cert-code" class="block mt-1 w-full" type="text" name="code" required/>
                                    <div class="flex items-center justify-end mt-4">
                                        <x-button type="submit" class="ml-3">
                                            {{ __('Activate') }}
                                        </x-button>
                                    </div>
                                </form>
                            </div>
                            <div>
                            @foreach($certificates as $certificate)
                            <div class="rounded overflow-hidden shadow-lg">
                                <div class="px-6 py-4">
                                    <div class="font-bold text-xl mb-2">Certificate #{{$certificate->id}}</div>
                                    <p>For {{$certificate->first_name}} {{$certificate->last_name}}</p>
                                    <p>Trees {{$certificate->tree_amount}}</p>
                                    <p>A Plan Standart</p>
                                    <p>The amount {{$certificate->amount}}</p>
                                    <p>
                                        <strong>Date: {{\Carbon\Carbon::parse($certificate->activate_at)->format('d.m.Y')}}</strong>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold">Present a certificate</h2>
                            <p>To give a certificate, fill in all details </p>
                            <form id="cert-create" class="mt-2">
                            @csrf
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <x-label for="firstname" value="Name:" />
                                        <x-input id="firstname" class="block mt-1 w-full" type="text" 
                                            name="first_name" />
                                    </div>
                                    <div>
                                        <x-label for="lastname" value="Last name:" />
                                        <x-input id="lastname" class="block mt-1 w-full" type="text" 
                                            name="last_name" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-6 mt-2">
                                    <div>
                                        <x-label for="email" value="Email:" />
                                        <x-input id="email" class="block mt-1 w-full" type="email" 
                                            name="email" />
                                    </div>
                                    <div>
                                        <x-label for="plantation-id" value="Plantation, year:" />
                                        <select name="plantation_id" id="plantation-id" 
                                            class="block appearance-none w-full bg-white border border-gray-400 mt-1 w-full">
                                        @foreach($plantations as $plantation)
                                            <option value="{{$plantation->id}}" data-price="{{$plantation->cost}}">{{$plantation->name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <x-label for="currency-id" value="Currency:" />
                                    <select name="currency_id" id="currency-id" 
                                    class="block appearance-none w-full bg-white border border-gray-400 mt-1 w-full">
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="mt-2">
                                    @foreach($paymentOptions as $paymentOption)
                                    <div class="form-check">
                                        <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white 
                                        checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top 
                                        bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                        type="radio" name="payment_option_id" id="paymentOption{{$paymentOption->id}}" 
                                        value="{{$paymentOption->id}}"
                                        @if ($loop->first) 
                                        checked 
                                        @endif>
                                        <label class="form-check-label inline-block text-gray-800" for="paymentOption{{$paymentOption->id}}">
                                            {{$paymentOption->name}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="grid grid-cols-2 gap-6 mt-2">
                                    <div class="grid  grid-cols-2">
                                        <div class="row-span-4">
                                            <x-label for="amount" value="Number of trees:" />
                                            <x-input id="amount" class="block w-full" type="number" name="amount" min="1" value="1"/>
                                        </div>
                                        <div class="row-span-2">
                                            <div class="flex mt-5" id="btn-group-amount">
                                                <div class="inline-flex shadow-md hover:shadow-lg focus:shadow-lg" role="group">
                                                    <button type="button" data-operation="minus"
                                                    class="inline-block px-3.5 py-3 bg-white-600 text-black font-medium text-xs leading-tight 
                                                    uppercase hover:bg-slate-700 focus:bg-slate-700 focus:outline-none focus:ring-0 active:bg-slate-800 
                                                    transition duration-150 ease-in-out">-</button>
                                                    <button type="button"  data-operation="plus"
                                                    class="inline-block px-3.5 py-3 bg-white-600 text-black font-medium text-xs leading-tight 
                                                    uppercase hover:bg-slate-700 focus:bg-slate-700 focus:outline-none focus:ring-0 active:bg-slate-800 
                                                    transition duration-150 ease-in-out">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div></div>
                                </div>
                                <div class="grid grid-cols-2 gap-6 mt-2">
                                    <h2 class="text-3xl font-bold">
                                        <span id="total"></span> 
                                    </h2>
                                    <div class="flex items-center justify-end mt-4">
                                        <x-button type="submit" class="ml-3">
                                            {{ __('Buy a tree now') }}
                                        </x-button>
                                    </div>
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
