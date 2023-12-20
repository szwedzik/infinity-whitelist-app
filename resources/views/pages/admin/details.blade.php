@extends('layouts.base')

@section('title', '• Administrator')

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

                    <!-- Menu
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="profile-posts.html" class="dropdown-item"><span class="fe fe-lock"></span> Panel administratora</a>
                        <a href="#" class="dropdown-item"><span class="fe fe-eye"></span> Sprawdź podania</a>
                        <hr class="dropdown-divider">
                        <a href="sign-in.html" class="dropdown-item">Wyloguj się</a>
                    </div> -->

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
                            Powrót
                        </a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link" href="/help">
                            Pomoc
                        </a>
                    </li>-->
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
                                Administrator
                            </h6>

                            <!-- Title -->
                            <h1 class="header-title text-white">
                                Szczegóły podania
                            </h1>

                        </div>
                    </div> <!-- / .row -->
                </div> <!-- / .header-body -->

                <!-- Footer -->
                <div class="header-footer">
                    @csrf

                    <h6 class="header-pretitle text-secondary">
                        Informacje o kandydacie
                    </h6>

                    <!-- Project name -->
                    <div class="form-group">
                        <label>
                            Nick Discord
                        </label>
                        <small class="form-text text-warning">
                            <i class="fe fe-warning"></i> Nick discord i discord id.
                        </small>
                        {{$application->discord_username}} - ({{$application->discord_id}})
                    </div>
                    <div class="form-group">
                        <label>
                            Link do profilu Steam
                        </label>
                        <small class="form-text text-warning">
                            <i class="fe fe-warning"></i> Sprawdź, czy taki profil Steam istnieje.
                        </small>
                        @if(is_numeric($application->steam_url))
                            <a href="https://steamcommunity.com/profiles/{{ $application->steam_url }}">https://steamcommunity.com/profiles/{{ $application->steam_url }}</a>
                        @else
                            <a href="{{ $application->steam_url }}">{{ $application->steam_url }}</a>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="mb-1">
                            Wiek aplikanta
                        </label>
                        @if($age >= 16)
                            <small class="form-text text-success">
                                <i class="fe fe-check-verified"></i> Kandydat ma ukończone 16 lat.
                            </small>
                        <p class="text-muted">{{ $age }} lat</p>
                        @else
                            <small class="form-text text-danger">
                                <i class="fe fe-warning"></i> Kandydat nie ma ukończonych 16 lat.
                            </small>
                        <p class="text-muted">{{ $age }} lat</p>
                        @endif
                    </div>

                    <hr class="mt-5 mb-5">

                    <h6 class="header-pretitle text-secondary">
                        Rozeznanie
                    </h6>

                    <div class="form-group">
                        <label>
                            Czym jest dla Ciebie RP?
                        </label>
                        <p class="text-muted">{{ $application->rp_definition }}</p>
                    </div>

                    <div class="form-group">
                        <label>
                            Opisz swoje doświadczenia z RP i postacie, które do tej pory odgrywałeś(aś).
                        </label>
                        <p class="text-muted">{{ $application->past_characters }}</p>
                    </div>

                    <div class="form-group">
                        <label>
                            Napisz, jakie postacie zamierzasz odgrywać na naszym serwerze.<br>
                            Uwzględnij ich historię.
                        </label>
                        <p class="text-muted">{{ $application->character_idea }}</p>
                    </div>

                    <div class="form-group">
                        <label>
                            Streamujesz albo nagrywasz rozgrywkę na swoje kanały?<br>
                            Jeśli tak, pokaż nam nagrania z przykładem Twojego RP.<br>
                            <small class="text-muted">
                                W przeciwnym wypadku pozostaw to pole puste.
                            </small>
                        </label>
                        <p class="text-muted">{{ $application->streamer }}</p>
                    </div>

                    <hr class="mt-5 mb-5">

                    <h6 class="header-pretitle text-secondary">
                        Serwer i rozgrywka
                    </h6>

                    <div class="form-group">
                        <label>
                            Wyślij link do regulaminu <b>serwera</b>.<br>
                            Wskaż jego dobre i złe strony.
                        </label>
                        @if(strpos($application->rules_opinion, 'guidelines') != false)
                            <small class="form-text text-danger">
                                <i class="fe fe-warning"></i> <i>https://forum.infinityrp.pl/guidelines/</i> to regulamin <b>forum</b>, a nie serwera!
                            </small>
                        @endif
                        <p class="text-muted">{{ $application->rules_opinion }}</p>
                    </div>

                    <div class="form-group">
                        <label>
                            Do czego służą komendy <code>!me</code> i <code>!do</code>?<br>
                            Jak ich używać?
                        </label>
                        <p class="text-muted">{{ $application->me_do }}</p>
                    </div>

                    <div class="form-group">
                        <label>
                            Czy korzystając z komendy <code>!do</code>, możesz skłamać?
                        </label>
                        <p class="text-muted">{{ $application->do_lying }}</p>
                    </div>

                    <div class="form-group">
                        <label>
                            Napisz, co to jest <code>OOC</code> i <code>IC</code>.<br>
                            Czym różnią się te strefy?
                        </label>
                        <p class="text-muted">{{ $application->ooc_vs_ic }}</p>
                    </div>

                    <div class="form-group">
                        <label>
                            Czy zabójstwo innej postaci z zemsty jest dozwolone?
                        </label>
                        <p class="text-muted">{{ $application->revenge_kill }}</p>
                    </div>

                    <div class="form-group">
                        <label>
                            Wyjaśnij, co to jest <abbr title="Brutally Wounded">BW</abbr>.
                        </label>
                        <p class="text-muted">{{ $application->brutally_wounded }}</p>
                    </div>

                    <div class="form-group">
                        <label>
                            Wyjaśnij, czym jest metagaming.<br>
                            Czy można go używać w grze?
                        </label>
                        <p class="text-muted">{{ $application->meta_gaming }}</p>
                    </div>

                    <div class="form-group">
                        <label>
                            Wyjaśnij, czym jest powergaming.<br>
                        </label>
                        <p class="text-muted">{{ $application->power_gaming }}</p>
                    </div>

                    <hr class="mt-5 mb-5">

                    <h6 class="header-pretitle text-secondary">
                        RolePlay
                    </h6>

                    <div class="form-group">
                        <label class="mb-1">
                            Zostajesz napadnięty przez trzech uzbrojonych napastników, co robisz?<br>
                        </label>
                        <small class="form-text text-muted">
                            Odegraj scenariusz tak jak zachowałaby się twoja postać, używając przy tym komend narracyjnych <code>!me</code> i <code>!do</code>.
                        </small>
                        <p class="text-muted">{{ $application->rp_action_1 }}</p>
                    </div>

                    <div class="form-group">
                        <label class="mb-1">
                            Spotykasz osobę która 10 minut wcześniej doprowadziła twoją postać do <abbr title="Brutally Wounded">BW</abbr>?<br>
                            Co robisz, jak się zachowujesz?
                        </label>
                        <p class="text-muted">{{ $application->rp_action_2 }}</p>
                    </div>

                    <div class="form-group">
                        <label class="mb-1">
                            Zostałeś zaatakowany przez pięciu napastników, którzy wszyscy skierowali swoje bronie w Twoją stronę.<br>
                            Trzymasz ręce w górze, ale w Twoim plecaku znajduje się broń maszynowa. Czy masz możliwość obrony w takiej sytuacji?<br>
                        </label>
                        <p class="text-muted">{{ $application->rp_action_3 }}</p>
                    </div>

                    <div class="form-group">
                        <label class="mb-1">
                            Twoja postać złamała nogę, czy możesz poinformować towarzyszy za pomocą zewnętrzengo komunikatora?
                        </label>
                        <p class="text-muted">{{ $application->rp_action_4 }}</p>
                    </div>

                    <div class="form-group">
                        <label class="mb-1">
                            Zauważyłeś że, któraś z osób obok Ciebie użyła komendy narracyjnej <code>!me</code> w której podała następujące informacje:<br>
                            !do Spogląda na zegarek.
                        </label>
                        <small class="form-text text-muted">
                            Czy ta osoba poprawnie użyła komendy narracyjnej <code>!me</code>?
                        </small>
                        <p class="text-muted">{{ $application->rp_action_5 }}</p>
                    </div>

                    <div class="form-group">
                        <label class="mb-1">
                            Czy podany niżej scenariusz został poprawnie odegrany z wykożystaniem komend narracyjncyh <code>!me</code> i <code>!do</code>?<br>
                            !me jednym szybkim ruchem wyciąga nóż i wycina rękę napastnikowi.<br>
                            !do Napastnikowi wycięto rękę.
                        </label>
                        <p class="text-muted">{{ $application->rp_action_6 }}</p>
                    </div>

                    <div class="form-group">
                        <label class="mb-1">
                            Czy podany niżej scenariusz został poprawnie odegrany z wykożystaniem komend narracyjncyh <code>!me</code> i <code>!do</code>?<br>
                            !me jednym szybkim zwinnym ruchem obezwładnia napastnika.<br>
                            !do Napastnik został obezwładniony.
                        </label>
                        <p class="text-muted">{{ $application->rp_action_7 }}</p>
                    </div>

                    <div class="form-group">
                        <label class="mb-1">
                            Widzisz osobę śpiącą przy kominku, chcesz ją otruć karmiąc ją zepsutą rybą.<br>
                            Czy możesz to zrobić?
                        </label>
                        <p class="text-muted">{{ $application->rp_action_8 }}</p>
                    </div>

                    <div class="form-group">
                        <label class="mb-1">
                            Wchodzisz na serwer świerzo po jego restarcie.<br>
                            Po niecałych dwóch minutach zauważasz bezbroną osobę którą chcesz obezwładnić.<br>
                            Czy możesz to zrobić?
                        </label>
                        <p class="text-muted">{{ $application->rp_action_9 }}</p>
                    </div>

                    <div class="form-group">
                        <label class="mb-1">
                            Czy przebywając w obcej osadzie możesz okraść jej mieszkańców?
                        </label>
                        <p class="text-muted">{{ $application->rp_action_10 }}</p>
                    </div>

                    @if($application->state == 0 || $application->state == 2)
                        <hr class="mt-5 mb-5">

                        <!-- Buttons -->
                        <div class="row">
                            <div class="col col-md-3">
                                <a href="/admin/{{ $application->id }}/accept" class="btn btn-block btn-primary">
                                    <i class="fe fe-random"></i> <b>Zaakceptuj</b> podanie
                                </a>
                            </div>
                            <div class="col col-md-3">
                                <button type="button" id="returnApplication" data-toggle="modal" data-target="#exampleModal" class="btn btn-block btn-warning">
                                    <i class="fe fe-close"></i> <b>Zwróć</b> podanie do poprawy
                                </button>
                            </div>
                            <div class="col col-md-3">
                                <button type="button" id="denyApplication" data-toggle="modal" data-target="#exampleModal" class="btn btn-block btn-danger">
                                    <i class="fe fe-close"></i> <b>Odrzuć</b> podanie
                                </button>
                            </div>
                            <div class="col col-md-3">
                                <a href="/admin" class="btn btn-block btn-link btn-info text-muted">
                                    <i class="fe fe-arrow-left"></i> Powrót do panelu
                                </a>
                            </div>
                        </div>
                        @else
                        <hr class="mt-5 mb-5">

                        <!-- Buttons -->
                        <div class="row">
                            <a href="/admin" class="btn btn-block btn-link btn-info text-muted">
                                <i class="fe fe-arrow-left"></i> Powrót do panelu
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <style>
        .modal-header {
            border-bottom: 1px solid #4e19a8;
        }
        .modal-footer {
            border-top: 1px solid #4e19a8;
        }
    </style>
    <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                <div class="modal-body">

                        <div class="mb-3">
                            <input type="hidden" name="id" value="{{ $application->id }}">
                            <label for="message-text" class="col-form-label">Powód:</label>
                            <textarea class="form-control" id="reason" name="reason" maxlength="250"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger float-left" data-dismiss="modal">Anuluj</button>
                    <button type="submit" id="returnModalButton" class="btn btn-primary">Zwróć podanie</button>
                </div>
                </form>
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

    <script>
        $('div.form-group p').each(function() {
            let text = $(this).text();
            let text_length = text.length;
            let name = $(this).attr('name');
            $(this).after('<div class="text-right small text-muted"><span id="count_' + name + '">' + text_length + ' znaków</span></div>');
        });

        $(document).ready(function() {
            let reason = $('input[name="reason"]').val();
            if (reason == '' || reason == null) {
                $('#returnModalButton').prop('disabled', true);
            }
        });

        $('#reason').keyup(function() {
            let text_length = $(this).val().length;
            if (text_length > 0) {
                $('#returnModalButton').prop('disabled', false);
            } else {
                $('#returnModalButton').prop('disabled', true);
            }
        });

        $('textarea').each(function() {
            let text_max = $(this).attr('maxlength');

            $(this).keyup(function() {
                let text_length = $(this).val().length;
                $('#count_' + $(this).attr('name')).text(text_length);
            });

            $(this).after('<div class="text-right small text-muted"><span id="count_' + $(this).attr('name') + '">' + 0 + '</span> / ' + text_max + '</div>');
        });

        $('#returnApplication, #denyApplication').click(function() {
            let title = $(this).text();
            if ($(this).attr('id') === 'denyApplication') {
                $('#returnModalButton').text('Odrzuć podanie');
                $('#exampleModal form').attr('action', '/adminn/deny');
            } else {
                $('#returnModalButton').text('Zwróć podanie');
                $('#exampleModal form').attr('action', '/adminn/return');
            }
            $('#exampleModalLabel').text(title);
        });
    </script>

    </body>
@endsection
