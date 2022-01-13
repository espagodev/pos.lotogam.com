<header class="header no-print">

    <div class="dropdown">

        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">

        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <div class="header-menu active">Menu</div>
           
            <a data-container=".view_register" href="#" data-href="{{ route('getControlApuestaLista') }}"
                class="btn-modal dropdown-item">
                <i class="icon-list"></i>
                <span class="menu-text">Control de Apuestas</span>
            </a>          

            <a data-container=".view_register" href="#"  data-href="{{ route('getReporteVentas') }}" class="btn-modal dropdown-item">
                <i class="icon-local_atm"></i>
                <span class="menu-text">Reporte de Ventas</span>
            </a>
            <a data-container=".view_register" href="#"  data-href="{{ route('getTicketLista') }}" class="btn-modal dropdown-item">
                <i class="icon-documents"></i>
                <span class="menu-text">Listado de Numeros</span>
            </a>


            <a data-container=".view_register" href="#" data-href="{{ route('getTicketLista') }}"  class="btn-modal dropdown-item">
                <i class="icon-confirmation_number"></i>
                <span class="menu-text">Tickets</span>
            </a>
            
            <a data-container=".view_register" href="#"  data-href="{{ route('getImpresora') }}" class="btn-modal dropdown-item">
                <i class="icon-print"></i>
                <span class="menu-text">Impresora Pos</span>
            </a>

        </div>


    </div>

    <div class="header-items">
        <!-- Header actions start -->
        <ul class="header-actions">
            <li class="dropdown">         
                <div class="print"> </div> 
            </li>
            <li class="dropdown">
                <span class="badge badge-primary badge-pill">Venta<div class="totalVentas"></div></span>
            </li>  
            <li class="dropdown">
                <a data-container=".view_register" href="#" data-href="{{ route('getTicketLista') }}" id="tickets" class="btn-modal" data-toggle="tooltip" data-placement="bottom" title="Listado Tickets">
                    <i class="icon-confirmation_number"></i>
                </a>                
            </li>
            @if (session()->get('permisos.useCuadreCaja') == 1)
            <li class="dropdown">
                <a href="{{ route('cuadreCaja') }}" id="cuadreCaja" data-toggle="tooltip" data-placement="bottom" title="Cuadre Caja">
                    <i class="icon-dollar-sign"></i>
                </a>                
            </li>
            @endif
           
             @if (session()->get('permisos.useTraslado') == 1)
            <li class="dropdown">
                <a href="{{ route('traslado') }}" id="traslado" data-toggle="tooltip" data-placement="bottom" title="Traslado Numeros">
                    <i class="icon-swap_horiz"></i>
                </a>                
            </li>
            @endif
            <li class="dropdown">
                <a href="{{ route('pos') }}" id="pos" data-toggle="tooltip" data-placement="bottom" title="Venta Pos">
                    <i class="icon-grid"></i>
                </a>                
            </li>
            <li class="dropdown">
                <a href="{{ route('dashboard') }}" id="dashboard" data-toggle="tooltip" data-placement="bottom" title="dashboard">
                    <i class="icon-home2"></i>
                </a>                
            </li>
           
            @if (session()->get('permisos.resultados') == 1)
            <li class="dropdown">
                <a href="{{ route('resultados') }}" id="resultados" data-toggle="tooltip" data-placement="bottom" title="Resultados Loteria">
                    <i class="icon-gift"></i>
                </a>                
            </li>
            @endif
            
           
            {{-- <li class="dropdown">
                <a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
                    <i class="icon-box"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right lrg" aria-labelledby="notifications">
                    <div class="dropdown-menu-header">
                        Tasks (05)
                    </div>
                    <ul class="header-tasks">
                        <li>
                            <p>#20 - Dashboard UI<span>90%</span></p>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="90"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                    <span class="sr-only">90% Complete (success)</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <p>#35 - Alignment Fix<span>60%</span></p>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="60"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Complete (success)</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <p>#50 - Broken Button<span>40%</span></p>
                            <div class="progress">
                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
                    <i class="icon-bell"></i>
                    <span class="count-label">8</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right lrg" aria-labelledby="notifications">
                    <div class="dropdown-menu-header">
                        Notifications (40)
                    </div>
                    <ul class="header-notifications">
                        <li>
                            <a href="#">
                                <div class="user-img away">
                                    <img src="img/user.png" alt="User">
                                </div>
                                <div class="details">
                                    <div class="user-title">Abbott</div>
                                    <div class="noti-details">Membership has been ended.</div>
                                    <div class="noti-date">Oct 20, 07:30 pm</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="user-img busy">
                                    <img src="img/user.png" alt="User">
                                </div>
                                <div class="details">
                                    <div class="user-title">Braxten</div>
                                    <div class="noti-details">Approved new design.</div>
                                    <div class="noti-date">Oct 10, 12:00 am</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="user-img online">
                                    <img src="img/user.png" alt="User">
                                </div>
                                <div class="details">
                                    <div class="user-title">Larkyn</div>
                                    <div class="noti-details">Check out every table in detail.</div>
                                    <div class="noti-date">Oct 15, 04:00 pm</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            <li class="dropdown">
                <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="avatar">
                        <img src="img/user.png" alt="avatar">
                        <span id="status" class="status" ></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                    <div class="header-profile-actions">
                        <div class="header-user-profile">
                            <div class="header-user">
                                <img src="img/user.png" alt="Admin Template">
                            </div>
                            <h5>{{ Auth::user()->name }}</h5>
                            {{-- <p>Admin</p> --}}
                        </div>
                        <a href="user-profile.html"><i class="icon-user1"></i> My Profile</a>
                        <a href="account-settings.html"><i class="icon-settings1"></i> Account Settings</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="icon-log-out1"></i> Salir</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        
                    </div>
                </div>
            </li>
        </ul>
        <!-- Header actions end -->
    </div>
</header>
