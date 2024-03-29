<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @if(app()->isProduction() && !preg_match('/google|googlebot|Lighthouse/i', Request::userAgent()))
        <!-- Google tag (gtag.js) -->
    @endif
    {!! Meta::toHtml() !!}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <livewire:styles />
</head>
<body class="font-inter leading-normal overflow-x-hidden flex min-h-screen flex-col justify-between">
    <x-header />
        <main>
            {{$slot}}
        </main>
    <x-footer />
</body>
    <x-to-top />
    <livewire:scripts />
    <livewire:modals.login />
    <livewire:modals.search />
    <livewire:modals.callback />
    <livewire:modals.buy-house />
@stack('js')
<script>
    document.addEventListener('livewire:load', () => {
        Livewire.onPageExpired((response, message) => {})
    })
</script>
</html>
