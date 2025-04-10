@extends('layouts.app', ['viewTitle' => 'Zawodnicy', 'centerText' => true])

    {{-- JS scripts --}}
@section('scripts')
    <script src="{{ asset('./js/contenders.js') }}"></script>
@endsection


@section('content')
    <h1>Zawodnicy</h1>
    <p>Lista zawodników</p>

    {{-- Add Contender Btn --}}
    <button type="button" class="btn btn-warning mx-auto d-block w-25 my-4 btn-lg" data-bs-toggle="modal"
        data-bs-target=" #contenderCreateModal">
        Dodaj zawodnika</button>
    {{-- End Add Contender Btn --}}



    {{-- Contender Table --}}
    <div class="table-resonsive">
        <table class="table table-hover ">
            <thead>
                <caption>
                    Zawodnicy
                </caption>
                <tr class="table-warning">
                    <th>#</th>
                    <th>Imie</th>
                    <th>Nazwisko</th>
                    <th>Klasa</th>
                    <th>Płeć</th>
                    <th>Status</th>
                    <th>Drużyna</th>
                    <th>Akcja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contenders as $contender)
                    <tr>
                        <th class="scope-row">{{ $loop->iteration }}</th>
                        <td>{{ $contender->name }}</td>
                        <td>{{ $contender->last_name }}</td>
                        <td>{{ $contender->class }}</td>
                        <td>{{ $contender->gender }}</td>
                        <td>{{ $contender->status }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-tertiary dropdown-toggle border border-tertiary-subtle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    BRAK {{-- TODO: drużyna tutaj :3 --}}
                                </button>
                                <ul class="dropdown-menu user-select-none">
                                    <li><a class="dropdown-item"
                                            onclick="createToast('Przypisano {{ $contender->name }} {{ $contender->last_name }} do drużyny ...')">Przypisz
                                            do drużyny</a></li>
                                    <li><a class="dropdown-item text-danger"
                                            onclick="createToast('Usunięto {{ $contender->name }} {{ $contender->last_name }} z drużyny ...')">Usuń
                                            z
                                            drużyny</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                            <button class="btn btn-danger btn-sm" 
                                    id="deleteBtn"
                                    contenderID="{{ $contender->id }}" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#contenderDeleteModal">
                            <i class="fa-solid fa-trash-can"></i></button>
                            {{-- <button type="button" class="btn btn-danger btn-sm"
                                onclick="createToast('Dodano: {{ $contender->name }} {{ $contender->last_name }}');">
                                <i class="fa-solid fa-trash"></i>
                            </button> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- End Contender Table --}}

@endsection

@section('extras')

    {{-- Add Contender Modal --}}
    <div class="modal fade" id="contenderCreateModal" tabindex="-1" aria-labelledby="contenderCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="contenderCreateModalLabel">Dodaj Zawodnika</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('contender.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="fName" class="form-label">Imię</label>
                                    <input type="text" name="name" id="fName" class="form-control "
                                        placeholder="Imię zawodnika" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="fSurname" class="form-label">Nazwisko</label>
                                    <input type="text" name="last_name" id="fSurname" class="form-control "
                                        placeholder="Nazwisko zawodnika" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="fGrade" class="form-label">Klasa</label>
                                    <input type="text" name="class" id="fGrade" class="form-control "
                                        placeholder="Klasa zawodnika" aria-describedby="fGradeHelp" />
                                    <small id="fGradeHelp" class="text-muted">Max. 3 znaki</small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">

                                    <label class="form-label">Płeć</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" value="K" />
                                        <label class="form-check-label" for="gender"> Kobieta </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" value="M"
                                            checked />
                                        <label class="form-check-label" for="gender"> Mężczyzna </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">

                                    <label class="form-label">Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="C"
                                            checked />
                                        <label class="form-check-label" for="status"> Cywil </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="W" />
                                        <label class="form-check-label" for="status"> Wojskowy </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                        <button type="submit" class="btn btn-primary" id="fSaveButton">Zapisz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Add Contender Modal --}}

    {{-- * szczerze myślałem aby dać ale trzeba by jakoś zwrócić dane z forma ze dodano z powoodzeniem, moze jest cos ale nwm --}}


    {{-- Delete Contender Modal --}}
    <div class="modal fade" id="contenderDeleteModal" tabindex="-1" aria-labelledby="contenderDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="contenderDeleteModalLabel">Usuń zawodnika</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Czy na pewno chcesz usunąć tego zawodnika?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
              <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Usuń</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    {{-- End Delete Contender Modal --}}
    
    <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="toastTemplate">
            <div class="toast-header">
                <strong class="me-auto">JustSwim</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                See? Just like this.
            </div>
        </div>

    </div>
@endsection

