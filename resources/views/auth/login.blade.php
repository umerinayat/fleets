


<x-guest-layout>
    <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <form class="flex flex-col overflow-y-auto md:flex-row" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="h-32 md:h-auto md:w-1/2">
                <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="{{ asset('assets/img/truck.jpg') }}" alt="Office" />
                <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="../assets/img/login-office-dark.jpeg" alt="Office" />
            </div>
            <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                <div class="w-full">
                    <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                        Login
                    </h1>
                    <label for="email" class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">{{__('Email')}}</span>
                        <input id="email" type="email" name="email" value="{{old('email')}}" required autofocus class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Enter your email address" />
                    </label>
                    <label for="password" class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">{{__('Password')}}</span>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="***************" type="Enter Password" />
                    </label>

                    <!-- You should use a button here, as the anchor is only used for the example  -->
                    <button class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" href="../index.html">
                        {{ __('Log in') }}
                    </button>

                    <p class="mt-2">
                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    </p>

                    <hr class="my-8" />

                    {{-- @if (Route::has('password.request'))
                    <p class="mt-4">
                        <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    </p>
                    @endif --}}
         
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>