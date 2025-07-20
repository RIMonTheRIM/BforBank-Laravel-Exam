@extends('layouts.app')



@section('content')
    @include('sidebar')

    @if($user->isGestionnaire())


        <style>
            .demande-content-wrapper{
                display: flex;
                height: 100%;
                width: 100%;
                align-items: center;
                justify-content: center;
            }
            .demande-content{
                margin-inline:1em ;
                width: 50%;
            }
            .tableTitle{
                color:#456882;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 5em;
            }
            .tableTitle h1{
                padding: 0;
                margin: 0;
                align-self: center;
                flex-grow: 1 ;
            }
            .btnSearch{
                background-color: #456882;
                color: #d2c1b6;
                height: 100%;
                margin: 0;

                padding: 0.5em;
                border: none;
                transition: all 100ms;
            }
            .btnSearch svg{
                height: 25px;
            }
            .btnSearch:hover{
                background-color: #d2c1b6;
                color: #456882;
            }
            .formDemande{
                display: flex;
            }
            table{
                width: 100%;
            }

        </style>
        <div class="demande-content-wrapper">
            <div class="demande-content">
                <div class="gestion-wrapper">
                    <div class="tableTitle">
                        <h1>Historique des demandes</h1>
{{--                        <form method="get" action="/searchDemande" class="tabform">--}}
{{--                            @csrf--}}
{{--                            @method("GET")--}}
{{--                            <input type="number" name="searchIdDemande">--}}
{{--                            <button class="btn btn-primary">Search (logo)</button>--}}
{{--                            @error('searchIdDemande')--}}
{{--                                <div class="text-danger">{{$message}}</div>--}}
{{--                            @enderror--}}
{{--                        </form>--}}
                        <form method="get" action="/searchDemande"  class="form-inline d-flex">
                            @csrf
                            @method("get")
                            <input class="form-control mr-sm-2 rounded-0 searchInput" type="number"  name="searchIdDemande" placeholder="Id Compte Bancaire">
                            <button class="btnSearch" type="submit">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10" cy="10" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14.5 14.5L19 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            @error('searchIdDemande')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </form>
                    </div>
                    <table class="tableDashboard">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>CompteBancaire</th>
                            <th>TypeDemande</th>
                            <th>Statut</th>
                            <th>Raison rejet</th>
                            <th>Date demande</th>
                            <th>Date traitement</th>
                        </tr>
                        </thead>
                    @if(isset($histoDemande) and sizeof($histoDemande) > 0)
                            <tbody>
                            @foreach($histoDemande as $demande)
                                @if($demande->statut != "en_Attente")

                                    <tr>
                                        <th class="tableId">{{$demande->id}}</th>
                                        <td>
                                            @if($demande->typeDemande == "validation" and $demande->statut == "accepte")
                                                <a href="/compteinfo/{{$demande->comptebancaire_id}}" class="btnLink">{{$demande->comptebancaire_id}}</a>
                                            @elseif($demande->typeDemande == "cloture" and $demande->statut == "rejete")
                                                <a href="/compteinfo/{{$demande->comptebancaire_id}}" class="btnLink">{{$demande->comptebancaire_id}}</a>
                                            @else
                                                <span class="tableId">{{$demande->comptebancaire_id}}</span>
                                            @endif

                                        </td>
                                        @if($demande->typeDemande == "validation")
                                            <td class="tableTypeGreen">{{$demande->typeDemande}}</td>
                                        @elseif($demande->typeDemande == "cloture")
                                            <td class="tableTypeRed">{{$demande->typeDemande}}</td>
                                        @else
                                            <td class="tableTypeOrange">{{$demande->typeDemande}}</td>
                                        @endif

                                        @if($demande->statut == "accepte")
                                            <td class="tableTypeGreen">{{$demande->statut}}</td>
                                        @elseif($demande->statut == "rejete")
                                            <td class="tableTypeRed">{{$demande->statut}}</td>
                                        @else
                                            <td class="tableTypeOrange">En Attente</td>
                                        @endif
                                        <td>{{$demande->raison_rejet}}</td>
                                        <td class="tableId">{{$demande->date_demande}}</td>
                                        <td class="tableId">{{$demande->date_traitement}}</td>
                                    </tr>

                                @endif
                            @endforeach
                                    </tbody>

                    @endif
                    </table>
                    {{ $histoDemande->links('pagination::bootstrap-5') }}
                </div>
            </div>


            <div class="demande-content">
                <div class="gestion-wrapper">
                    <div class="tableTitle">
                        <h1>Demandes en attente</h1>
{{--                        <form method="get" action="/searchDemandeAttente" class="tabform">--}}
{{--                            @csrf--}}
{{--                            @method("GET")--}}
{{--                            <input type="number" name="searchIdAttente">--}}
{{--                            <button class="btn btn-primary">Search (logo)</button>--}}
{{--                            @error('searchIdAttente')--}}
{{--                            <div class="text-danger">{{$message}}</div>--}}
{{--                            @enderror--}}
{{--                        </form>--}}
                        <form method="get" action="/searchDemandeAttente"  class="form-inline d-flex">
                            @csrf
                            @method("get")
                            <input class="form-control mr-sm-2 rounded-0 searchInput" type="number"  name="searchIdAttente" placeholder="Id Compte Bancaire">
                            <button class="btnSearch" type="submit">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10" cy="10" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14.5 14.5L19 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            @error('searchIdAttente')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </form>
                    </div>
                        <table class="tableDashboard">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>CompteBancaire</th>
                                <th>TypeDemande</th>
                                <th>Statut</th>
                                <th>Date demande</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            @if(isset($listDemandeAttente) and sizeof($listDemandeAttente) > 0)
                                <tbody>
                                @foreach($listDemandeAttente as $demande)
                                @if($demande->statut == "en_Attente")

                                    <tr>
                                        <th class="tableId">{{$demande->id}}</th>
                                        <td><a href="/compteinfo/{{$demande->comptebancaire_id}}" class="btnLink">{{$demande->comptebancaire_id}}</a></td>

                                        @if($demande->typeDemande == "validation")
                                            <td class="tableTypeGreen">{{$demande->typeDemande}}</td>
                                        @elseif($demande->typeDemande == "cloture")
                                            <td class="tableTypeRed">{{$demande->typeDemande}}</td>
                                        @else
                                            <td class="tableTypeOrange">{{$demande->typeDemande}}</td>
                                        @endif


                                        <td class="tableTypeOrange">En Attente</td>

                                        <td class="tableId">{{$demande->date_demande}}</td>
                                        <td>
                                            <a class="btn btn-info" href="/valider/{{$demande->id}}">Valider</a>
                                            <a class="btn btn-danger" id="rejeterActivate" onclick="showForm({{$demande->id}})">Rejeter</a>

                                            {{-- hidden form --}}
                                            <form style="display: none" id="raisonRejetForm-{{$demande->id}}"  method="post" action="/rejeter/{{$demande->id}}" class="form-inline">
                                                @csrf
                                                @method("POST")
                                                <input class="form-control mr-sm-2 rounded-0 searchInput" type="text"  id="raisonRejet"  name="raisonRejet" placeholder="Raison de rejet">
                                                <button class="btnSearch" type="submit" onclick="closeForm({{$demande->id}})">
                                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </button>
                                                @error('searchIdAttente')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </form>
                                        </td>
                                    </tr>


                                @endif
                            @endforeach
                                </tbody>

                            @endif
                        </table>
{{--                        --}}{{-- Liens de pagination --}}{{-- @if($transactionsList->hasPages())--}}
                        {{ $listDemandeAttente->links('pagination::bootstrap-5') }}

                </div>
            </div>
            <script>
                function showForm(id){
                    console.log("SHOW FORM");
                    let rejetForm = document.getElementById("raisonRejetForm-" + id);
                    rejetForm.style.display = "flex";
                }
                function closeForm(id){
                    console.log("CLOSE FORM");
                    let rejetForm = document.getElementById("raisonRejetForm-" + id);
                    rejetForm.style.display = "none";
                }
            </script>
        </div>
        {{--TABLE HISTORIK--}}

    @endif
@endsection
