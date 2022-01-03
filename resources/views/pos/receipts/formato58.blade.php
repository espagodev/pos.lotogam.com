<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/ticket.css') }}">

</head>

<body>
  
    @foreach ($detalle_ticket as $ticket)
        <div class="ticket">

            @if (!empty($ticket->logo_base))
                <div class="centered margin-bottom">
                    <img src="data:image/png;base64,{{ $ticket->logo_base }}">
                </div>
            @endif
            @if (!empty($ticket->logo))
                <div class="centered margin-bottom">
                    <img src="{{ $ticket->logo }}" alt="Logo">
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


                    <!-- Title of receipt -->
                    @if (!empty($ticket->invoice_heading))
                        <br /><span class="sub-headings">{!! $ticket->invoice_heading !!}</span>
                    @endif

                </p>
            </div>
            @if (!empty($ticket->copia_label))
                <div class='copia centered margin-bottom'>
                    <p><strong>{!! $ticket->copia_label !!}</strong></p>
                    <p><strong>Fecha: {{ $ticket->copia_date }} </strong></p>
                    <p><strong>******* ***** *******</strong></p>
                </div>
            @endif
            <br>
            <div class="flex-box">

                <p class="f-left"><strong>{!! $ticket->date_label !!} {{ $ticket->invoice_date }}</strong></p>
                <p class="f-left"><strong>{!! $ticket->time_label !!} {{ $ticket->time_date }}</strong></p>

            </div>
            @if (!empty($ticket->sorteo_label))
                <div class="flex-box">
                    <p class="f-left"><strong>{!! $ticket->sorteo_label !!} {{ $ticket->sorteo_date }}</strong></p>
                </div>
            @endif
            <div class="flex-box">

                <p class="f-left"><strong>{!! $ticket->invoice_no_prefix !!} {{ $ticket->invoice_no }}</strong></p>

                @if (!empty($ticket->pin_no_prefix))
                    <p class="f-left"><strong>{!! $ticket->pin_no_prefix !!} {{ $ticket->pin_no }}</strong></p>
                @endif
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
        <!-- nota -->
        @if (!empty($ticket->tcon_nota_informativa))
            <span class="nota margin-bottom">
                {{ $ticket->tcon_nota_informativa }}
            </span>

        @endif
        </div>
    @endforeach

</body>

</html>
