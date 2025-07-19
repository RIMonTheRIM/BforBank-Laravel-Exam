@extends('layouts.app')

@section('custom-css')
    @vite('resources/css/compteInfo.css')
@endsection

@section('content')
    @include('sidebar')

    @if($user->isGestionnaire())
        @if(isset($compte))
            <div class="compteInfoWrapper">
                <div class="compteWrapper">
                    <div class="compteCard">
                        <h1 class="">Informations du compte</h1>
                        <div><b>Identifiant: </b>{{$compte->id}}</div>
                        <div><b>Numéro de compte: </b>{{$compte->numero_de_compte}}</div>
                        <div><b>Code banque: </b>{{$compte->code_banque}}</div>
                        <div><b>Code guichet: </b>{{$compte->code_guichet}}</div>
                        <div><b>Clé RIB: </b>{{$compte->cle_RIB}}</div>
                        <div><b>Solde: </b>{{$solde}} Fcfa</div>
                        <div><b>Type du compte: </b>{{$compte->type_compte}}</div>
                        <div><b>Statut: </b>{{$compte->statut}}</div>
                        <div><b>Identifiant de l'utilisateur: </b>{{$compte->user_id}}</div>
                        <button class="showHistorique" onclick="toggleHisto()">Afficher l'historique</button>
                    </div>
                    <div class="compteCard">
                        <h1 class="">Informations de l'utilisateur</h1>
                        <div><b>Identifiant: </b>{{$utilisateur->id}}</div>
                        <div><b>Nom: </b>{{$utilisateur->nom}}</div>
                        <div><b>Prénom: </b>{{$utilisateur->prenom}}</div>
                        <div><b>Email: </b>{{$utilisateur->email}}</div>
                        <div><b>Téléphone: </b>{{$utilisateur->telephone}}</div>
                    </div>
                </div>
                <div class="transactionsWrapper" id="histoInfo">
                    <h1>Historique du compte</h1>
                    <div class="transactions">
                        @foreach($transactionsList as $transaction)
                            <div class="transactionsCard">
                                @if($transaction->type == "retrait")
                                    <div class="transactionsCard-logo retraitLogo"></div>{{--DONE: logo--}}
                                    <div class="transactionsCard-content">
                                        <div><b>RETRAIT:</b></div>
                                        <div class="feint">Expéditeur:
                                            @if($transaction->comptebancaire_id == $compte->id)
                                                Ce compte
                                            @else
                                                {{$transaction->comptebancaire_id}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="transactionsCard-solde">
                                        <div class="transactionsCard-solde-montant red"><b>-{{$transaction->montant}} XOF</b></div>
                                        <div class="transactionsCard-solde-date feint">{{$transaction->date_transaction}}</div>
                                    </div>
                                @elseif($transaction->type == "depot")
                                    <div class="transactionsCard-logo depotLogo"></div>{{--DONE: logo--}}
                                    <div class="transactionsCard-content">
                                        <div><b>DEPOT:</b></div>
                                        <div class="feint">Expéditeur:
                                            @if($transaction->comptebancaire_id == $compte->id)
                                                Ce compte
                                            @else
                                                {{$transaction->comptebancaire_id}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="transactionsCard-solde">
                                        <div class="transactionsCard-solde-montant green"><b>+{{$transaction->montant}} XOF</b></div>
                                        <div class="transactionsCard-solde-date feint">{{$transaction->date_transaction}}</div>
                                    </div>
                                @else
                                    <div class="transactionsCard-logo virementLogo"></div>{{--DONE: logo--}}
                                    <div class="transactionsCard-content">
                                        <div><b>VIREMENT:</b></div>
                                        <div class="feint">Expéditeur:
                                            @if($transaction->comptebancaire_id == $compte->id)
                                                Ce compte
                                            @else
                                                {{$transaction->comptebancaire_id}}
                                            @endif
                                        </div>
                                        <div class="feint">Destinataire:
                                            @if($transaction->compte_dest_id == $compte->id)
                                                Ce compte
                                            @else
                                                {{$transaction->compte_dest_id}}
                                            @endif
                                        </div>
                                    </div>
                                    @if($transaction->comptebancaire_id == $compte->id)
                                        <div class="transactionsCard-solde">
                                            <div class="transactionsCard-solde-montant red"><b>-{{$transaction->montant}} XOF</b></div>
                                            <div class="transactionsCard-solde-date feint">{{$transaction->date_transaction}}</div>
                                        </div>
                                        {{--DONE: change color--}}
                                    @else
                                        <div class="transactionsCard-solde">
                                            <div class="transactionsCard-solde-montant green"><b>+{{$transaction->montant}} XOF</b></div>
                                            <div class="transactionsCard-solde-date feint">{{$transaction->date_transaction}}</div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                        @if($transactionsList->hasPages())
                            <div class="paginationWrapper">
                                {{ $transactionsList->appends(['showTable' => '1'])->links('pagination::bootstrap-5') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('showTable') === '1') {
            histo.classList.add("show");
        }
    });
    const histo = document.getElementById("histoInfo");
    function toggleHisto(){
        histo.classList.add("show");
        console.log("showingngngng")
    }
</script>
{{--            DONE: button to show account history paginated--}}
        @endif
    @endif
@endsection
