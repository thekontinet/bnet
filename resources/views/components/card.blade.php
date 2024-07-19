<div class="bg-white shadow-sm dark:bg-neutral-900 dark:text-gray-200 mx-1 md:mx-0">
    <div {{$attributes->merge(['class' => "p-4 lg:p-6 border dark:border-neutral-800 rounded"])}}>
        {{$slot}}
    </div>
</div>
