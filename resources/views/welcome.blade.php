<!doctype html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dark:bg-neutral-900">
<!-- Hero -->
<div class="bg-gradient-to-b from-violet-600/10 via-transparent">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-24 space-y-8">
        <!-- Announcement Banner -->
        <div class="flex justify-center">
            <a class="inline-flex items-center justify-between group bg-white/10 hover:bg-white/10 border border-white/10 p-1 ps-4 rounded-full shadow-md focus:outline-none focus:ring-1 focus:ring-gray-600" href="{{route('login')}}">
                <p class="me-2 inline-block text-white text-sm">
                    Log in
                </p>
                <span class="group-hover:bg-white/10 py-1.5 px-2.5 inline-flex justify-center items-center gap-x-2 rounded-full bg-white/10 font-semibold text-white text-sm">
          <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </span>
            </a>
        </div>
        <!-- End Announcement Banner -->

        <!-- Title -->
        <div class="max-w-3xl text-center mx-auto">
            <h1 class="block font-medium text-gray-200 text-4xl sm:text-5xl md:text-6xl lg:text-7xl">
                Build Your Own Data Recharging Website Effortlessly
            </h1>
        </div>
        <!-- End Title -->

        <div class="max-w-3xl text-center mx-auto">
            <p class="text-lg text-gray-400">Create a professional and fully functional data recharging website with just a few clicks. Start selling airtime, data, gift cards, and more today!</p>
        </div>

        <!-- Buttons -->
        <div class="text-center">
            <a class="inline-flex justify-center items-center gap-x-3 text-center bg-gradient-to-tl from-blue-600 to-violet-600 shadow-lg shadow-transparent hover:shadow-blue-700/50 border border-transparent text-white text-sm font-medium rounded-full focus:outline-none focus:ring-1 focus:ring-gray-600 py-3 px-6 dark:focus:ring-offset-gray-800" href="{{route('register')}}">
                Get started
                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </div>
        <!-- End Buttons -->
    </div>
</div>
<!-- End Hero -->


<!-- Icon Blocks -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 items-center gap-2">
        <!-- Icon Block -->
        <a class="group flex flex-col justify-center hover:bg-gray-50 rounded-xl p-4 md:p-7 dark:hover:bg-neutral-800" href="#">
            <div class="flex justify-center items-center size-12 bg-blue-600 rounded-xl">
                <svg class="flex-shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="10" height="14" x="3" y="8" rx="2"/><path d="M5 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2h-2.4"/><path d="M8 18h.01"/></svg>
            </div>
            <div class="mt-5">
                <h3 class="group-hover:text-gray-600 text-lg font-semibold text-gray-800 dark:text-white dark:group-hover:text-gray-400">Build Your Own Data Recharging Website Effortlessly</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">Create a professional and fully functional data recharging website with just a few clicks. Start selling airtime, data, gift cards, and more today!</p>
            </div>
        </a>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <a class="group flex flex-col justify-center hover:bg-gray-50 rounded-xl p-4 md:p-7 dark:hover:bg-neutral-800" href="#">
            <div class="flex justify-center items-center size-12 bg-blue-600 rounded-xl">
                <svg class="flex-shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div class="mt-5">
                <h3 class="group-hover:text-gray-600 text-lg font-semibold text-gray-800 dark:text-white dark:group-hover:text-gray-400">Secure Payment Integration</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">Ensure secure transactions with integrated payment gateways and wallet systems.</p>
            </div>
        </a>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <a class="group flex flex-col justify-center hover:bg-gray-50 rounded-xl p-4 md:p-7 dark:hover:bg-neutral-800" href="#">
            <div class="flex justify-center items-center size-12 bg-blue-600 rounded-xl">
                <svg class="flex-shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z"/><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"/></svg>
            </div>
            <div class="mt-5">
                <h3 class="group-hover:text-gray-600 text-lg font-semibold text-gray-800 dark:text-white dark:group-hover:text-gray-400">Customized Template</h3>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">Choose from a variety of templates and customize them to match your brand.</p>
            </div>
        </a>
        <!-- End Icon Block -->
    </div>
</div>
<!-- End Icon Blocks -->


