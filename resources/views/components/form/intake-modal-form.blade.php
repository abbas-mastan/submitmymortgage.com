@props(['intake','enableTeams'])
@component('components.modal-background', ['title' => 'Loan Application', 'width' => 'max-w-lg'])
      <x-form.intake-form :intake="$intake" :enableTeams="$enableTeams"/>
@endcomponent