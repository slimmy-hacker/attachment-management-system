<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description"
          content="IAMS">
    <meta name="author" content="Marion">
    <meta name="generator" content="Hugo 0.143.0">

    <title>@yield('title')</title>
    @include('layouts.partials.styles')
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@">
    <meta name="twitter:creator" content="@">
    <meta name="twitter:title" content="Tailwind CSS Dashboard - Windster">
    <meta name="twitter:description"
          content="Get started with a free and open source Tailwind CSS admin dashboard featuring a sidebar layout, advanced charts, and hundreds of components based on Flowbite">
    <meta name="twitter:image" content="https://themewagon.github.io/windster/">

    <!-- Facebook -->
    <meta property="og:url" content="https://themewagon.github.io/windster/">
    <meta property="og:title" content="Tailwind CSS Dashboard - Windster">
    <meta property="og:description"
          content="Get started with a free and open source Tailwind CSS admin dashboard featuring a sidebar layout, advanced charts, and hundreds of components based on Flowbite">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://themewagon.github.io/docs/images/og-image.jpg">
    <meta property="og:image:type" content="image/png">

    @include('layouts.partials.scripts')


</head>
<body class="bg-gray-50">

<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-THQTXJ7"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>


@include('layouts.partials.header')

<div class="flex overflow-hidden bg-white pt-16">

    @include('layouts.partials.sidebar')
    <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>


    <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64">
        <main class="flex-1 p-6 bg-gray-100 overflow-auto">
            @yield('content')
        </main>
        @include('layouts.partials.footer')


    </div>

</div>


<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://themewagon.github.io/windster/app.bundle.js"></script>
</body>
</html>
