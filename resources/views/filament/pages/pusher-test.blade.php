<x-filament-panels::page>
    @livewire('notifications')
    <x-filament-panels::form>
        {{ $this->form }}
        {{-- <x-filament-panels::form.actions
            :actions="$this->getFormActions()"
        /> --}}
    </x-filament-panels::form>

</x-filament-panels::page>
{{-- ... --}}

@if (config('filament.broadcasting.echo'))
    <script data-navigate-once>
        window.Echo = new window.EchoFactory(@js(config('filament.broadcasting.echo')))

        window.dispatchEvent(new CustomEvent('EchoLoaded'))
    </script>
@endif

{{-- ... --}}
