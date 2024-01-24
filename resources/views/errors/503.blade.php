<x-tenant::layouts.app class="flex">
    <section class="bg-blue-100 h-full grid place-items-center">
        <div class="max-w-md p-8 bg-white rounded-lg shadow-lg">
            <h2 class="text-4xl font-bold text-tailwind-blue mb-4">503 Service Unavailable</h2>
            <p class="text-gray-600 mb-6">Currently, our service is not available. We apologize for any inconvenience this may cause. Please consider revisiting at a later time, or feel free to reach out to our support team for assistance.</p>
            {{--TODO: Add tenant support link--}}
            <a href="#"><x-tenant::primary-button>Contact Support</x-tenant::primary-button></a>
        </div>
    </section>
</x-tenant::layouts.app>
