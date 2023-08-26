<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background-image: linear-gradient(to left, #60afff 10%, #4ef4bd 99%);
        }
    </style>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
</head>

<body class="antialiased">
    @if (session('error'))
        <div
            class="alert alert-error text-red-800 mt-14 font-semibold text-center absolute top-4 right-16
        p-4 bg-white rounded-md shadow-md">
            {{ session('error') }}
        </div>
    @endif
    @if (session('status'))
        <div
            class="alert alert-error text-blue-800 mt-14 font-semibold text-center absolute top-4 right-16
        p-4 bg-white rounded-md shadow-md">
            {{ session('status') }}
        </div>
    @endif
    <div class="container mx-auto">
        {{ $slot }}
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.directive('confirm', ({
                el,
                directive,
                component,
                cleanup
            }) => {
                let content = directive.expression

                let onClick = e => {
                    if (!confirm(content)) {
                        e.preventDefault()
                        e.stopPropagation()
                        e.stopImmediatePropagation()
                    }
                }

                el.addEventListener('click', onClick, {
                    capture: true
                })

                cleanup(() => {
                    el.removeEventListener('click', onClick)
                })
            })
        })
    </script>
</body>

</html>
