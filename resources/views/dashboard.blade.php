@extends('layouts.app')
{{--DONE: don't forget to validate all the forms--}}

@section('custom-css')
    @vite('resources/css/dashboard.css')
@endsection
@section('content')
    @include('sidebar')
    {{--DONE: don't forget to validate all the forms and provide error messages--}}

    <div class="dashboardWrapper">
        <div class="dashcontent">
            @if(isset($transactionsList) && sizeof($transactionsList)>0)
            <div class="dash-left-wrapper">
                <div class="dash-left-wrapper-header">
                    <h3 class="">Historique des transactions</h3>
                    <a href="/download/histo/{{$id}}" class="downloadLinkDark ">
                        <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.22 20.75H5.78C5.43322 20.7359 5.09262 20.6535 4.77771 20.5075C4.4628 20.3616 4.17975 20.155 3.94476 19.8996C3.70977 19.6442 3.52745 19.3449 3.40824 19.019C3.28903 18.693 3.23525 18.3468 3.25 18V15C3.25 14.8011 3.32902 14.6103 3.46967 14.4697C3.61033 14.329 3.80109 14.25 4 14.25C4.19892 14.25 4.38968 14.329 4.53033 14.4697C4.67099 14.6103 4.75 14.8011 4.75 15V18C4.72419 18.2969 4.81365 18.5924 4.99984 18.8251C5.18602 19.0579 5.45465 19.21 5.75 19.25H18.22C18.5154 19.21 18.784 19.0579 18.9702 18.8251C19.1564 18.5924 19.2458 18.2969 19.22 18V15C19.22 14.8011 19.299 14.6103 19.4397 14.4697C19.5803 14.329 19.7711 14.25 19.97 14.25C20.1689 14.25 20.3597 14.329 20.5003 14.4697C20.641 14.6103 20.72 14.8011 20.72 15V18C20.75 18.6954 20.5041 19.3744 20.0359 19.8894C19.5677 20.4045 18.9151 20.7137 18.22 20.75Z" fill="currentColor"></path> <path d="M12 15.75C11.9015 15.7504 11.8038 15.7312 11.7128 15.6934C11.6218 15.6557 11.5392 15.6001 11.47 15.53L7.47 11.53C7.33752 11.3878 7.2654 11.1997 7.26882 11.0054C7.27225 10.8111 7.35096 10.6258 7.48838 10.4883C7.62579 10.3509 7.81118 10.2722 8.00548 10.2688C8.19978 10.2654 8.38782 10.3375 8.53 10.47L12 13.94L15.47 10.47C15.6122 10.3375 15.8002 10.2654 15.9945 10.2688C16.1888 10.2722 16.3742 10.3509 16.5116 10.4883C16.649 10.6258 16.7277 10.8111 16.7312 11.0054C16.7346 11.1997 16.6625 11.3878 16.53 11.53L12.53 15.53C12.4608 15.6001 12.3782 15.6557 12.2872 15.6934C12.1962 15.7312 12.0985 15.7504 12 15.75Z" fill="currentColor"></path> <path d="M12 15.75C11.8019 15.7474 11.6126 15.6676 11.4725 15.5275C11.3324 15.3874 11.2526 15.1981 11.25 15V4C11.25 3.80109 11.329 3.61032 11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5303 3.46967C12.671 3.61032 12.75 3.80109 12.75 4V15C12.7474 15.1981 12.6676 15.3874 12.5275 15.5275C12.3874 15.6676 12.1981 15.7474 12 15.75Z" fill="currentColor"></path> </g></svg>
                    </a>
                </div>
                <div class="transactions">
                    @foreach($transactionsList as $transaction)
                        <div class="transactionsCard">
                            @if($transaction->type == "retrait")
                            <div class="transactionsCard-logo retraitLogo"></div>{{--DONE: logo--}}
                            <div class="transactionsCard-content">
                                <div><b>RETRAIT:</b></div>
                                <div class="feint">Expéditeur:
                                    @if($transaction->comptebancaire_id == $id)
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
                                    @if($transaction->comptebancaire_id == $id)
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
                                    @if($transaction->comptebancaire_id == $id)
                                        Ce compte
                                    @else
                                        {{$transaction->comptebancaire_id}}
                                    @endif
                                </div>
                                <div class="feint">Destinataire:
                                    @if($transaction->compte_dest_id == $id)
                                        Ce compte
                                    @else
                                        {{$transaction->compte_dest_id}}
                                    @endif
                                </div>
                            </div>
                                @if($transaction->comptebancaire_id == $id)
                                <div class="transactionsCard-solde">
                                    <div class="transactionsCard-solde-montant red"><b>-{{$transaction->montant}} XOF</b></div>
                                    <div class="transactionsCard-solde-date feint">{{$transaction->date_transaction}}</div>
                                </div>
                                    {{--TODO: change color--}}
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
                                    {{ $transactionsList->links('pagination::bootstrap-5') }}
                                </div>
                    @endif

                </div>
            </div>
            @endif
            <div class="dash-right-wrapper">
                <div class="rightFlex">
                    <div class="soldeAffichage">
                        <div class="carteOptions">
                            <h3 class="">Solde</h3>
                            <div class="infoSettings">
                                <div class="dropdown">
                                    <div id="myDropdown" class="dropdown-content">
                                        <a href="/cloture/{{$id}}" onclick="return confirm('Voulez-vous vraiment fermer ce compte ?')">Fermer ce compte</a>
                                    </div>
                                </div>
                                <button onclick="optionsDropdown()" class="dropbtn">
                                    <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M14.2788 2.15224C13.9085 2 13.439 2 12.5 2C11.561 2 11.0915 2 10.7212 2.15224C10.2274 2.35523 9.83509 2.74458 9.63056 3.23463C9.53719 3.45834 9.50065 3.7185 9.48635 4.09799C9.46534 4.65568 9.17716 5.17189 8.69017 5.45093C8.20318 5.72996 7.60864 5.71954 7.11149 5.45876C6.77318 5.2813 6.52789 5.18262 6.28599 5.15102C5.75609 5.08178 5.22018 5.22429 4.79616 5.5472C4.47814 5.78938 4.24339 6.1929 3.7739 6.99993C3.30441 7.80697 3.06967 8.21048 3.01735 8.60491C2.94758 9.1308 3.09118 9.66266 3.41655 10.0835C3.56506 10.2756 3.77377 10.437 4.0977 10.639C4.57391 10.936 4.88032 11.4419 4.88029 12C4.88026 12.5581 4.57386 13.0639 4.0977 13.3608C3.77372 13.5629 3.56497 13.7244 3.41645 13.9165C3.09108 14.3373 2.94749 14.8691 3.01725 15.395C3.06957 15.7894 3.30432 16.193 3.7738 17C4.24329 17.807 4.47804 18.2106 4.79606 18.4527C5.22008 18.7756 5.75599 18.9181 6.28589 18.8489C6.52778 18.8173 6.77305 18.7186 7.11133 18.5412C7.60852 18.2804 8.2031 18.27 8.69012 18.549C9.17714 18.8281 9.46533 19.3443 9.48635 19.9021C9.50065 20.2815 9.53719 20.5417 9.63056 20.7654C9.83509 21.2554 10.2274 21.6448 10.7212 21.8478C11.0915 22 11.561 22 12.5 22C13.439 22 13.9085 22 14.2788 21.8478C14.7726 21.6448 15.1649 21.2554 15.3694 20.7654C15.4628 20.5417 15.4994 20.2815 15.5137 19.902C15.5347 19.3443 15.8228 18.8281 16.3098 18.549C16.7968 18.2699 17.3914 18.2804 17.8886 18.5412C18.2269 18.7186 18.4721 18.8172 18.714 18.8488C19.2439 18.9181 19.7798 18.7756 20.2038 18.4527C20.5219 18.2105 20.7566 17.807 21.2261 16.9999C21.6956 16.1929 21.9303 15.7894 21.9827 15.395C22.0524 14.8691 21.9088 14.3372 21.5835 13.9164C21.4349 13.7243 21.2262 13.5628 20.9022 13.3608C20.4261 13.0639 20.1197 12.558 20.1197 11.9999C20.1197 11.4418 20.4261 10.9361 20.9022 10.6392C21.2263 10.4371 21.435 10.2757 21.5836 10.0835C21.9089 9.66273 22.0525 9.13087 21.9828 8.60497C21.9304 8.21055 21.6957 7.80703 21.2262 7C20.7567 6.19297 20.522 5.78945 20.2039 5.54727C19.7799 5.22436 19.244 5.08185 18.7141 5.15109C18.4722 5.18269 18.2269 5.28136 17.8887 5.4588C17.3915 5.71959 16.7969 5.73002 16.3099 5.45096C15.8229 5.17191 15.5347 4.65566 15.5136 4.09794C15.4993 3.71848 15.4628 3.45833 15.3694 3.23463C15.1649 2.74458 14.7726 2.35523 14.2788 2.15224ZM12.5 15C14.1695 15 15.5228 13.6569 15.5228 12C15.5228 10.3431 14.1695 9 12.5 9C10.8305 9 9.47716 10.3431 9.47716 12C9.47716 13.6569 10.8305 15 12.5 15Z"></path> </g></svg>
                                </button>
                            </div>
                        </div>
                        <div class="">
                            <div class="soldeSwitch">
                                <div id="balance-visible">{{$solde}} XOF</div>
                                <div id="balance-hidden" style="display: none">••••••</div>
                                <button id="balanceShow" class="eye-open" onclick="toggleBalance()"></button>
                            </div>
                        </div>
                        <div class="carteOptions">
                            <h3 class="">Informations du compte</h3>
                        </div>
                        <div class="infoCompte">
                            <div class=""><b>N° de compte: </b>{{$compteUser->numero_de_compte}}</div>
                            <div class=""><b>Code Banque: </b>{{$compteUser->code_banque}}</div>
                            <div class=""><b>Code Guichet: </b>{{$compteUser->code_guichet}}</div>
                        </div>
                    </div>
                    <div class="detailsInfo">
                        @if(isset($compteUser) and $compteUser->type_compte == "courant")
                            <div class="cartebancaire">
                                <div class="carteOptions">
                                    <h3 class="">Carte Bancaire</h3>

                                    @if(!isset($carteBancaire) or $carteBancaire==null)

                                    @else
                                        <a href="/download/carte/{{$id}}" class="downloadLink">
                                            <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.22 20.75H5.78C5.43322 20.7359 5.09262 20.6535 4.77771 20.5075C4.4628 20.3616 4.17975 20.155 3.94476 19.8996C3.70977 19.6442 3.52745 19.3449 3.40824 19.019C3.28903 18.693 3.23525 18.3468 3.25 18V15C3.25 14.8011 3.32902 14.6103 3.46967 14.4697C3.61033 14.329 3.80109 14.25 4 14.25C4.19892 14.25 4.38968 14.329 4.53033 14.4697C4.67099 14.6103 4.75 14.8011 4.75 15V18C4.72419 18.2969 4.81365 18.5924 4.99984 18.8251C5.18602 19.0579 5.45465 19.21 5.75 19.25H18.22C18.5154 19.21 18.784 19.0579 18.9702 18.8251C19.1564 18.5924 19.2458 18.2969 19.22 18V15C19.22 14.8011 19.299 14.6103 19.4397 14.4697C19.5803 14.329 19.7711 14.25 19.97 14.25C20.1689 14.25 20.3597 14.329 20.5003 14.4697C20.641 14.6103 20.72 14.8011 20.72 15V18C20.75 18.6954 20.5041 19.3744 20.0359 19.8894C19.5677 20.4045 18.9151 20.7137 18.22 20.75Z" fill="currentColor"></path> <path d="M12 15.75C11.9015 15.7504 11.8038 15.7312 11.7128 15.6934C11.6218 15.6557 11.5392 15.6001 11.47 15.53L7.47 11.53C7.33752 11.3878 7.2654 11.1997 7.26882 11.0054C7.27225 10.8111 7.35096 10.6258 7.48838 10.4883C7.62579 10.3509 7.81118 10.2722 8.00548 10.2688C8.19978 10.2654 8.38782 10.3375 8.53 10.47L12 13.94L15.47 10.47C15.6122 10.3375 15.8002 10.2654 15.9945 10.2688C16.1888 10.2722 16.3742 10.3509 16.5116 10.4883C16.649 10.6258 16.7277 10.8111 16.7312 11.0054C16.7346 11.1997 16.6625 11.3878 16.53 11.53L12.53 15.53C12.4608 15.6001 12.3782 15.6557 12.2872 15.6934C12.1962 15.7312 12.0985 15.7504 12 15.75Z" fill="currentColor"></path> <path d="M12 15.75C11.8019 15.7474 11.6126 15.6676 11.4725 15.5275C11.3324 15.3874 11.2526 15.1981 11.25 15V4C11.25 3.80109 11.329 3.61032 11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5303 3.46967C12.671 3.61032 12.75 3.80109 12.75 4V15C12.7474 15.1981 12.6676 15.3874 12.5275 15.5275C12.3874 15.6676 12.1981 15.7474 12 15.75Z" fill="currentColor"></path> </g></svg>
                                        </a>
                                    @endif
                                </div>
                                @if(isset($carteBancaire) and $carteBancaire!=null)
                                    {{--                        DONE: make a reversible image to show front and back of carte--}}
                                    <div class="carteWrapper">
                                        <div class="contentCarte">
                                            <div class="carteTop">
                                                <div class="carteLogo"></div>
                                            </div>
                                            <div class="carteBottom">
                                                <div class="cartePuce"></div>
                                                <div class="carteNum">{{$numCarte}}</div>
                                                <div class="carteDate">EXP {{$dateCarte}}</div>
                                                <div class="carteNom">{{strtoupper(Auth::user()->nom)}} {{Auth::user()->prenom}}</div>
                                            </div>
                                        </div>
                                        <div class="contentBackCarte">
                                            <div class="carteBackTop">
                                                <div class="carteStrip"></div>
                                            </div>
                                            <div class="carteBackBottom">
                                                <div class="carteTitle">Signature</div>
                                                <div class="backInfo">
                                                    <div class="carteChamp"></div>
                                                    <div class="carteCVV">{{$carteBancaire->CVV}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="carteWrapper">
                                        <a href="/createcarte/{{$id}}" class="btnCreate">Générer ma carte bancaire</a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                </div>


                <div class="solde">
                    <h3 class="">Panneau de transaction</h3>
                    <div class="soldeOptions">
                        <div class="tab">
                            <button class="tablinks depotTab" onclick="openCity(event, 'depotForm')">     Dépôt    </button>
                            <button class="tablinks retraitTab" onclick="openCity(event, 'retraitForm')">   Retrait  </button>

                            @if(isset($compteUser) and $compteUser->type_compte == "courant")
                                <button class="tablinks virementTab" onclick="openCity(event, 'vierementForm')"> Virement </button>
                            @endif
                        </div>
                        <div class="tabsWrapper">
                            <!-- Tab content -->
                            <div id="depotForm" class="tabcontent">
                                <form method="post" action="/transaction/depot" class="tabform">
                                    @csrf
                                    @method("POST")
                                    <div class="mb-0">
                                        <label class="form-label" for="sommeDepot"><b style="font-size: 1.5em">Dépôt </b></label><br>
                                        <input class="soldeInput" id="sommeDepot" name="sommeDepot" type="number" placeholder="0"><br>
                                        <input type="hidden" name="idCompte" id="idCompte" value="{{$id}}">
                                        <button type="submit" class="btnCreate">déposer</button>
                                    </div>
                                </form>
                            </div>

                            <div id="retraitForm" class="tabcontent">
                                <form method="post" action="/transaction/retrait" class="tabform">
                                    @csrf
                                    @method("POST")
                                    <div class="mb-0">
                                        <label class="form-label" for="sommeRetire"><b style="font-size: 1.5em">Retrait</b></label><br>
                                        <input class="soldeInput" id="sommeRetire" name="sommeRetire" type="number" placeholder="0"><br>
                                        <input type="hidden" name="idCompte" id="idCompte" value="{{$id}}">
                                        <button type="submit" class="btnCreate">retirer</button>
                                    </div>
                                </form>
                            </div>
                            @if(isset($compteUser) and $compteUser->type_compte == "courant")
                                <div id="vierementForm" class="tabcontent">
                                    <form method="post" action="/transaction/virement" class="tabform">
                                        @csrf
                                        @method("POST")
                                        <div class="mb-0">
                                            <label class="form-label" for="sommeVirement"><b style="font-size: 1.5em">Virement</b></label><br>
                                            <input class="soldeInput" id="sommeVirement" name="sommeVirement" type="number" placeholder="0"><br>

                                            <label class="form-label" for="numCompteDest"><b style="font-size: 1.5em">Numéro du Compte Destinataire</b></label><br>
                                            <input class="soldeInput" id="numCompteDest" name="numCompteDest" type="number" value="{{ old('numCompteDest') }}"><br>

                                            <input type="hidden" name="idCompte" id="idCompte" value="{{$id}}">
                                            <button type="submit" class="btnCreate">effectuer</button>

                                        </div>
                                    </form>
                                </div>
                            @endif
                            @error('sommeDepot')
                            <div class="errorText text-danger">{{$message}}</div>
                            @enderror
                            @error('numCompteDest')
                            <div class="errorText text-danger"> {{$message}}</div>
                            @enderror
                            @error('sommeRetire')
                            <div class="errorText text-danger"> {{$message}}</div>
                            @enderror
                            @error('sommeVirement')
                            <div class="errorText text-danger">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session('notification'))
        <script>
            window.onload = function () {
                alert("{{ session('notification') }}");
            };
        </script>
    @endif
    <script>
        function openCity(evt, optionId) {
            // Declare all variables
            let i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(optionId).style.display = "block";
            evt.currentTarget.className += " active";
        }
        function optionsDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
            console.log("toggling showwww");
        }

        // Close the dropdown menu if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.closest('.dropbtn')) {
                const dropdowns = document.getElementsByClassName("dropdown-content");
                let i;
                for (i = 0; i < dropdowns.length; i++) {
                    let openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                        console.log("removed showwwww")
                    }
                }
            }
        }

        function toggleBalance() {
            const visible = document.getElementById("balance-visible");
            const hidden = document.getElementById("balance-hidden");
            const button = document.getElementById("balanceShow")
            if (visible.style.display === "none") {
                visible.style.display = "block";
                hidden.style.display = "none";

                if (button.classList.contains('eye-closed')) {
                    button.classList.remove('eye-closed');
                }
                button.classList.add('eye-open');
            } else {
                visible.style.display = "none";
                hidden.style.display = "block";
                if (button.classList.contains('eye-open')) {
                    button.classList.remove('eye-open');
                }
                button.classList.add('eye-closed');
            }
        }

    </script>
@endsection
