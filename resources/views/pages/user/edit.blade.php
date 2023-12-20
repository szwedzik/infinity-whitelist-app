@extends('layouts.base')

@section('title', '• Edytowanie podania')

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

                    <form class="mb-4" action="/edit" method="post">
                        @csrf

                        <input type="hidden" name="id" value="{{ $application->id }}">
                        <h6 class="header-pretitle text-secondary">
                            Rozeznanie
                        </h6>

                        <div class="form-group">
                            <label>
                                Czym jest dla Ciebie RP?
                            </label>
                            <textarea maxlength="2000" required type="text" class="form-control" name="rp_definition">{{ $application->rp_definition }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Opisz swoje doświadczenia z RP i postacie, które do tej pory odgrywałeś(aś).
                            </label>
                            <textarea maxlength="2000" required type="text" class="form-control" name="past_characters">{{ $application->past_characters }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Napisz, jakie postacie zamierzasz odgrywać na naszym serwerze.<br>
                                Uwzględnij ich historię.
                            </label>
                            <textarea maxlength="4500" required type="text" class="form-control" name="character_idea">{{ $application->character_idea }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Streamujesz albo nagrywasz rozgrywkę na swoje kanały?<br>
                                Jeśli tak, pokaż nam nagrania z przykładem Twojego RP.
                            </label>
                            <textarea maxlength="2000" required type="text" class="form-control" name="streamer">{{ $application->streamer }}</textarea>
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
                            <textarea maxlength="2000" required type="text" class="form-control" name="rules_opinion">{{ $application->rules_opinion }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Do czego służą komendy <code>!me</code> i <code>!do</code>?<br>
                                Jak ich używać?
                            </label>
                            <textarea maxlength="2000" required type="text" class="form-control" name="me_do">{{ $application->me_do }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Czy korzystając z komendy <code>!do</code>, możesz skłamać?
                            </label>
                            <textarea maxlength="2000" required type="text" class="form-control" name="do_lying">{{ $application->do_lying }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Napisz, co to jest <code>OOC</code> i <code>IC</code>.<br>
                                Czym różnią się te strefy?
                            </label>
                            <textarea maxlength="2000" required type="text" class="form-control" name="ooc_vs_ic">{{ $application->ooc_vs_ic }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Czy zabójstwo innej postaci z zemsty jest dozwolone?
                            </label>
                            <textarea maxlength="2000" required type="text" class="form-control" name="revenge_kill">{{ $application->revenge_kill }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Wyjaśnij, co to jest <abbr title="Brutally Wounded">BW</abbr>.
                            </label>
                            <textarea maxlength="2000" required type="text" class="form-control" name="brutally_wounded">{{ $application->brutally_wounded }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Wyjaśnij, czym jest metagaming.<br>
                                Czy można go używać w grze?
                            </label>
                            <textarea maxlength="2000" required type="text" class="form-control" name="meta_gaming">{{ $application->meta_gaming }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Wyjaśnij, czym jest powergaming.
                            </label>
                            <textarea maxlength="2000" required type="text" class="form-control" name="power_gaming">{{ $application->power_gaming }}</textarea>
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
                            <textarea maxlength="4500" required type="text" class="form-control" name="rp_action_1">{{ $application->rp_action_2 }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                Spotykasz osobę która 10 minut wcześniej doprowadziła twoją postać do <abbr title="Brutally Wounded">BW</abbr>?<br>
                                Co robisz, jak się zachowujesz?
                            </label>
                            <textarea maxlength="4500" required type="text" class="form-control" name="rp_action_2">{{ $application->rp_action_2 }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                Zostałeś zaatakowany przez pięciu napastników, którzy wszyscy skierowali swoje bronie w Twoją stronę.<br>
                                Trzymasz ręce w górze, ale w Twoim plecaku znajduje się broń maszynowa. Czy masz możliwość obrony w takiej sytuacji?<br>
                            </label>
                            <select class="form-control" name="rp_action_3">
                                <option value="" selected disabled hidden>{{ $application->rp_action_3 }}</option>
                                <option value="Tak">Tak</option>
                                <option value="Nie">Nie</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                Twoja postać złamała nogę, czy możesz poinformować towarzyszy za pomocą zewnętrzengo komunikatora?
                            </label>
                            <select class="form-control" name="rp_action_4">
                                <option value="" selected disabled hidden>{{ $application->rp_action_4 }}</option>
                                <option value="Tak">Tak</option>
                                <option value="Nie">Nie</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                Zauważyłeś że, któraś z osób obok Ciebie użyła komendy narracyjnej <code>!me</code> w której podała następujące informacje:<br>
                                !do Spogląda na zegarek.
                            </label>
                            <small class="form-text text-muted">
                                Czy ta osoba poprawnie użyła komendy narracyjnej <code>!me</code>?
                            </small>
                            <select class="form-control" name="rp_action_5">
                                <option value="" selected disabled hidden>{{ $application->rp_action_5 }}</option>
                                <option value="Tak">Tak</option>
                                <option value="Nie">Nie</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                Czy podany niżej scenariusz został poprawnie odegrany z wykożystaniem komend narracyjncyh <code>!me</code> i <code>!do</code>?<br>
                                !me jednym szybkim ruchem wyciąga nóż i wycina rękę napastnikowi.<br>
                                !do Napastnikowi wycięto rękę.
                            </label>
                            <select class="form-control" name="rp_action_6">
                                <option value="" selected disabled hidden>{{ $application->rp_action_6 }}</option>
                                <option value="Tak">Tak</option>
                                <option value="Nie">Nie</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                Czy podany niżej scenariusz został poprawnie odegrany z wykożystaniem komend narracyjncyh <code>!me</code> i <code>!do</code>?<br>
                                !me jednym szybkim zwinnym ruchem obezwładnia napastnika.<br>
                                !do Napastnik został obezwładniony.
                            </label>
                            <select class="form-control" name="rp_action_7">
                                <option value="" selected disabled hidden>{{ $application->rp_action_7 }}</option>
                                <option value="Tak">Tak</option>
                                <option value="Nie">Nie</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                Widzisz osobę śpiącą przy kominku, chcesz ją otruć karmiąc ją zepsutą rybą.<br>
                                Czy możesz to zrobić?
                            </label>
                            <select class="form-control" name="rp_action_8">
                                <option value="" selected disabled hidden>{{ $application->rp_action_8 }}</option>
                                <option value="Tak">Tak</option>
                                <option value="Nie">Nie</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                Wchodzisz na serwer świerzo po jego restarcie.<br>
                                Po niecałych dwóch minutach zauważasz bezbroną osobę którą chcesz obezwładnić.<br>
                                Czy możesz to zrobić?
                            </label>
                            <select class="form-control" name="rp_action_9">
                                <option value="" selected disabled hidden>{{ $application->rp_action_9 }}</option>
                                <option value="Tak">Tak</option>
                                <option value="Nie">Nie</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                Czy przebywając w obcej osadzie możesz okraść jej mieszkańców?
                            </label>
                            <select class="form-control" name="rp_action_10">
                                <option value="" selected disabled hidden>{{ $application->rp_action_10 }}</option>
                                <option value="Tak">Tak</option>
                                <option value="Nie">Nie</option>
                            </select>
                        </div>

                        <hr class="mt-5 mb-5">

                        <div class="card bg-light border">
                            <div class="card-body">

                                <h4 class="mb-2">
                                    <span class="fe fe-warning"></span> Uwaga
                                </h4>

                                <p class="small text-muted mb-0">
                                    Zapisz swoją aplikację na komputerze na wypadek utracenia połączenia internetowego albo problemów z systemem podań.<br>
                                    Do tego celu możesz użyć np. wbudowanego w system Notatnika.<br><br>
                                    Pamiętaj, że po wysłaniu aplikacji, nie możesz edytować odpowiedzi. Jej sprawdzenie potrwa maksymalnie do 7 dni roboczych.
                                </p>

                            </div>
                        </div>

                        <!-- Divider -->
                        <hr class="mt-5 mb-5">

                        <!-- Buttons -->
                        <button type="submit" id="submit" class="btn btn-block btn-primary">
                            Wyślij podanie
                        </button>
                        <a href="/" class="btn btn-block btn-link text-muted">
                            Rozmyśliłem się, anuluj
                        </a>
                    </form>
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

    <script>
        $(document).ready(function() {
            $('textarea').each(function() {
                let text_max = $(this).attr('maxlength');
                let text_length = $(this).val().length;
                $('#count_' + $(this).attr('name')).text(text_length);
                $(this).after('<div class="text-right small text-muted"><span id="count_' + $(this).attr('name') + '">' + text_length + '</span> / ' + text_max + '</div>');
            });

        });
        $('textarea').each(function() {
            let text_max = $(this).attr('maxlength');

            $(this).keyup(function() {
                let text_length = $(this).val().length;
                $('#count_' + $(this).attr('name')).text(text_length);
            });
            $(this).text($(this).val().substring(0, text_max));
        });
    </script>

    </body>
@endsection
