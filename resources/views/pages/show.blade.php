<x-app-layout>
    <x-container>

        {{ Breadcrumbs::render('page', $page) }}

        <x-h1>
            {{$page->name}}
        </x-h1>

        <livewire:callback-form />

    </x-container>
</x-app-layout>
