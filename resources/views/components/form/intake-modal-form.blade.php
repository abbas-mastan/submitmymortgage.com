@props(['intake'])
@component('components.modal-background', ['title' => 'Loan Intake Form', 'width' => 'max-w-lg'])
      <x-form.intake-form :intake="$intake"/>
@endcomponent