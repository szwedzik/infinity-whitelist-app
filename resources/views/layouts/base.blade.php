<!doctype html>
<html lang="{{ config('app.locale', 'pl') }}">
<head>
    <!-- Title -->
    <title>InfinityRP.pl @yield('title')</title>

    <!-- Metadata -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ __('meta.description') }}">

    <!-- CSS libraries -->
    <link rel="stylesheet" href="/assets/fonts/feather/feather.min.css">
    <link rel="stylesheet" href="/assets/libs/highlight/styles/vs2015.min.css">
    <link rel="stylesheet" href="/assets/libs/quill/dist/quill.core.css">
    <link rel="stylesheet" href="/assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/assets/libs/flatpickr/dist/flatpickr.min.css">

    <!-- Theme -->
    <link href="/assets/css/theme-dark.min.css" rel="stylesheet">
    <link href="/assets/css/main-dark.css" rel="stylesheet">
</head>
@yield('body')
</html>
