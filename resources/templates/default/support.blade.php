<x-tenant::layouts.app>
    <x-tenant::appbar title="Help & Support"/>

    <section class="pb-32 bg-white rounded-t-xl p-4 min-h-screen">

        <div class="flex flex-col justify-center">
            <span class="bg-amber-300 text-amber-500 size-16 rounded-full flex justify-center items-center mx-auto">
                <i data-lucide="message-circle-question" class="size-8"></i>
            </span>

            <h4 class="font-medium text-lg text-center">How may we help you</h4>
            <p class="text-center text-sm">You can reach out to us through these handles</p>

            {{--TODO: Work on the support links--}}
            <ul class="mt-4">
                <li>
                    <a href="https://wa.me/{{tenant()->phone}}" class="block font-semibold p-4 border text-center w-full">Whatsapp</a>
                </li>
            </ul>
        </div>
    </section>
</x-tenant::layouts.app>
