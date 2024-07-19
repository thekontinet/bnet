<x-tenant::layouts.app>
    <x-tenant::appbar title="Settings"/>

    <section class="p-4">
        @if(is_array($form))
            <x-template::form.group :forms="$form"/>
        @else
            <x-form.form :title="$form->title()"
                         :description="$form->description()"
                         :fields="$form->getFields()"
                         :action="$form->action()"
                         class="max-w-xl"/>
        @endif
    </section>
</x-tenant::layouts.app>
