@include('frontend.includes.header')
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <!--a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a-->
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="first_name" :value="__('First-Name')" />

                <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
            </div>
            {{-- lastname --}}
            <div>
                <x-label for="last_name" :value="__('Last-Name')" />

                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
            </div>
            {{-- phone number --}}
             <div>
                <x-label for="phonenumber" :value="__('Contact-Number')" />

                <x-input id="phonenumber" class="block mt-1 w-full" type="text" name="phonenumber" :value="old('phonenumber')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>
             <div>
                <x-label for="nationality" :value="__('Nationality')" />
                <select class="form-control" name="nationality"  id="nationality" class="block mt-1 w-full">
					   <option value="" selected="selected">Select Nationality</option>
					   @foreach($countries as $c)
					   <option value="{{$c->name}}">{{$c->name}}</option>
					   @endforeach
					</select>

                {{-- <x-input id="nationality" class="block mt-1 w-full" type="text" name="nationality" :value="old('nationality')" required autofocus /> --}}
            </div>
            <!--  <div>
                <x-label for="profile_type" :value="__('Profile-Type')" />
                <select class="form-control" name="profile_type"  id="profile_type" class="block mt-1 w-full">
					   <option value="" selected="selected">Select Profile</option>
					   @foreach($profiletype as $p)
					   <option value="{{$p->id}}">{{$p->name}}</option>
					   @endforeach
					</select>
            </div> -->
            <div>
                <x-label for="height" :value="__('Height')" />

                <x-input id="height" class="block mt-1 w-full" type="text" name="height" :value="old('height')" required autofocus />
            </div>
            <div>
                <x-label for="dob" :value="__('Date of Birth')" />

                <x-input id="date" class="block mt-1 w-full" type="date" name="dob" :value="old('datetime')" required autofocus />
            </div>
             <div>
                <x-label for="weight" :value="__('Weight')" />

                <x-input id="weight" class="block mt-1 w-full" type="text" name="weight" :value="old('weight')" required autofocus />
            </div>
             <div>
                <x-label for="bio" :value="__('Bio')" />

                <x-input id="bio" class="block mt-1 w-full" type="text" name="bio" :value="old('bio')" required autofocus />
            </div>
             <div>
                <x-label for="location" :value="__('Location')" />

                <x-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required autofocus />
            </div>
            <input type="hidden" name="role_id" value="user">

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
@include('frontend.includes.footer')