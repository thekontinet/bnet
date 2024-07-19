<x-tenant::layouts.app class="bg-white">
    <x-tenant::appbar title="All Orders"/>

    <section class="py-4 bg-white space-y-4">
        <x-template::order.list :orders="$orders"/>
        <div class="mt-4 px-8">
            {{$orders->links()}}
        </div>
    </section>
</x-tenant::layouts.app>
