
@extends('layouts.app')

@section('custom-css')
    @vite('resources/css/dashboard.css')
@endsection

@section('content')
{{--<div class="dashboardWrapper">--}}
{{--    <div class="dashcontent">--}}
{{--        <div class="right-wrapper">--}}
{{--            <div class="cartebancaire">--}}
{{--                <div class="contentCarte">--}}
{{--                    <div class="carteTop">--}}
{{--                        <div class="carteLogo"></div>--}}
{{--                    </div>--}}
{{--                    <div class="carteBottom">--}}
{{--                        <div class="cartePuce"></div>--}}
{{--                        <div class="carteNum">{{$numCarte}}</div>--}}
{{--                        <div class="carteDate">EXP {{$dateCarte}}</div>--}}
{{--                        <div class="carteNom">{{strtoupper(Auth::user()->nom)}} {{Auth::user()->prenom}}</div>--}}
{{--                    </div>--}}

{{--                    --}}


{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<table>
    <tr>
        <td colspan="2">Carte Bancaire</td>
        <td></td>
        <td></td>
        <td colspan="2">BforBank</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="6">{{$numCarte}}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2">EXP {{$dateCarte}}</td>
    </tr>
    <tr>
        <td colspan="2">{{strtoupper(Auth::user()->nom)}} {{Auth::user()->prenom}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
@endsection
