

{{--DONE:: check in comptes liste if there is any compte "actif" and show it with a link to all the operations possible--}}
    <style>
        /*SIDEBAR*/
        .sidebar{
            position: sticky;
            top: 0;
            left: 0;
            display: flex;
            height: 100vh;
            flex-direction: column;
            width: 300px;
            background-color: #224d6c;
            color: #D2C1B6;
        }
        .sidebar-logo{
            height: 8%;
            font-size: 1.5em;
            font-family: Roboto, sans-serif;
            font-weight: bolder;
            text-decoration: none;
            display: flex;
            background-color: #1B3C53;
            color:#D2C1B6 ;
            align-items: center;

        }
        .sidebar-btn{
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-color: #1B3C53;
            color:#D2C1B6 ;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.75em;
            padding-block: 0.25em;
            width: 100%;
            border: none;
            gap: 1em;
        }
        .sidebar-btn svg{
            height: 25px;
        }
        .toggled-hidden{
            display: none;
        }
        .sidebar-btn, .toggled-list a{
            transition: all 0.15s;
        }
        .sidebar-btn:hover, .toggled-list a:hover{
            background-color: #456882;
        }
        .toggled-list a:focus{
            background-color: #456882;
        }


        .toggled-list a{
            font-family: Roboto, sans-serif;
            text-decoration: none;
            display: flex;
            padding-inline: 1em;
            align-items: center;
            text-align: center;
            color: #D2C1B6;
            background-color: #132a3a;
            font-weight: bold;
            font-size: 1.5em;
            padding-block: 0.25em;
        }
        .sidebar-separator{
            flex-grow:1;
        }
        .sidebar-list{
            display: flex;
            flex-direction: column;
            padding: 0;

        }
        .sidebar-list-element{
            margin: 0;
            padding: 0;
        }






        .sidebarCompte{
            background-color: #9cd3e8;
            font-size: 1.75em;
        }
        .sidebarCompteTitle{
            background-color: #1B3C53;
            color:#D2C1B6 ;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1em;
        }
        .sidebarCompteTitle svg{
            height: 25px;
        }
        .sidebarCompteItem{
            display: flex;
            background-color: #456882;
            color: #F9F3EF;

        }
        .sidebarCompteItem a:hover{
            background-color: #F9F3EF;
            color: #456882;
        }
        .sidebarCompteItem a{
            text-decoration: none;
            background-color: #456882;
            color: #F9F3EF;
            width: 100%;
            padding-inline: 1em;
            padding-block: 0.25em;
            transition: all 100ms;
        }
        .sidebarCompteList{

        }
        .sidebarOption{
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-color: #456882;
            color: #F9F3EF;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.75em;
            padding-block: 0.25em;
        }
        .sidebarOption:hover{
            background-color: #F9F3EF;
            color: #456882;
        }
        .sidebarAdminOption{
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.75em;
            padding-block: 0.25em;
            background-color: #456882;
            color: #F9F3EF;
            transition: all 100ms;
        }
        .sidebarAdminOption:hover{
            background-color: #F9F3EF;
            color: #456882;
        }
        .sidebarOption svg{
            height: 50px;
        }
    </style>
    <div class="sidebar">
        <a href="/" class="sidebar-logo">
            <svg xmlns="http://www.w3.org/2000/svg" width="362" height="139" viewBox="0 0 362 139">
                <path xmlns="http://www.w3.org/2000/svg" d="" stroke="none" fill="currentColor" fill-rule="evenodd"></path>
                <path xmlns="http://www.w3.org/2000/svg" d="M 178.657 37.746 C 178.190 38.502, 158.252 83.424, 152.888 95.807 C 151.022 100.114, 151.022 100.114, 155.171 99.807 C 159.319 99.500, 159.319 99.500, 162.768 91.221 L 166.217 82.942 178.837 83.221 L 191.457 83.500 194.869 91.750 C 198.282 100, 198.282 100, 202.208 100 C 205.825 100, 206.078 99.822, 205.422 97.750 C 204.561 95.032, 180.094 37.760, 179.569 37.236 C 179.366 37.033, 178.956 37.262, 178.657 37.746 M 210 68.263 C 210 100, 210 100, 213.481 100 C 216.962 100, 216.962 100, 217.231 77.385 L 217.500 54.771 239.853 78.135 C 252.147 90.986, 262.616 101.652, 263.117 101.838 C 263.657 102.038, 263.921 89.405, 263.764 70.838 C 263.500 39.500, 263.500 39.500, 260 39.500 C 256.500 39.500, 256.500 39.500, 256 61.859 L 255.500 84.217 237.073 64.859 C 226.937 54.211, 216.700 43.481, 214.323 41.013 L 210 36.526 210 68.263 M 106.506 43.011 C 101.513 46.917, 101.513 46.917, 100.280 44.565 C 98.485 41.139, 93.564 39.657, 90.037 41.481 C 87.018 43.042, 86.035 45.429, 86.014 51.250 C 86 55, 86 55, 99.500 55 C 112.333 55, 113 54.901, 113 53 C 113 51.232, 112.333 51, 107.250 51 L 101.500 51 107.250 46.921 C 110.839 44.375, 113 42.120, 113 40.921 C 113 38.278, 112.245 38.521, 106.506 43.011 M 116.750 39.552 C 116.338 39.982, 116 53.758, 116 70.167 L 116 100 125.318 100 C 139.759 100, 146.928 97.003, 150.878 89.316 C 153.878 83.476, 150.718 72.719, 145.012 69.348 C 141.594 67.329, 141.391 66.750, 143.493 65.006 C 145.893 63.014, 147.163 56.679, 146.105 51.973 C 145.008 47.090, 141.830 43.309, 137.148 41.315 C 133.349 39.697, 117.892 38.361, 116.750 39.552 M 274 69.500 C 274 100, 274 100, 277.500 100 C 281 100, 281 100, 281 87.059 C 281 79.941, 281.423 73.857, 281.940 73.537 C 282.456 73.218, 288.194 79.002, 294.690 86.391 C 306.500 99.825, 306.500 99.825, 311.953 99.912 L 317.406 100 313.876 96.250 C 311.935 94.188, 305.280 86.919, 299.088 80.098 L 287.830 67.696 301.415 54.085 C 308.887 46.599, 315 40.142, 315 39.737 C 315 39.332, 313.126 39, 310.836 39 C 306.843 39, 306.145 39.522, 293.836 51.701 L 281 64.401 281 51.701 C 281 39, 281 39, 277.500 39 C 274 39, 274 39, 274 69.500 M 61.020 42.250 C 54.647 45.507, 52.533 48.886, 52.533 55.819 C 52.533 60.059, 53.087 62.313, 54.675 64.543 C 56.816 67.550, 56.816 67.550, 53.567 69.680 C 46.999 73.985, 44.793 85.429, 49.253 92.048 C 53.359 98.140, 56.985 99.456, 70.750 99.853 L 83 100.206 83 70.103 L 83 40 74.212 40 C 67.070 40, 64.599 40.421, 61.020 42.250 M 92 44.729 C 90.078 45.461, 89.035 47.041, 89.015 49.250 C 89.003 50.660, 89.875 51, 93.500 51 C 97.278 51, 98 50.690, 98 49.071 C 98 47.177, 95.510 43.924, 94.179 44.079 C 93.805 44.122, 92.825 44.415, 92 44.729 M 65.501 47.066 C 61.566 48.239, 60 50.539, 60 55.144 C 60 62.685, 63.717 65.977, 72.250 65.994 C 75 66, 75 66, 75 56 C 75 46, 75 46, 71.750 46.086 C 69.963 46.133, 67.151 46.574, 65.501 47.066 M 123 56 L 123 66.280 128.750 65.690 C 136.033 64.944, 139 62.029, 139 55.619 C 139 49.709, 136.059 47.068, 128.622 46.300 L 123 45.720 123 56 M 178.690 54.692 C 177.592 56.469, 170 74.361, 170 75.172 C 170 75.628, 174.080 76, 179.067 76 C 189.570 76, 189.141 77.417, 183.044 62.854 C 180.956 57.868, 178.997 54.195, 178.690 54.692 M 95.604 58.028 C 88.681 60.124, 84.068 68.263, 85.994 74.980 C 89.294 86.484, 104.883 88.801, 111.040 78.701 C 117.435 68.214, 107.206 54.515, 95.604 58.028 M 93.367 62.772 C 88.410 66.787, 87.606 73.190, 91.480 77.794 C 99.152 86.911, 113.859 77.563, 108.915 66.712 C 106.545 61.511, 97.693 59.268, 93.367 62.772 M 62.016 73.024 C 57.768 74.023, 53.995 78.164, 54.015 81.806 C 54.053 88.823, 59.733 92.996, 69.250 92.998 L 75 93 75 82.500 L 75 72 70.250 72.102 C 67.638 72.159, 63.932 72.573, 62.016 73.024 M 123 82.465 L 123 93.219 130.449 92.842 C 141.464 92.286, 146.319 87.577, 144.168 79.536 C 142.921 74.872, 139.335 72.947, 130.676 72.292 L 123 71.711 123 82.465 M 86 93.500 L 86 100 99.500 100 C 112.333 100, 113 99.901, 113 98 C 113 96.205, 112.333 96, 106.500 96 C 100 96, 100 96, 100 92 C 100 88.667, 99.667 88, 98 88 C 96.333 88, 96 88.667, 96 92 C 96 95.905, 95.917 96, 92.500 96 C 89.019 96, 89 95.976, 89 91.500 C 89 88.167, 88.611 87, 87.500 87 C 86.321 87, 86 88.389, 86 93.500" stroke="none" fill="currentColor" fill-rule="evenodd"></path>
            </svg>
        </a>
        @if(!$user->isGestionnaire())
            <a href="/" class="sidebarOption">
                Ouvrir un compte<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 12L8 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M13 15L15.913 12.087C15.961 12.039 15.961 11.961 15.913 11.913L13 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
        @endif
        <div class="sidebar-list">
            @if(!$user->isGestionnaire() and isset($comptesActifs))
            <div class="sidebarCompte">
                <div class="sidebarCompteTitle">
                    Comptes<svg viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-triangle-down" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><title>1237</title><defs> </defs><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><path d="M10.106,12.69 C9.525,13.27 8.584,13.27 8.002,12.69 L1.561,6.246 C0.979,5.665 0.722,4.143 2.561,4.143 L15.549,4.143 C17.45,4.143 17.131,5.664 16.549,6.246 L10.106,12.69 Z" fill="currentColor" class="si-glyph-fill"></path></g></g></svg>
                </div>
                <div class="sidebarCompteList">
                    @foreach($comptesActifs as $compte)
                        <div class="sidebarCompteItem"><a href="/dashboard/compte/{{$compte->id}}" >{{$compte->type_compte}} <b>#{{$compte->id}}</b></a></div>
                    @endforeach
                </div>
            </div>
            @endif





                @if($user->isGestionnaire())

                            <a href="/gesDemandes" class="sidebarAdminOption" aria-expanded="true">
                                Demandes
                                {{--liste des comptes--}}
                            </a>

                            <a href="/gesComptes" class="sidebarAdminOption" aria-expanded="true">
                                Comptes
                                {{--liste des comptes--}}
                            </a>


                            <a href="/gesTransactions" class="sidebarAdminOption" aria-expanded="true">
                                Transactions
                            </a>

                @endif
        </div>
        <div class="sidebar-separator"></div>
        <div class="sidebar-list">
            <div class="sidebar-list-element user-dropdown">
                <button class="sidebar-btn" onclick="toggleUserDropdown()">
                    {{ Auth::user()->nom }}<svg viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-triangle-down" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>1237</title> <defs> </defs> <g stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd"> <path d="M10.106,12.69 C9.525,13.27 8.584,13.27 8.002,12.69 L1.561,6.246 C0.979,5.665 0.722,4.143 2.561,4.143 L15.549,4.143 C17.45,4.143 17.131,5.664 16.549,6.246 L10.106,12.69 L10.106,12.69 Z" fill="currentColor" class="si-glyph-fill"> </path> </g> </g></svg>
                </button>
                <div class="toggled-hidden" id="userDropdownContent">
                    <div class="toggled-list">
                            <a href="{{ route('logout') }}" class="sidebarCompteItem" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdownContent');
            dropdown.classList.toggle('toggled-hidden');
            dropdown.classList.toggle('toggled-flex');
            console.log("switchingngngngng");
        }
    </script>
