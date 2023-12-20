@extends('layouts.base')

@section('title', 'Strona główna')

@section('body')
    <body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">

            <!-- Toggler -->
            <button class="navbar-toggler mr-auto" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>



            <!-- User -->
            <div class="navbar-user">

                <!-- Dropdown -->
                <div class="dropdown">

                    <!-- Toggle -->
                    <a href="#" class="avatar avatar-sm dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- https://cdn.discordapp.com/avatars/412867223925948428/f3242bdaf443ffdfc793385deb6661d6.png?size=2048 -->
                        <img src="{{ $profilePicture }}" alt="..." class="avatar-img rounded-circle">
                    </a>

                    <!-- Menu -->
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="profile-posts.html" class="dropdown-item"><span class="fe fe-lock"></span> Panel administratora</a>
                        <a href="#" class="dropdown-item"><span class="fe fe-eye"></span> Sprawdź podania</a>
                        <hr class="dropdown-divider">
                        <a href="sign-in.html" class="dropdown-item">Wyloguj się</a>
                    </div>

                </div>

            </div>

            <!-- Collapse -->
            <div class="collapse navbar-collapse mr-auto order-lg-first" id="navbar">

                <!-- Navigation -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <img src="/assets/img/logo.png" class="navbar-brand-img">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            Strona główna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/new">
                            Napisz podanie
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/help">
                            Pomoc
                        </a>
                    </li>
                </ul>

            </div>

        </div>
    </nav>

    <div class="main-content">

        <div class="header bg-dark pb-5">
            <div class="container">
                <div class="header-body">
                    <div class="row align-items-end">

                        <div class="col">

                            <!-- Pretitle -->
                            <h6 class="header-pretitle text-secondary">
                                Zaczynamy
                            </h6>

                            <!-- Title -->
                            <h1 class="header-title text-white">
                                Wybierz kampanię
                            </h1>

                        </div>
                    </div> <!-- / .row -->
                </div> <!-- / .header-body -->

                <!-- Footer -->
                <div class="header-footer">

                    @if($campaigns->count() > 0)
                        <div class="card" data-toggle="lists" data-lists-values="[&quot;name&quot;]">
                            <div class="card-body">

                                <!-- List -->
                                <ul class="list-group list-group-lg list-group-flush list my--4">
                                    @foreach($campaigns as $campaign)
                                        <li class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <img src="https://i.imgur.com/ELVX11R.png" alt="..." class="avatar avatar-lg avatar-img rounded">
                                                </div>
                                                <div class="col ml--2">

                                                    <!-- Title -->
                                                    <h4 class="card-title mb-1 name">
                                                        <a class="{{ !$campaign->available ? 'text-muted' : ''}}">
                                                            @if($campaign->available)
                                                                {{ $campaign->name }}
                                                            @else
                                                                <span class="fe fe-lock"></span> {{ $campaign->name }}
                                                            @endif
                                                        </a>
                                                    </h4>

                                                    <!-- Text -->
                                                    <p class="card-text small text-muted mb-1">
                                                        @if($campaign->available)
                                                            <span style="color: #4CAF50"><span class="fe fe-check"></span> Możesz aplikować</span>
                                                        @else
                                                            <span class="fe fe-close"></span> Nie możesz aplikować
                                                        @endif
                                                    </p>

                                                    <!-- Time -->
                                                    <p class="card-text small text-muted">
                                                        {{ $campaign->short_description }}
                                                    </p>

                                                </div>
                                                @if($campaign->available)
                                                    <div class="col-auto">

                                                        <!-- Button -->
                                                        <a href="/new/{{ $campaign->uuid }}" class="btn btn-sm btn-white">
                                                            Wybierz
                                                        </a>

                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>

                    @else
                        <div class="card card-inactive">
                            <div class="card-body text-center">

                                <!-- Image -->
                                <img src="assets/img/illustrations/scale.svg" alt="..." class="img-fluid" style="max-width: 182px;">

                                <!-- Title -->
                                <h1>
                                    Brak dostępnych kampanii. 😞
                                </h1>

                                <!-- Subtitle -->
                                <p class="text-muted">
                                    Nie ma jeszcze posad, na które możesz aplikować.
                                    Wróć ponownie wkrótce!
                                </p>

                                <!-- Button -->
                                <a href="/" class="btn btn-primary">
                                    Wróć do strony głównej
                                </a>

                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- JavaScript libraries -->
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

    <!-- Theme script -->
    <script src="assets/js/theme.min.js"></script>

    </body>
@endsection