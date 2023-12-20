@extends('layouts.base')

@section('title', 'Przerwa techniczna')

@section('body')
    <body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary" style="display: block;">

    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 offset-xl-2 offset-md-1 order-md-2 mb-5 mb-md-0">

                <!-- Image -->
                <div class="text-center">
                    <img src="assets/img/illustrations/coworking.svg" alt="..." class="img-fluid">
                </div>

            </div>
            <div class="col-12 col-md-5 col-xl-4 order-md-1 my-5">

                <div class="text-center">

                    <!-- Preheading -->
                    <h6 class="text-uppercase text-muted mb-4">
                        System jest niedostępny
                    </h6>

                    <!-- Heading -->
                    <h1 class="display-4 mb-3">
                        Przerwa techniczna 🔨
                    </h1>

                    <!-- Subheading -->
                    <p class="text-muted mb-4">
                        Nasz zespół właśnie usprawnia system aplikacji, przez co jest niedostępny. Wróć ponownie za
                        parę chwil, a po więcej informacji zajrzyj na naszego Discorda.
                    </p>

                </div>

            </div>
        </div>
    </div>

    <!-- Lib -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/chart.js/dist/Chart.min.js"></script>
    <script src="assets/libs/chart.js/Chart.extension.min.js"></script>
    <script src="assets/libs/highlight/highlight.pack.min.js"></script>
    <script src="assets/libs/flatpickr/dist/flatpickr.min.js"></script>
    <script src="assets/libs/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    <script src="assets/libs/list.js/dist/list.min.js"></script>
    <script src="assets/libs/quill/dist/quill.min.js"></script>
    <script src="assets/libs/dropzone/dist/min/dropzone.min.js"></script>
    <script src="assets/libs/select2/dist/js/select2.min.js"></script>

    <!-- Theme -->
    <script src="assets/js/theme.min.js"></script>

    </body>
@endsection