@php
    $bfo_info_arrays = Totaa\TotaaBfo\Models\BfoInfo::select("mnv", "full_name")->get()->toArray();
@endphp

<div>
    <!-- Filters and Add Buttons -->
    @include('totaa::livewire.support.filters')

    <!-- Incluce các modal -->
    @include('totaa::livewire.modal.add_edit_modal')
    @include('totaa::livewire.modal.link_modal')
    @include('totaa::livewire.modal.reset_modal')

    <!-- Scripts -->
    @push('livewires')
        @include('totaa::livewire.support.script')
    @endpush

    <!-- Style -->
    @push('styles')
        @include('totaa::livewire.support.style')
    @endpush
</div>
