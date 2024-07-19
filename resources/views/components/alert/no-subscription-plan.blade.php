

<div class="space-y-4 px-4 md:px-0">
@foreach($actions as $action)
    @if(($action['active'] ?? true) === true)
            <div id="dismiss-alert" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-amber-50 border border-amber-200 text-sm text-amber-800 rounded-lg p-4 dark:bg-amber-800/10 dark:border-amber-900 dark:text-amber-500" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <x-bi-exclamation-triangle class="flex-shrink-0 size-4 mt-0.5"/>
                    </div>
                    <div class="ms-2 flex-1 flex flex-col gap-1 relative">
                        <p class="text-sm opacity-70">
                            {{$action['message'] ?? ''}}
                        </p>
                        <a href="{{$action['url'] ?? '#'}}" title="{{$action['message'] ?? ''}}" class="absolute inset-0"></a>
                    </div>
                    <div class="ps-3 ms-auto">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-amber-50 rounded-lg p-1.5 text-amber-500 hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-amber-50 focus:ring-amber-600 dark:bg-transparent dark:hover:bg-amber-800/50 dark:text-amber-600" data-hs-remove-element="#dismiss-alert">
                                <span class="sr-only">Dismiss</span>
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    @endif
@endforeach
</div>
