@extends('layouts.base')

@section('title', '• System Aplikacji • Strona główna')

@section('body')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                </div>
            </div>

            <!-- Collapse -->
            <div class="collapse navbar-collapse mr-auto order-lg-first" id="navbar">

                <!-- Navigation -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <img src="assets/img/logo.png" class="navbar-brand-img">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/">
                            Strona główna
                        </a>
                    </li>
                    @if($applications->first() != null && $applications->first()->state != 0 && $applications->first()->state != 2 && $applications->first()->state != 3 && $applications->first()->state != 666)
                        <li class="nav-item">
                            <a class="nav-link" href="/new">
                                Napisz podanie
                            </a>
                        </li>
                    @endif
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
                                Przegląd
                            </h6>

                            <!-- Title -->
                            <h1 class="header-title text-white">
                                Status podania
                            </h1>

                        </div>
                    </div> <!-- / .row -->
                </div> <!-- / .header-body -->

                <!-- Footer -->
                <div class="header-footer">
                    @if(Session::has('success'))
                        <script type="text/javascript">
                            swal.fire({
                                icon: 'success',
                                title:'Podanie wysłane!',
                                text:"{{Session::get('success')}}",
                                timer:5000,
                                type:'success'
                            }).then((value) => {
                                //location.reload();
                            }).catch(swal.noop);
                        </script>
                    @endif
                    @if(Session::has('fail'))
                        <script type="text/javascript">
                            swal.fire({
                                icon: 'error',
                                title:'Błąd!',
                                text:"{{Session::get('fail')}}",
                                timer:5000,
                                type:'fail'
                            }).then((value) => {
                                //location.reload();
                            }).catch(swal.noop);
                        </script>
                    @endif

                    @if($applications->count() > 0)
                        @foreach($applications as $application)
                        <div class="card {{ $application->state == 666 ? "border-warning" : ""}}" data-toggle="lists" data-lists-values="[&quot;name&quot;]">
                            <div class="card-body">

                                <!-- List -->
                                <ul class="list-group list-group-lg list-group-flush list my--4">
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col ml--2">

                                                <!-- Title -->
                                                @if($application->state == 1337)
                                                    <h4>Tryb Developerski</h4>
                                                @elseif($application->state == 0 or $application->state == 1 or $application->state == 2 or $application->state == 3 or $application->state == 666)
                                                    <h4>Aplikacja na Whitelistę</h4>
                                                @endif
                                                <!-- Text -->
                                                <p class="card-text text-muted mb-1">
                                                @if($application->state == 0)
                                                    <span class="badge badge-soft-primary my-2" style="font-size: 14px;"><i class="fe fe-clock"></i> W trakcie sprawdzania</span><br>
                                                    Ten status oznacza, że dostaliśmy Twoją aplikację i zostanie ona sprawdzona wkrótce.<br>
                                                    Maksymalnie trwa to do 7 dni roboczych, chociaż zazwyczaj trwa to nieco krócej.<br>
                                                    Uzbrój się w cierpliwość - jeśli wszystko poszło dobrze, to dołączysz do nas wkrótce!<br>
                                                @elseif($application->state == 1)
                                                    <span class="badge badge-soft-danger my-2" style="font-size: 14px;"><i class="fe fe-close"></i> Odrzucona</span><br>
                                                    Ten status oznacza, że Twoja aplikacja została sprawdzona z wynikiem negatywnym.<br>
                                                    Zazwyczaj dzieje się tak, gdy Twoje podanie zawiera nieprawidłowe dane, jest przekolorowane, nie masz wymaganego wieku lub mamy inne zastrzeżenia.<br>
                                                    To nie wszystkie możliwe powody, a jedynie najbardziej pospolite.<br>
                                                    Przykro nam z tego powodu. Życzymy powodzenia w przyszłości!<br><hr>
                                                    Powód: {{ $application->getReason($application->id)}}
                                                @elseif($application->state == 2)
                                                    <span class="badge badge-soft-warning my-2" style="font-size: 14px;"><i class="fe fe-random"></i> Zwrócone do poprawy</span><br>
                                                        Ten status oznacza, że Twoja aplikacja nie do końca spełnia nasze wymogi. Ale dostałeś jeszcze jedną szansę, zapoznaj się z naszymi uwagami i popraw swoją aplikację.<br><hr>
                                                        Nasze uwagi: {{ $application->getReason($application->id) }}
                                                @elseif($application->state == 3)
                                                    <span class="badge badge-soft-success my-2" style="font-size: 14px;"><i class="fe fe-check"></i> Przyjęta</span><br>
                                                    Ten status oznacza, że Twoja aplikacja została zaakceptowana i jesteś na naszej Whiteliście. Super!
                                                @elseif($application->state == 1337)
                                                    <span class="badge badge-soft-primary my-2" style="font-size: 14px;"><i class="fe fe-code"></i> Tryb Developerski</span><br>
                                                    Ten status oznacza, że Twoja aplikacja jest w Trybie Developerskim.<br>
                                                @elseif($application->state == 666)
                                                    <span class="badge badge-warning my-2" style="font-size: 14px;"><i class="fe fe-bolt"></i> Priorytetowa</span><br>
                                                    Ten status oznacza, że dostaliśmy Twoją aplikację i wpłaciłeś darowiznę celem turboszybkiego jej sprawdzenia.<br>
                                                    Niezmiernie dziękujemy za Twój datek i odezwiemy się nie dłużej, niż do 24 godzin!
                                                @endif
                                                </p>

                                                <!-- Time -->
                                                <p class="card-text small text-muted">
                                                    Podanie utworzone: {{ $application->created_at }}<br>
                                                    Ostatnia aktualizacja z naszej strony: {{ $application->updated_at }}
                                                </p>

                                                @if($application->state == 2)
                                                    <a href="/edit/{{ $application->id }}" class="btn btn-block btn-link btn-info text-muted"><i class="fe fe-pencil"></i> Edytuj podanie</a>
                                                @endif

                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="card card-inactive">
                            <div class="card-body text-center">

                                <!-- Image -->
                                <img src="assets/img/illustrations/scale.svg" alt="..." class="img-fluid" style="max-width: 182px;">

                                <!-- Title -->
                                <h1>
                                    Brak wysłanych podań. 😱
                                </h1>

                                <!-- Subtitle -->
                                <p class="text-muted">
                                    Aplikuj, by zobaczyć tu swoje podanie.
                                </p>

                                <!-- Button -->
                                <a href="/new" class="btn btn-primary">
                                    Napisz podanie
                                </a>

                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
</body>
@endsection
