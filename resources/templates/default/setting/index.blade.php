<x-tenant::layouts.app>
    <x-tenant::appbar title="Settings"/>

    <section class="p-4">
        <header class="mb-4">
            <h4 class="font-medium">Manage Account</h4>
            <p class="text-sm">Manage all personal information and data</p>
        </header>

        <ul class="space-y-2">
            <li>
                <a class="flex items-center gap-4 rounded p-4 hover:bg-slate-200 text-slate-600 text-sm font-semibold" href="{{ route('tenant.setting.edit', 'account') }}">
                    <span data-lucide="settings" class="size-5"></span>
                    Account Settings
                </a>
            </li>
            <li>
                <a class="flex items-center gap-4 rounded p-4 hover:bg-slate-200 text-slate-600 text-sm font-semibold" href="{{ route('tenant.setting.edit', 'security') }}">
                    <span data-lucide="key" class="size-5"></span>
                    Security Settings
                </a>
            </li>
            <li>
                <a class="flex items-center gap-4 rounded p-4 hover:bg-slate-200 text-slate-600 text-sm font-semibold" href="{{ route('tenant.setting.edit', 'help') }}">
                    <span data-lucide="badge-info" class="size-5"></span>
                    Help & Support
                </a>
            </li>
            <li>
                <button form="logout-form" class="w-full flex items-center gap-4 rounded p-4 hover:bg-slate-200 text-slate-600 text-sm font-semibold" href="{{ route('tenant.setting.edit', 'help') }}">
                    <span data-lucide="log-out" class="size-5"></span>
                    Sign Out
                </button>
                <form id="logout-form" action="{{route('tenant.logout')}}" method="post">@csrf</form>
            </li>
        </ul>
    </section>
</x-tenant::layouts.app>
