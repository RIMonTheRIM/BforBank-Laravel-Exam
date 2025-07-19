@extends('layouts.app')
@section('custom-css')
    @vite('resources/css/accountchoice.css')
@endsection
@section('content')
    @include('sidebar')
    <div class="choiceSplitWrapper">
        <div class="choiceSplit">
            <h1 class="choiceTitle">Un compte adapté à vos besoins.</h1>
            <div class="chocieSplitContent">
                <div class="compteCourant">
                    <h1 class="compteChoiceTitle">Compte courant</h1>
                    <div class="infoList">
                        <div class="infoItem"><svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            Dépôts et retraits illimités
                        </div>
                        <div class="infoItem"><svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            Virements et paiements en ligne sans restriction
                        </div>
                        <div class="infoItem"><svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            Accès instantané à vos fonds
                        </div>
                        <div class="infoItem"><svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            Idéal pour les dépenses quotidiennes
                        </div>
                    </div>
                    <a class="btn btn-primary" onclick="showNotification()" href="/demande/courant">Ouvrir</a>
                </div>
                <div class="compteEpargne">
                    <h1 class="compteChoiceTitle">Compte épargne</h1>
                    <div class="infoList">
                        <div class="infoItem"><svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            Dépôts illimités à tout moment</div>
                        <div class="infoItem"><svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            Taux d’intérêt de 3% par an sur le solde</div>
                        <div class="infoItem"><svg  viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            Retraits limités à 2 fois par mois</div>
                        <div class="infoItem"><svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            Parfait pour faire fructifier votre argent en toute tranquillité</div>
                    </div>
                    <a class="btn btn-primary" href="/demande/epargne">Ouvrir</a>
                </div>
            </div>
        </div>
    </div>

{{--DONE: gérer la notification--}}

@endsection
