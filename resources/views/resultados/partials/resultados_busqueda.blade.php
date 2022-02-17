<div class="containerTicket lista-scroll">
    <div class="invoice">
        <div class="receipt" id="receipt_imagen">
            <div class="ticket">
                @if (!empty($resultados->logo_base))
                <div class="centered margin-bottom">                        
                    <img src="data:image/png;base64,{{ $resultados->logo_base }}">
                </div>
            @endif
            @if (!empty($resultados->logo))
               <div class="centered margin-bottom">
                   <img src="{{ $resultados->logo }}" alt="Logo">
               </div>
           @endif
            <div class="text-box">
                <!-- Logo -->
                <p class="centered">
                    <!-- Header text -->
                    @if (!empty($resultados->header_text))
                        <span class="headings">{!! $resultados->header_text !!}</span>
                        <br />
                    @endif

                    <!-- business information here -->
                    @if (!empty($resultados->display_name))
                        <span class="headings">
                            {{ $resultados->display_name }}
                        </span>
                        <br />
                    @endif
                    @if (!empty($resultados->slogan))
                        <span class="slogan margin-bottom">
                            <strong> {{ $resultados->slogan }} </strong>
                        </span>
                        <br />
                    @endif

                    @if (!empty($resultados->address))
                        {!! $resultados->address !!}
                    @endif
                    <!-- Title of receipt -->
                    @if (!empty($resultados->invoice_heading))
                        {!! $resultados->invoice_heading !!}
                    @endif
                </p>
            </div>
            <div class="flex-box">

                <p class="f-left"><strong>{!! $resultados->star_label !!} {{ $resultados->start_date }}</strong></p>
                <p class="f-left"><strong>{!! $resultados->end_label !!} {{ $resultados->end_date }}</strong></p>

            </div>
            <br>
            <div class='flex-box border-bottom'><strong>Resultados</strong></div>
            @foreach ($resultados->lines as $resultado)
                <div class="textbox-info">
                    <p class="f-left"><strong>{{ $resultado->nombre }}</strong> </p>
                    <p class="f-right"><strong>{{ $resultado->res_premio1 }} {{ $resultado->res_premio2 }} {{ $resultado->res_premio3 }}</strong></p>
                </div>
            @endforeach

            </div>            
        </div>
    </div>
</div>
