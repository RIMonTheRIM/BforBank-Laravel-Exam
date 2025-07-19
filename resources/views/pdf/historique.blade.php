
@extends('layouts.app')

@section('custom-css')
    @vite('resources/css/dashboard.css')
@endsection

@section('content')
    <div class="left-wrapper">
        <div class="left-wrapper-header">
            <h3 class="bigTitle dashTitle">Historique des transactions</h3>
            <a href="" class="downloadLink">Télécharger</a>
        </div>
        <div class="transactions">
            @if(isset($transactionsList))
                @foreach($transactionsList as $transaction)
                    <div class="transactionsCard">
                        @if($transaction->type == "retrait")
                            <div class="transactionsCard-logo retraitLogo"></div>{{--DONE: logo--}}
                            <div class="transactionsCard-content">
                                <div><b>RETRAIT:</b></div>
                                <div class="feint">Expéditeur: {{$transaction->comptebancaire_id}}</div>
                            </div>
                            <div class="transactionsCard-solde">
                                <div class="transactionsCard-solde-montant red"><b>-{{$transaction->montant}} XOF</b></div>
                                <div class="transactionsCard-solde-date feint">{{$transaction->date_transaction}}</div>
                            </div>
                        @elseif($transaction->type == "depot")
                            <div class="transactionsCard-logo depotLogo"></div>{{--DONE: logo--}}
                            <div class="transactionsCard-content">
                                <div><b>DEPOT:</b></div>
                                <div class="feint">Expéditeur: {{$transaction->comptebancaire_id}}</div>
                            </div>
                            <div class="transactionsCard-solde">
                                <div class="transactionsCard-solde-montant green"><b>+{{$transaction->montant}} XOF</b></div>
                                <div class="transactionsCard-solde-date feint">{{$transaction->date_transaction}}</div>
                            </div>
                        @else
                            <div class="transactionsCard-logo virementLogo"></div>{{--DONE: logo--}}
                            <div class="transactionsCard-content">
                                <div><b>VIREMENT:</b></div>
                                <div class="feint">Expéditeur: {{$transaction->comptebancaire_id}}</div>
                                <div class="feint">Destinataire: {{$transaction->compte_dest_id}}</div>
                            </div>
                            @if($transaction->comptebancaire_id == $id)
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
            @endif
        </div>
    </div>
@endsection
