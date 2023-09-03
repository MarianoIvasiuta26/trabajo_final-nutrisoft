<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" class="w-full max-w-lg mx-auto">
            @csrf
            {{--
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <x-label for="tipo_usuario" value="{{ __('Tipo de usuario:') }}" />
                    <div class="flex items-center space-x-2">
                        <x-input id="tipo_usuario_admin" type="radio" class="form-radio" name="tipo_usuario" value="Administrador" required/>
                        <x-label for="tipo_usuario_admin" value="{{ __('Administrador') }}" />
                    </div>
                    <div class="flex items-center space-x-2">
                        <x-input id="tipo_usuario_nutri" type="radio" class="form-radio" name="tipo_usuario" value="Nutricionista" required/>
                        <x-label for="tipo_usuario_nutri" value="{{ __('Nutricionista') }}" />
                    </div>
                    <div class="flex items-center space-x-2">
                        <x-input id="tipo_usuario_paciente" type="radio" class="form-radio" name="tipo_usuario" value="Paciente" required checked />
                        <x-label for="tipo_usuario_paciente" value="{{ __('Paciente') }}" />
                    </div>
                </div>
            </div>--}}

            <div class="mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="apellido" value="{{ __('Apellido') }}" />
                <x-input id="apellido" class="block mt-1 w-full" type="text" name="apellido" :value="old('apellido')" required autofocus autocomplete="apellido" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            </div>

            <div class="mt-4 flex items-center space-x-4">
                <div class="mt-2 w-1/2">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="mt-2 w-1/2">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('¿Ya está registrado?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
