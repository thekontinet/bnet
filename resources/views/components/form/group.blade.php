@props(['forms'])

@foreach($forms as $form)
    <x-card>
        <x-form.form :title="$form->title()"
                     :description="$form->description()"
                     :fields="$form->getFields()"
                     :action="$form->action()"
                     class="max-w-xl"/>
    </x-card>
@endforeach
