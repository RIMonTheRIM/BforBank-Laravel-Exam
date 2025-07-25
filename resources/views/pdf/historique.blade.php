
@extends('layouts.app')

@section('custom-css')

@endsection

@section('content')
    <style>
        .histoWrapper{
            font-family: Roboto, Arial, sans-serif;
        }
        .tableHisto{
            border: 1px black solid;
            border-collapse: collapse;
            text-align: center;
        }
        .tableHisto tr, .tableHisto td, .tableHisto th{
            border: 1px black solid;
            text-align: center;
        }
    </style>
    <div>
        <div class="histoWrapper">
            @if(isset($transactionsList))
                <h2 class="titreHisto">Historique des transactions</h2>
                <table class="tableHisto">
                    <tr>
                        <th>Id</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Date transaction</th>
                        <th>Id du compte</th>
                        <th>Numéro du destinataire</th>
                    </tr>

                    @foreach($transactionsList as $transaction)
                        <tr>
                            <th>{{$transaction->id}}</th>
                            <td>{{$transaction->type}}</td>
                            <td>{{$transaction->montant}}</td>
                            <td>{{$transaction->date_transaction}}</td>
                            <td>{{$transaction->comptebancaire_id}}</td>
                            <td>{{$transaction->compte_dest_id}}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
@endsection
