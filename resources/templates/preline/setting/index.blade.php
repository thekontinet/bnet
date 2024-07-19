<x-tenant::layouts.app title="Settings">
    <section class="px-4">
        <div class="flex flex-col">
            <button class="inline-flex items-center gap-x-3.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white" data-hs-overlay="#profile-settings">
                <x-bx-user class="size-4"/>
                Profile
            </button>
            <button href="" class="inline-flex items-center gap-x-3.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white" data-hs-overlay="#password-settings">
                <x-bx-key class="size-4"/>
                Change Password
            </button>
            <button class="inline-flex items-center gap-x-3.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white" data-hs-overlay="#logout">
                <x-bx-log-out class="size-4"/>
                Logout
            </button>
        </div>
    </section>

    <section class="flex justify-center items-center gap-2 py-4">
        @foreach($socials as $name => $social)
            @if($social)
                <a href="{{$social}}" class="inline-flex items-center gap-x-3.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
                    <x-dynamic-component component="{{'bi-' . $name}}" class="size-4"/>
                    {{ucfirst($name)}}
                </a>
            @endif
        @endforeach
    </section>

    <section class="px-1 flex flex-col gap-8 text-sm items-center py-12 text-gray-500">
        <a href="#" class="font-medium text-red-600">Delete Account</a>
    </section>

    <!-- profit setting panel -->
    <x-template::overlays.drawer class="max-w-xl mx-auto min-h-svh" name="profile-settings" position="bottom" :active="$errors->profile->isNotEmpty()">
        <x-slot name="header">
            <h3 class="font-medium">Profile Setting</h3>
        </x-slot>
        @include('template::partials.profile-update-form')
    </x-template::overlays.drawer>

    <!-- password setting panel -->
    <x-template::overlays.drawer class="max-w-xl mx-auto min-h-svh" name="password-settings" position="bottom" :active="$errors->password->isNotEmpty()">
        <x-slot name="header">
            <h3 class="font-medium">Profile Setting</h3>
        </x-slot>
        @include('template::partials.password-update-form')
    </x-template::overlays.drawer>

    <!-- password setting panel -->
    <x-template::overlays.drawer class="max-w-xl mx-auto min-h-[40svh]" name="logout" position="bottom" :active="$errors->password->isNotEmpty()">
        <form action="{{route('tenant.logout')}}" method="post" class="max-w-sm mx-auto px-4">
            @csrf
            <p class="font-medium text-center mb-4">Are you sure you want to end the session ?</p>
            <div class="flex items-center justify-between gap-4">
                <x-tenant::primary-button class="w-full">Confirm</x-tenant::primary-button>
                <x-tenant::secondary-button type="button" class="w-full" data-hs-overlay="#logout">Cancel</x-tenant::secondary-button>
            </div>
        </form>
    </x-template::overlays.drawer>
</x-tenant::layouts.app>
