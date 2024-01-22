<div class="flex items-center justify-between">
    <div>
        <p class="text-xs">Welcome Back</p>
        <h4 class="font-medium">Hello, {{auth()->user()->fullname}}</h4>
    </div>
    <x-tenant::application-logo/>
</div>
