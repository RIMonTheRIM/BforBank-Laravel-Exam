@extends('layouts.app')

@section('custom-css')
    @vite('resources/css/gestionTransactions.css')
@endsection

@section('content')
    @include('sidebar')

    @if($user->isGestionnaire())
        @if(isset($listeTransactions) and sizeof($listeTransactions) > 0)
            <div class="transaction-content">
                <div class="tableTitle">
                    <h1>Historique des transactions</h1>
{{--                    <form method="get" action="/searchTransaction" class="tabform">--}}
{{--                        @csrf--}}
{{--                        @method("get")--}}
{{--                        <input type="number" name="searchTransactionId" value="{{ request('searchTransactionId') }}">--}}
{{--                        <button class="btn btn-primary">Search (logo)</button>--}}
{{--                        @error('searchTransactionId')--}}
{{--                        <div class="text-danger">{{$message}}</div>--}}
{{--                        @enderror--}}
{{--                    </form>--}}
                    <form method="get" action="/searchTransaction" class="form-inline d-flex">
                        @csrf
                        @method("get")
                        <input class="form-control mr-sm-2 rounded-0 searchInput" type="number" name="searchTransactionId" placeholder="Id Compte Bancaire" value="{{ request('searchTransactionId') }}">
                        <button class="btnSearch" type="submit">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M14.5 14.5L19 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        @error('searchTransactionId')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </form>
                </div>
                <table class="tableDashboard">
                    <thead>
                    <tr class="table-dark">
                        <th>Id</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Date de transaction</th>
                        <th>Id compte bancaire</th>
                        <th>Id compte destinataire</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listeTransactions as $transaction)

                        <tr>
                            <th class="tableId">{{$transaction->id}}</th>

                            @if($transaction->type == "depot")
                                <td class="tableTypeGreen">{{$transaction->type}}</td>
                            @elseif($transaction->type == "retrait")
                                <td class="tableTypeRed">{{$transaction->type}}</td>
                            @else
                                <td class="tableTypeOrange">{{$transaction->type}}</td>
                            @endif
                            <td class="neoNumber">{{$transaction->montant}}</td>
                            <td class="tableId">{{$transaction->date_transaction}}</td>
                            <td>
                                @if( $listeComptesActifs->contains($transaction->comptebancaire_id))
                                <a href="/compteinfo/{{$transaction->comptebancaire_id}}" class="btnLink">{{$transaction->comptebancaire_id}}</a>
                                @else
                                    <span class="tableId">{{$transaction->comptebancaire_id}}</span>
                                @endif
                            </td>

                            @if($transaction->compte_dest_id == null)
                                <td class="tableId"><i>null</i></td>
                            @else
                                <td class="tableId">{{$transaction->compte_dest_id}}</td>
                            @endif
                            <td>
                                <a onclick="return confirm('Voulez-vous vraiment révoquer cettre transaction ?')" class="btn btn-danger" href="/revoke/{{$transaction->id}}">Révoquer</a>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>

                {{ $listeTransactions->links('pagination::bootstrap-5') }}
            </div>
        @endif
    @endif
@endsection
