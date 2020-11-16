<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        @include('partials._head')
<body>
    <div id="app">
        @include('partials._nav')

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @include('partials._footer')
</body>
</html>