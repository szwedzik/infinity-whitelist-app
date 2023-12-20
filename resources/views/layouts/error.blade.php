@extends('layouts.base')

@section('title', 'Ups!')

@section('body')
    <body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5 col-xl-4 my-5">
                <div class="text-center">
                    <!-- Pre-header -->
                    <h6 class="text-uppercase text-muted mb-4">
                        Błąd @yield('code')
                    </h6>

                    <!-- Heading -->
                    <h1 class="display-4 mb-3">
                        @yield('message')
                    </h1>

                    <!-- Subheading -->
                    <p class="text-muted mb-4">
                        @yield('explanation')
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

    <!-- Theme script -->
    <script src="/assets/js/theme.min.js"></script>
    </body>
@endsection