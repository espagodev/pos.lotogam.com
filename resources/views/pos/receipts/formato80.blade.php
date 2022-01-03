<!-- business information here -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
     <body>
        <div class="ticket">
        	<div class="text-box ">
        	@if(!empty($detalle_ticket->logo))
        		<img class="centered" style="max-height: 100px; width: auto;" src="{{$detalle_ticket->logo}}" alt="Logo">
        	@endif
            <div class="text-box">
        	<!-- Logo -->
            <p class="centered">
            	<!-- Header text -->
            	@if(!empty($detalle_ticket->header_text))
            		<span class="headings">{!! $detalle_ticket->header_text !!}</span>
					<br/>
				@endif

				<!-- business information here -->
				@if(!empty($detalle_ticket->display_name))
					<span class="headings">
						{{$detalle_ticket->display_name}}
					</span>
					<br/>
				@endif

                @if(!empty($detalle_ticket->address))
                    {!! $detalle_ticket->address !!}
                @endif
                <!-- Title of receipt -->
                @if(!empty($detalle_ticket->invoice_heading))
                    {!! $detalle_ticket->invoice_heading !!}
                @endif

				<!-- Title of receipt -->
				@if(!empty($detalle_ticket->invoice_heading))
					<br/><span class="sub-headings">{!! $detalle_ticket->invoice_heading !!}</span>
				@endif
			</p>
			</div>
            <div class="textbox-info">
                <div class="f-left">
                    <p class="f-left"><strong>{!! $detalle_ticket->date_label !!}</strong></p>
                    <p class="f-right"> {{$detalle_ticket->invoice_date}}</p>
                </div>

                <div class="f-right">
                    <p class="f-left"><strong>{!! $detalle_ticket->time_label !!}</strong></p>
                    <p class="f-right"> {{$detalle_ticket->time_date}}</p>
                </div>
            </div>
            <div class="flex-box">
                    <div class="textbox-info">
                    <p class="f-left"><strong>{!! $detalle_ticket->sorteo_label !!} </strong></p>
                    <p class="f-right"> {{$detalle_ticket->sorteo_date}}</p>
                </div>
            </div>
            <div class="flex-box">
                <div class="textbox-info">
                    <p class="f-left"><strong>{!! $detalle_ticket->invoice_no_prefix !!}</strong></p>
                    <p class="f-right"> {{$detalle_ticket->invoice_no}}</p>
                </div>

                <div class="textbox-info">
                     @if($isAnular == 0)
                    <p class="f-left"><strong>{!! $detalle_ticket->pin_no_prefix !!}</strong></p>
                    <p class="f-right"> {{$detalle_ticket->pin_no}}</p>
                    @endif
                </div>


            </div>
            <div class="textbox-info centered">
                @if(!empty($detalle_ticket->loteria))
                        <strong> {!! $detalle_ticket->loteria !!}</strong>
                @endif
            </div>
            @php
                $arrayQ = array();
                $arrayPL = array();
                $arrayTP = array();
                $arraySP = array();
            @endphp

            @foreach ($detalle_ticket->lines as $line)

                    @if ($line['modalidad'] == '1')
                           @php $arrayQ[] = $line; @endphp
                   @endif
                    @if ($line['modalidad'] == '2')
                        @php $arrayPL[] = $line; @endphp
                   @endif
                    @if ($line['modalidad'] == '3')
                        @php $arrayTP[] = $line; @endphp
                   @endif
                    @if ($line['modalidad'] == '4')
                        @php $arraySP[] = $line; @endphp
                   @endif

            @endforeach

            @if(!empty($arrayQ))
                <div class='flex-box border-top'><strong>Quiniela</strong></div>
                    @foreach ($arrayQ as $jugada)
                            <div class="textbox-info">
                                <p class="f-left">  {{ $jugada['apuesta'] }}  </p>
                                <p class="f-right">  {{ $jugada['valor'] }} </p>
                            </div>
                    @endforeach
            @endif
            @if(!empty($arrayPL))
                <div class='flex-box border-top'><strong>Pales</strong></div>
                    @foreach ($arrayPL as $jugada)
                            <div class="textbox-info">
                                 <p class="f-left">  {{ $jugada['apuesta'] }}  </p>
                                <p class="f-right">  {{ $jugada['valor'] }} </p>
                            </div>
                    @endforeach
            @endif
            @if(!empty($arrayTP))
                <div class='flex-box border-top'><strong>Tripletas</strong></div>
                    @foreach ($arrayTP as $jugada)
                            <div class="textbox-info">
                                <p class="f-left">  {{ $jugada['apuesta'] }}  </p>
                                <p class="f-right">  {{ $jugada['valor'] }} </p>
                            </div>
                    @endforeach
            @endif
            @if(!empty($arraySP))
                <div class='flex-box border-top'><strong>SuperPale</strong></div>
                    @foreach ($arraySP as $jugada)
                            <div class="textbox-info">
                                 <p class="f-left">  {{ $jugada['apuesta'] }}  </p>
                                <p class="f-right">  {{ $jugada['valor'] }} </p>
                            </div>
                    @endforeach
            @endif
            <br>
            <br>
             <div class="textbox-info centered border-top">
                <p class="f-left">
                    <strong>{!! $detalle_ticket->total_label !!}</strong>
                </p>
                <p class="f-right">
                    <strong>{{$detalle_ticket->total}}</strong>
                </p>
            </div>
             <br>
            @if(!empty($detalle_ticket->promocion_label))
				 <div class='centered'>
                {{-- <p>*****************************</p> --}}
                <p>**       PROMOCION         **</p>
                {{-- <p>*****************************</p> --}}
                </div>
			    @endif

             <br>
            	@if(!empty($detalle_ticket->footer_text))
				<p class="centered">
					{!! $detalle_ticket->footer_text !!}
				</p>
			    @endif
            <br>
            {{-- Barcode --}}
			@if($detalle_ticket->tcon_show_barcode)
				<br/>
				<img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($detalle_ticket->barcode, 'C128', 2,30,array(39, 48, 54), true)}}">
			@endif
        </div>
    </body>
</html>