<!-- Features -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="relative p-6 md:p-16">
        <!-- Grid -->
        <div class="relative z-10 lg:grid lg:grid-cols-12 lg:gap-16 lg:items-center">
            <div class="mb-10 lg:mb-0 lg:col-span-6 lg:col-start-8 lg:order-2">
                <h2 class="text-2xl text-gray-800 font-bold sm:text-3xl dark:text-neutral-200">
                    How it Works
                </h2>

                <!-- Tab Navs -->
                <nav class="grid gap-4 mt-5 md:mt-10" aria-label="Tabs" role="tablist">
                    <button type="button" class="hs-tab-active:bg-white hs-tab-active:shadow-md hs-tab-active:hover:border-transparent text-start hover:bg-gray-200 p-4 md:p-5 rounded-xl dark:hs-tab-active:bg-neutral-700 dark:hover:bg-neutral-700 active" id="tabs-with-card-item-1" data-hs-tab="#tabs-with-card-1" aria-controls="tabs-with-card-1" role="tab">
                        <span class="flex">
                          <x-heroicon-c-user class="flex-shrink-0 mt-2 size-6 md:size-7 hs-tab-active:text-blue-600 text-gray-800 dark:hs-tab-active:text-blue-500 dark:text-neutral-200"/>
                          <span class="grow ms-6">
                            <span class="block text-lg font-semibold hs-tab-active:text-blue-600 text-gray-800 dark:hs-tab-active:text-blue-500 dark:text-neutral-200">Create an account</span>
                            <span class="block mt-1 text-gray-800 dark:hs-tab-active:text-gray-200 dark:text-neutral-200">Create an account on our platform and choose a subscription plan that suits your needs.</span>
                          </span>
                        </span>
                    </button>

                    <button type="button" class="hs-tab-active:bg-white hs-tab-active:shadow-md hs-tab-active:hover:border-transparent text-start hover:bg-gray-200 p-4 md:p-5 rounded-xl dark:hs-tab-active:bg-neutral-700 dark:hover:bg-neutral-700" id="tabs-with-card-item-2" data-hs-tab="#tabs-with-card-2" aria-controls="tabs-with-card-2" role="tab">
                        <span class="flex">
                          <x-heroicon-c-check-badge class="flex-shrink-0 mt-2 size-6 md:size-7 hs-tab-active:text-blue-600 text-gray-800 dark:hs-tab-active:text-blue-500 dark:text-neutral-200"/>
                          <span class="grow ms-6">
                            <span class="block text-lg font-semibold hs-tab-active:text-blue-600 text-gray-800 dark:hs-tab-active:text-blue-500 dark:text-neutral-200">Activate your account</span>
                            <span class="block mt-1 text-gray-800 dark:hs-tab-active:text-gray-200 dark:text-neutral-200">Verify your email and subscribe to a plan</span>
                          </span>
                        </span>
                    </button>

                    <button type="button" class="hs-tab-active:bg-white hs-tab-active:shadow-md hs-tab-active:hover:border-transparent text-start hover:bg-gray-200 p-4 md:p-5 rounded-xl dark:hs-tab-active:bg-neutral-700 dark:hover:bg-neutral-700" id="tabs-with-card-item-3" data-hs-tab="#tabs-with-card-3" aria-controls="tabs-with-card-3" role="tab">
                        <span class="flex">
                          <svg class="flex-shrink-0 mt-2 size-6 md:size-7 hs-tab-active:text-blue-600 text-gray-800 dark:hs-tab-active:text-blue-500 dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/><path d="M5 3v4"/><path d="M19 17v4"/><path d="M3 5h4"/><path d="M17 19h4"/></svg>
                          <span class="grow ms-6">
                            <span class="block text-lg font-semibold hs-tab-active:text-blue-600 text-gray-800 dark:hs-tab-active:text-blue-500 dark:text-neutral-200">Hurray! your website is ready</span>
                            <span class="block mt-1 text-gray-800 dark:hs-tab-active:text-gray-200 dark:text-neutral-200">Your website will be up and ready to start selling data, airtime, and other services to your customers.</span>
                          </span>
                        </span>
                    </button>
                </nav>
                <!-- End Tab Navs -->
            </div>
            <!-- End Col -->

            <div class="lg:col-span-6">
                <div class="relative">
                    <!-- Tab Content -->
                    <div>
                        <div id="tabs-with-card-1" role="tabpanel" aria-labelledby="tabs-with-card-item-1">
                            <img class="shadow-xl shadow-gray-200 rounded-xl dark:shadow-gray-900/20" src="https://images.unsplash.com/photo-1605629921711-2f6b00c6bbf4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=987&h=1220&q=80" alt="Image Description">
                        </div>

                        <div id="tabs-with-card-2" class="hidden" role="tabpanel" aria-labelledby="tabs-with-card-item-2">
                            <img class="shadow-xl shadow-gray-200 rounded-xl dark:shadow-gray-900/20" src="https://images.unsplash.com/photo-1665686306574-1ace09918530?ixlib=rb-4.0.3&ixid=MnwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=987&h=1220&q=80" alt="Image Description">
                        </div>

                        <div id="tabs-with-card-3" class="hidden" role="tabpanel" aria-labelledby="tabs-with-card-item-3">
                            <img class="shadow-xl shadow-gray-200 rounded-xl dark:shadow-gray-900/20" src="https://images.unsplash.com/photo-1598929213452-52d72f63e307?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=987&h=1220&q=80" alt="Image Description">
                        </div>
                    </div>
                    <!-- End Tab Content -->

                    <!-- SVG Element -->
                    <div class="hidden absolute top-0 end-0 translate-x-20 md:block lg:translate-x-20">
                        <svg class="w-16 h-auto text-orange-500" width="121" height="135" viewBox="0 0 121 135" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 16.4754C11.7688 27.4499 21.2452 57.3224 5 89.0164" stroke="currentColor" stroke-width="10" stroke-linecap="round"/>
                            <path d="M33.6761 112.104C44.6984 98.1239 74.2618 57.6776 83.4821 5" stroke="currentColor" stroke-width="10" stroke-linecap="round"/>
                            <path d="M50.5525 130C68.2064 127.495 110.731 117.541 116 78.0874" stroke="currentColor" stroke-width="10" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <!-- End SVG Element -->
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Grid -->

        <!-- Background Color -->
        <div class="absolute inset-0 grid grid-cols-12 size-full">
            <div class="col-span-full lg:col-span-7 lg:col-start-6 bg-gray-100 w-full h-5/6 rounded-xl sm:h-3/4 lg:h-full dark:bg-neutral-800"></div>
        </div>
        <!-- End Background Color -->
    </div>
