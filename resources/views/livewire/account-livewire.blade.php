<div>
    <!-- Filters and Add Buttons -->
    @include('totaa::livewire.support.filters')

    <!-- Incluce các modal -->
    @include('totaa::livewire.modal.add_edit_modal')

    <!-- Scripts -->
    @push('livewires')
        @include('totaa::livewire.support.script')
    @endpush

    <!-- Style -->
    @push('styles')
        @include('totaa::livewire.support.style')
    @endpush
</div>
