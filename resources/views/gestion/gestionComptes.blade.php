@extends('layouts.app')

@section('custom-css')
    @vite('resources/css/gestionComptes.css')
@endsection

@section('content')
    @include('sidebar')

    @if($user->isGestionnaire())
        @if(isset($listeComptes) and sizeof($listeComptes) > 0)
            <div class="transaction-content">
                <div class="tableTitle">
                    <h1>Liste des comptes</h1>
{{--                    <form method="get" action="/searchCompte" class="tabform">--}}
{{--                        @csrf--}}
{{--                        @method("get")--}}
{{--                        <input class="searchInput" type="number" name="searchCompteId">--}}
{{--                        <button class="btnSearch ">--}}

{{--                        </button>--}}
{{--                        @error('searchCompteId')--}}
{{--                        <div class="text-danger">{{$message}}</div>--}}
{{--                        @enderror--}}
{{--                    </form>--}}
                    <form method="get" action="/searchCompte" class="form-inline d-flex">
                        @csrf
                        @method("get")
                        <input class="form-control mr-sm-2 rounded-0 searchInput" type="number" name="searchCompteId" placeholder="Chercher Id">
                        <button class="btnSearch" type="submit">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M14.5 14.5L19 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        @error('searchCompteId')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </form>
                </div>
                <table class="tableDashboard">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Numéro de compte</th>
                            <th>Code banque</th>
                            <th>Code guichet</th>
                            <th>Clé RIB</th>
                            <th>Solde</th>
                            <th>Type du compte</th>
                            <th>Statut</th>
                            <th>Id Utilisateur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($listeComptes as $compte)

                            <tr>
                                <th class="tableId">
                                    @if( $listeComptesActifs->contains($compte->id))
                                        <a class="btnLink" href="/compteinfo/{{$compte->id}}">
                                            {{$compte->id}}
                                        </a>
                                    @else
                                        {{$compte->id}}
                                    @endif

                                </th>
                                <td class="neoNumber">{{$compte->numero_de_compte}}</td>
                                <td class="neoNumber">{{$compte->code_banque}}</td>
                                <td class="neoNumber">{{$compte->code_guichet}}</td>
                                <td class="neoNumber">{{$compte->cle_RIB}}</td>
                                <td class="neoNumber tableTypeGreen">{{$compte->solde}}</td>
                                <td>{{$compte->type_compte}}</td>

                                @if($compte->statut == "accepte")
                                    <td class="tableTypeGreen">{{$compte->statut}}</td>
                                @elseif($compte->statut == "rejete")
                                    <td class="tableTypeRed">{{$compte->statut}}</td>
                                @else
                                    <td class="tableTypeOrange">En Attente</td>
                                @endif
                                <td class="tableId">{{$compte->user_id}}</td>
                                <td>
                                    <a onclick="return confirm('Voulez-vous vraiment suspendre ce compte ?')" class="btn btn-danger" href="/suspendre/{{$compte->id}}">Suspendre le compte</a>
                                </td>
                            </tr>
                      @endforeach
                    </tbody>
                </table>
                @if($listeComptes instanceof \Illuminate\Pagination\LengthAwarePaginator || $listeComptes instanceof \Illuminate\Pagination\Paginator)
                    {{ $listeComptes->links('pagination::bootstrap-5') }}
                @endif
            </div>
        @endif
    @endif
@endsection
