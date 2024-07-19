<button {{ $attributes->merge(['type' => 'submit', 'class' => 'py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-primary-600 text-white hover:bg-primary-700 disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
