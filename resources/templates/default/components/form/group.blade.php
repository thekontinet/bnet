@props(['forms'])

@foreach($forms as $form)
    <section class="sm:rounded-lg">
        <x-form.form :title="$form->title()"
                     :description="$form->description()"
                     :fields="$form->getFields()"
                     :action="$form->action()"
                     class="max-w-xl"/>
    </section>
@endforeach