</div>
<!-- End Features -->


<!-- FAQ -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Title -->
    <div class="max-w-2xl mx-auto mb-10 lg:mb-14">
        <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">You might be wondering...</h2>
    </div>
    <!-- End Title -->

    <div class="max-w-4xl mx-auto divide-y divide-gray-200 dark:divide-neutral-700">
        <div class="py-8 first:pt-0 last:pb-0">
            <div class="flex gap-x-5">
                <svg class="flex-shrink-0 mt-1 size-6 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>

                <div>
                    <h3 class="md:text-lg font-semibold text-gray-800 dark:text-neutral-200">
                        Can I cancel my subscription anytime?
                    </h3>
                    <p class="mt-1 text-gray-500 dark:text-neutral-500">
                        You do not have to cancel. We do not automatically subscribe with our users balance
                    </p>
                </div>
            </div>
        </div>

        <div class="py-8 first:pt-0 last:pb-0">
            <div class="flex gap-x-5">
                <svg class="flex-shrink-0 mt-1 size-6 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>

                <div>
                    <h3 class="md:text-lg font-semibold text-gray-800 dark:text-neutral-200">
                        How do I integrate payment gateways?
                    </h3>
                    <p class="mt-1 text-gray-500 dark:text-neutral-500">
                        Currently, we support Paystack as the payment gateway. You can easily set up Paystack from the dashboard settings. We plan to add more payment gateways in the future.
                    </p>
                </div>
            </div>
        </div>

        <div class="py-8 first:pt-0 last:pb-0">
            <div class="flex gap-x-5">
                <svg class="flex-shrink-0 mt-1 size-6 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>

                <div>
                    <h3 class="md:text-lg font-semibold text-gray-800 dark:text-neutral-200">
                        What services can I offer on my website?
                    </h3>
                    <p class="mt-1 text-gray-500 dark:text-neutral-500">
                        Currently, you can offer airtime and data recharges on your website. We have plans to add more services such as gift cards and P2P transactions as the need arises.
                    </p>
                </div>
            </div>
        </div>

        <div class="py-8 first:pt-0 last:pb-0">
            <div class="flex gap-x-5">
                <svg class="flex-shrink-0 mt-1 size-6 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>

                <div>
                    <h3 class="md:text-lg font-semibold text-gray-800 dark:text-neutral-200">
                        How do I customize my website?
                    </h3>
                    <p class="mt-1 text-gray-500 dark:text-neutral-500">
                        Currently out platform do not support customization. But we plan on having those in the future
                    </p>
                </div>
            </div>
        </div>

        <div class="py-8 first:pt-0 last:pb-0">
            <div class="flex gap-x-5">
                <svg class="flex-shrink-0 mt-1 size-6 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>

                <div>
                    <h3 class="md:text-lg font-semibold text-gray-800 dark:text-neutral-200">
                        What kind of support do you offer?
                    </h3>
                    <p class="mt-1 text-gray-500 dark:text-neutral-500">
                        We offer 24/7 customer support via email and live chat. Our support team is always ready to help you with any issues or questions you may have.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End FAQ -->


<!-- ========== FOOTER ========== -->
<footer class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <!-- Grid -->
    <div class="text-center">
        <div>
            <a class="flex-none text-xl font-semibold text-black dark:text-white" href="#" aria-label="Brand">{{config('app.name')}}</a>
        </div>
        <!-- End Col -->

        <div class="mt-3">
            <p class="text-gray-500 dark:text-neutral-500">Empowering your business to connect and grow..</p>
            <p class="text-gray-500 dark:text-neutral-500">&copy; {{config('app.name')}}. {{date('Y')}}. All rights reserved.</p>
        </div>

        <!-- Social Brands -->
        <div class="mt-3 space-x-2">
            <a class="size-12 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700" href="{{config('social.whatsapp_group')}}">
               <x-bi-whatsapp class="flex-shrink-0 size-6"/>
            </a>
        </div>
        <!-- End Social Brands -->
    </div>
    <!-- End Grid -->
</footer>
<!-- ========== END FOOTER ========== -->

</body>
</html>
