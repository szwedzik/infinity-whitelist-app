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
                                Przegląd podań
                            </h1>
                        </div>
                    </div> <!-- / .row -->
                </div> <!-- / .header-body -->
                <!-- Footer -->
                <div class="header-footer">
                        <div class="card">
                            <div class="card-header pb-0 mb-0">
                                <ul class="nav nav-tabs nav-tabs-sm nav-overflow">
                                    <li class="nav-item">
                                        <a href="/admin/" class="nav-link active">
                                            Do sprawdzenia ({{ $toCheck }})
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/admin/accepted" class="nav-link">
                                            Przyjęte ({{ $accepted }})
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/admin/rejected" class="nav-link">
                                            Odrzucone ({{ $rejected }})
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/admin/returned" class="nav-link">
                                            Zwrócone do poprawy ({{ $returned }})
                                        </a>
                                    </li>
                                </ul>

                            </div>
                            @if($applications->count() > 0)
                                <div class="table-responsive">
                                    <table id="browse" class="table table-sm card-table">
                                        <thead>
                                        <tr>
                                            <th>
                                                Nick
                                            </th>
                                            <th>
                                                Discord ID
                                            </th>
                                            <th>
                                                Steam ID
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th>
                                                Kiedy
                                            </th>
                                            <th class="text-right">
                                                Akcja
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($priorityApps->count() > 0)
                                            @foreach($priorityApps as $priorityApp)
                                                <tr class="bg-warning text-dark">
                                                    <td>
                                                        {{ $priorityApp->discord_id }}
                                                    </td>
                                                    <td>
                                                        {{ $priorityApp->steam_url }}
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-dark my-2"><i class="fe fe-bolt"></i> Priorytetowa</span>
                                                    </td>
                                                    <td>
                                                        {{ $priorityApp->created_at }}
                                                    </td>
                                                    <td class="text-right">
                                                        <!-- Button -->
                                                        <a href="/admin/{{ $priorityApp->id }}" class="btn btn-sm btn-dark">
                                                            Sprawdź
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        @foreach($applications as $application)
                                            <tr>
                                                <td>
                                                    {{ $application->discord_username }}
                                                </td>
                                                <td>
                                                    {{ $application->discord_id }}
                                                </td>
                                                <td>
                                                    {{ $application->steam_url }}
                                                </td>
                                                <td>
                                                    <span class="badge badge-soft-primary"><i class="fe fe-clock"></i> W trakcie sprawdzania</span>
                                                </td>
                                                <td>
                                                    {{ $application->created_at }}
                                                </td>
                                                <td class="text-right">
                                                    <!-- Button -->
                                                    <a href="/admin/{{ $application->id }}" class="btn btn-sm btn-primary">
                                                        Sprawdź
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif ($priorityApps->count() > 0)
                                <div class="table-responsive">
                                    <table id="browse" class="table table-sm card-table">
                                        <thead>
                                        <tr>
                                            <th>
                                                Nick
                                            </th>
                                            <th>
                                                Discord ID
                                            </th>
                                            <th>
                                                Steam ID
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th>
                                                Kiedy
                                            </th>
                                            <th class="text-right">
                                                Akcja
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($priorityApps as $priorityApp)
                                            <tr class="bg-warning text-dark">
                                                <td>
                                                    {{ $priorityApp->discord_username }}
                                                </td>
                                                <td>
                                                    {{ $priorityApp->discord_id }}
                                                </td>
                                                <td>
                                                    {{ $priorityApp->steam_url }}
                                                </td>
                                                <td>
                                                    <span class="badge badge-warning my-2"><i class="fe fe-bolt"></i> Priorytetowa</span>
                                                </td>
                                                <td>
                                                    {{ $priorityApp->created_at }}
                                                </td>
                                                <td class="text-right">
                                                    <!-- Button -->
                                                    <a href="/admin/{{ $priorityApp->id }}" class="btn btn-sm btn-primary">
                                                        Sprawdź
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="card-body text-center">

                                    <!-- Image -->
                                    <img src="/assets/img/illustrations/happiness.svg" alt="..." class="img-fluid" style="max-width: 182px;">

                                    <!-- Title -->
                                    <h1 class="mt-3">
                                        Brak podań w tej kategorii. Yay! 😄
                                    </h1>

                                    <!-- Subtitle -->
                                    <p class="text-muted">
                                        Czysto na błysk.<br>
                                        Jeśli desperacko pragniesz podań, zmień kryteria wyszukiwania albo zaczekaj na nowe.
                                    </p>

                                </div>
                            @endif
                        </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JavaScript libraries -->
    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
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
    $('#browse').DataTable( {
        "order": [[ 3, "desc"]],
        "lengthChange": false,
        "language": {"search": "Szukaj"}
    });
});
</script>
    </body>
@endsection
