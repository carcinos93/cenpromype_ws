<table border="1" style="border-collapse: collapse">
    <thead>

        <tr>
            @if ( $encabezado != null )
                @foreach ($encabezado->respuestas as $enc )
                    <th>
                        {{ $enc->RESPUESTA['label'] }}
                    </th>
                @endforeach
            {{--@foreach ($preguntas as $pregunta)
                <th>
                   {{ $pregunta['PREGUNTA'] }}
                </th>
            @endforeach--}}

            @endif

        </tr>
    </thead>
    <tbody>
       
        @foreach ( $usuarios as $usuario  )
			@if(count($usuario->respuestas) > 0)
				<tr>
					@foreach ($usuario->respuestas as $respuesta)
					<td>
                        @if( isset( $respuesta->RESPUESTA['value']['value'] ) )
                            
                            <span>   {{  $respuesta->RESPUESTA['value']['desc'] }}</span>
                      
                        @elseif (is_array($respuesta->RESPUESTA['value'] )) 
                            <span>    
                                @foreach ($respuesta->RESPUESTA['value'] as $valor )
                                    {{ ($loop->index > "0" ? ", " : "") . $valor['desc']  }}
                                @endforeach
                            </span>
                        @else

                        <span>   {{  $respuesta->RESPUESTA['value'] }}</span>
                        @endif
					</td>
					@endforeach
				</tr>
			@endif
		@endforeach
	
   
    </tbody>
</table>


