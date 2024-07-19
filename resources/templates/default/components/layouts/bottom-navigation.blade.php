<nav class="h-16 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
    <div class="grid grid-cols-3 h-full max-w-lg mx-auto font-medium">
        <x-tenant::bottom-navigation-item label="Orders" icon="package" :href="route('tenant.orders.index')" :active="request()->routeIs('tenant.orders.index')"/>
        <x-tenant::bottom-navigation-item label="Home" icon="home" :href="route('tenant.dashboard')" :active="request()->routeIs('tenant.dashboard')"/>
        <x-tenant::bottom-navigation-item label="Settings" icon="settings" :href="route('tenant.setting.index')" :active="request()->routeIs('tenant.setting.*')"/>
    </div>
</nav>
