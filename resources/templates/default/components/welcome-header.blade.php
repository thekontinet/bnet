<div class="flex flex-col gap-4">
    <x-tenant::application-logo class="size-8 rounded-full"/>
    <div>
        <p class="text-xs">Welcome Back</p>
        <h4 class="font-medium">Hello, {{auth()->user()->fullname}}</h4>
    </div>
</div>
