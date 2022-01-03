<div class="row gutters">
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="containerTicket lista-scroll">
            <div class="invoice">
                <div class="receipt" id="receipt_imagen">
                    <div class="ticket">

                        @if (!empty($ticket->logo))
                            <div class="centered margin-bottom">
                                {{-- <img src="{{ $ticket->logo }}" alt="Logo"> --}}
                                <img src="data:image/png;base64,{{ $ticket->logo_base }}">
                            </div>
                        @endif
                        <div class="text-box">
                            <!-- Logo -->
                            <p class="centered">
                                <!-- Header text -->
                                @if (!empty($ticket->header_text))
                                    <span class="headings">{!! $ticket->header_text !!}</span>
                                    <br />
                                @endif

                                <!-- business information here -->
                                @if (!empty($ticket->display_name))
                                    <span class="headings">
                                        {{ $ticket->display_name }}
                                    </span>
                                    <br />
                                @endif
                                @if (!empty($ticket->slogan))
                                    <span class="slogan margin-bottom">
                                        <strong> {{ $ticket->slogan }} </strong>
                                    </span>
                                    <br />
                                @endif

                                @if (!empty($ticket->address))
                                    {!! $ticket->address !!}
                                @endif

                                <!-- Title of receipt -->
                                @if (!empty($ticket->invoice_heading))
                                    <br /><span class="sub-headings">{!! $ticket->invoice_heading !!}</span>
                                @endif

                            </p>
                        </div>
                        @if (!empty($ticket->copia_label))
                            <div class='centered margin-bottom'>
                                <p><strong>{!! $ticket->copia_label !!}</strong></p>
                                <p><strong>Fecha: {{ $ticket->copia_date }} </strong></p>
                                <p><strong>******* ***** *******</strong></p>
                            </div>
                            <br>
                        @endif
                        <div class="flex-box">

                            <p class="f-left"><strong>{!! $ticket->date_label !!} {{ $ticket->invoice_date }}</strong></p>
                            {{-- <p class="f-right"><strong>{{ $ticket->invoice_date }}</strong></p> --}}

                            <p class="f-left"><strong>{!! $ticket->time_label !!} {{ $ticket->time_date }}</strong></p>
                            {{-- <p class="f-right"><strong>{{ $ticket->time_date }}</strong></p> --}}

                        </div>
                        @if (!empty($ticket->sorteo_label))
                            <div class="flex-box">
                                <p class="f-left"><strong>{!! $ticket->sorteo_label !!} {{ $ticket->sorteo_date }}</strong></p>
                                {{-- <p class="f-right"><strong>{{ $ticket->sorteo_date }}</strong></p> --}}
                            </div>
                        @endif
                        <div class="flex-box">

                            <p class="f-left"><strong>{!! $ticket->invoice_no_prefix !!} {{ $ticket->invoice_no }}</strong></p>
                            {{-- <p class="f-right"><strong>{{ $ticket->invoice_no }}</strong></p> --}}

                            {{-- @if ($isAnular == 0)
                                <p class="f-left"><strong>{!! $ticket->pin_no_prefix !!}</strong></p>
                                <p class="f-right"><strong>{{ $ticket->pin_no }}</strong></p>
                            @endif --}}
                        </div>
                    </div>
                    <div class="textbox-info centered">
                        @if (!empty($ticket->loteria))
                            <strong> {!! $ticket->loteria !!}</strong>
                        @endif
                    </div>
                    @php
                        $arrayQ = [];
                        $arrayPL = [];
                        $arrayTP = [];
                        $arraySP = [];
                        
                    @endphp

                    @foreach ($ticket->lines as $line)


                        @if ($line->modalidad == '1')
                            @php $arrayQ[] = $line; @endphp
                        @endif
                        @if ($line->modalidad == '2')
                            @php $arrayPL[] = $line; @endphp
                        @endif
                        @if ($line->modalidad == '3')
                            @php $arrayTP[] = $line; @endphp
                        @endif
                        @if ($line->modalidad == '4')
                            @php $arraySP[] = $line; @endphp
                        @endif

                    @endforeach
                    @if (count($arrayQ) != 0)
                        <div class='flex-box border-top'><strong>Quiniela</strong></div>
                        @foreach ($arrayQ as $jugada)
                            <div class="textbox-info">
                                <p class="f-left"><strong>{{ $jugada->apuesta }}</strong></p>
                                <p class="f-right"><strong>{{ $jugada->valor }}</strong></p>
                            </div>
                        @endforeach
                    @endif
                    @if (count($arrayPL) != 0)
                        <div class='flex-box border-top'><strong>Pales</strong></div>
                        @foreach ($arrayPL as $jugada)
                            <div class="textbox-info">
                                <p class="f-left"><strong>{{ $jugada->apuesta }}</strong></p>
                                <p class="f-right"><strong>{{ $jugada->valor }}</strong></p>
                            </div>
                        @endforeach
                    @endif
                    @if (count($arrayTP) != 0)
                        <div class='flex-box border-top'><strong>Tripletas</strong></div>
                        @foreach ($arrayTP as $jugada)
                            <div class="textbox-info">
                                <p class="f-left"><strong>{{ $jugada->apuesta }}</strong> </p>
                                <p class="f-right"><strong>{{ $jugada->valor }}</strong></p>
                            </div>
                        @endforeach
                    @endif
                    @if (count($arraySP) != 0)
                        <div class='flex-box border-top'><strong>SuperPale</strong></div>
                        @foreach ($arraySP as $jugada)
                            <div class="textbox-info">
                                <p class="f-left"><strong>{{ $jugada->apuesta }}</strong> </p>
                                <p class="f-right"><strong>{{ $jugada->valor }}</strong></p>
                            </div>
                        @endforeach
                    @endif
                    <br>
                    <div class="centered border-top border-bottom">
                        <p>
                            <strong>**{!! $ticket->total_label !!}</strong>
                            <strong>{{ $ticket->total }}**</strong>
                        </p>
                    </div>

                    @if (!empty($ticket->promocion_label))
                        <div class='centered'>
                            <p><strong>{!! $ticket->promocion_label !!}</strong></p>
                        </div>

                    @endif
                    @if (!empty($ticket->estado_label))
                        <div class='centered margin-bottom'>
                            <p><strong> {!! $ticket->estado_label !!} </strong></p>
                        </div>

                    @endif

                    @if (!empty($ticket->footer_text))
                        <p class="centered margin-bottom">
                            <strong> {!! $ticket->footer_text !!} </strong>
                        </p>

                    @endif

                    {{-- Barcode --}}
                    @if ($ticket->tcon_show_barcode)
                        <div class="centered margin-bottom">
                            <img
                                src="data:image/png;base64,{{ DNS1D::getBarcodePNG($ticket->barcode, 'C39', 1, 40, [0, 0, 0], true) }}">
                        </div>
                    @endif
                    <br />
                    <!-- business information here -->
                    @if (!empty($ticket->tcon_nota_informativa))
                        <span class="nota margin-bottom">
                            {{ $ticket->tcon_nota_informativa }}
                        </span>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
        {{-- RESULTADO --}}
        <div class="card">
            <div class="card-body ">
                <h5 class="card-title border-success">Resultados</h5>

                <h3> <span class='badge badge-pill badge-primary m-1'>{{ $resultado->res_premio1 }} </span>
                    <span class='badge badge-pill badge-secondary m-1'>{{ $resultado->res_premio2 }} </span>
                    <span class='badge badge-pill badge-success m-1'>{{ $resultado->res_premio3 }} </span>
                </h3>
            </div>
        </div>
        {{-- @dump($jugadas) --}}
        {{-- NUMEROS GANADORES Y EL VALOR --}}
        <div class="card">
            <div class="card-body ">
                <h5 class="card-title border-success ">Numero Premiados</h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Apuesta</th>
                                <th>Ganado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jugadas as $jugada)
                                <tr>
                                    <td> {{ $jugada->tid_apuesta }} </td>
                                    <td><span class="display_currency" data-orig-value='{{ $jugada->tid_valor }}'
                                            data-currency_symbol=true>{{ $jugada->tid_valor }}</span> </td>
                                    <td><span class="display_currency" data-orig-value='{{ $jugada->tid_ganado }}'
                                            data-currency_symbol=true>{{ $jugada->tid_ganado }} </span></td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body ">

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        {{-- Total a Pagar --}}
                        <h5 class="card-title">Total a Pagar:</h5>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($jugadas as $jugada)
                            @php
                                $total = $total + $jugada->tid_ganado;
                            @endphp
                        @endforeach
                        <h3><span class="display_currency badge badge-pill badge-success m-1"
                                data-orig-value='{{ $total }}'
                                data-currency_symbol=true>{{ $total }}</span></h3>
                        <input type="hidden" id="tic_ganado" name="tic_ganado" value="{{ $total }}">
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <h5 class="card-title">Pin:</h5>
                            <input class="form-control" type="text" name="tic_pin" id="tic_pin" value="" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
