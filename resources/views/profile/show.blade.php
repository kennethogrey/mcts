@extends('dashboard.layout')
@section('title','Dashboard | Profile')
@section('content')
<x-app-layout>
    <div class="pcoded-inner-content"> 
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="card-block d-flex justify-content-end">
                <form method="POST" action="{{route('user.photo')}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Upload Profile-Photo</label>
                        <div class="col-sm-10">
                            <img id="blahss" alt="" width="100" height="100" />
                            <input class="form-control" id="image" type="file" name="image"
                            onchange="document.getElementById('blahss').src = window.URL.createObjectURL(this.files[0])" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Current Profile-Photo</label>
                        <div class="col-sm-10">
                            <!-- Current Profile Photo -->
                            <div class="mt-2" x-show="! photoPreview">
                                <img src="{{ asset('storage/profile_photo') }}/{{ auth()->user()->profile_photo_path }}" alt="{{ auth()->user()->name }}" class="rounded-full h-20 w-20 object-cover">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900"></i> Save Photo</button>
                </form>
            </div>

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
@endsection
