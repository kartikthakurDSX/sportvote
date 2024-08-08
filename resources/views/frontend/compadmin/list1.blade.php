@include('frontend.includes.header')
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <h2> Comp-Admin</h2>
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="/public/compadmin_store">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="profile_type" :value="__('Profile-Type')" />
                <select class="form-control" name="profile_type"  id="profile_type" class="block mt-1 w-full">
					   <option value="0" selected="selected">Profile-Type</option>
					   @foreach($uprofiletype as $upt)
					   <option value="{{$upt->id}}">{{$upt->name}}</option>
					   @endforeach
					</select>
            </div>

           <div>
                <x-label for="player" :value="__('Fav Player')" />
                <select class="form-control" name="fav_player[]"  id="fav_player" multiple class="block mt-1 w-full">
					   <option value="0" selected="selected">Select Fav Player</option>
					   @foreach($fv_player as $ufp)
					   <option value="{{$ufp->id}}">{{$ufp->first_name}}</option>
					   @endforeach
					</select>
            </div>
            <div>
                <x-label for="team" :value="__('Fav Team')" />
                <select class="form-control" name="fav_team[]"  id="fav_team" multiple class="block mt-1 w-full">
					   <option value="0" selected="selected">Select Fav Team</option>
					   @foreach($teams as $ft)
					   <option value="{{$ft->id}}">{{$ft->name}}</option>
					   @endforeach
					</select>
            </div>
             <div>
                <x-label for="comp" :value="__('Fav Competition')" />
                <select class="form-control" name="fav_comp[]"  id="fav_comp" multiple class="block mt-1 w-full">
					   <option value="0" selected="selected">Select Fav Comp</option>
					   @foreach($competitions as $ufc)
					   <option value="{{$ufc->id}}">{{$ufc->name}}</option>
					   @endforeach
					</select>
            </div>
              <div>
                <x-label for="friend" :value="__('Add Friends')" />
                <select class="form-control" name="friend[]"  id="friend" multiple class="block mt-1 w-full">
                       <option value="0" selected="selected">Add friend</option>
                       @foreach($fv_player as $uf)
                       <option value="{{$uf->id}}">{{$uf->first_name}}</option>
                       @endforeach
                    </select>
            </div>
            <div>
                <x-label for="player" :value="__('Add as Follow Player')" />
                <select class="form-control" name="player[]"  id="player" multiple class="block mt-1 w-full">
                       <option value="0" selected="selected">Follow Player</option>
                       @foreach($fv_player as $ufp)
                       <option value="{{$ufp->id}}">{{$ufp->first_name}}</option>
                       @endforeach
                    </select>
            </div>
              <!-- {{-- add as follow team --}} -->
              <div>
                <x-label for="team" :value="__('Add as Follow Team')" />
                <select class="form-control" name="team[]"  id="team" multiple class="block mt-1 w-full">
                       <option value="0" selected="selected">Add as Follow Team</option>
                       @foreach($teams as $upt)
                       <option value="{{$upt->id}}">{{$upt->name}}</option>
                       @endforeach
                    </select>
            </div>

            <!-- {{-- add as follow compt --}} -->
            <div>
                <x-label for="comp" :value="__('Add as Follow Comp')" />
                <select class="form-control" name="comp[]"  id="comp" multiple class="block mt-1 w-full">
                       <option value="0" selected="selected">Add as Follow Comp</option>
                       @foreach($competitions as $uflc)
                       <option value="{{$uflc->id}}">{{$uflc->name}}</option>
                       @endforeach
                    </select>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-4">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
@include('frontend.includes.footer')