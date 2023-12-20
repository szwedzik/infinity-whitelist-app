<!doctype html>
<html lang="{{ config('app.locale', 'pl') }}">
<head>
    <!-- Title -->
    <title>InfinityRP.pl - Błąd</title>

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
<body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-xl-4 my-5">
            <div class="text-center">
                <!-- Heading -->
                <h1 class="display-4 mb-3">
                    @if(isset($code))
                        {{ $code }}
                    @endif
                </h1>

                <!-- Subheading -->
                <p class="text-muted mb-4">
                    @if(isset($message))
                        {{ $message }}
                    @endif
                </p>

                <!-- Button -->
                <a href="/" class="btn btn-lg btn-primary">
                    Wróć do strony głównej
                </a>

            </div>

        </div>
    </div>
</div>

<!-- JavaScript libraries -->
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/libs/chart.js/dist/Chart.min.js"></script>
<script src="/assets/libs/chart.js/Chart.extension.min.js"></script>
<script src="/assets/libs/highlight/highlight.pack.min.js"></script>
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script src="/assets/libs/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<script src="/assets/libs/list.js/dist/list.min.js"></script>
<script src="/assets/libs/quill/dist/quill.min.js"></script>
<script src="/assets/libs/dropzone/dist/min/dropzone.min.js"></script>
<script src="/assets/libs/select2/dist/js/select2.min.js"></script>

</body>
</html>
