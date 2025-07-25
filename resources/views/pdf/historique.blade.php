
@extends('layouts.app')

@section('custom-css')

@endsection

@section('content')
    <style>

    </style>
    <div>
        <div>
            @if(isset($transactionsList))
                <h2>Historique des transactions</h2>
                <table>
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
