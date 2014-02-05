<?

function NUMSabDom($mes,$ano ) {
		$numDiasFev = (date('L', mktime(0, 0, 0, $mes, 1, $ano)) == '1') ? 29 : 28;
		$numDiasMeses = array(1 => 31, 2 => $numDiasFev, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31);

		for ( $i = date( 'N', mktime( 0, 0, 0, $mes, 1, $ano ) ), $j = 0, $numSab = 0, $numDom = 0; $j < $numDiasMeses[$mes]; $j++, $i++ ) {
			$i = ($i > 7) ? 1 : $i;
			if ( $i == '6' ) { $numSab++; } elseif ( $i == '7' ) { $numDom++; }
		}

		return array('sab' => $numSab, 'dom' => $numDom, 'ano' => $ano, 'mes' => $mes);

}
	
function DiaDaSemana($data) {  // Traz o dia da semana para qualquer data informada
	$dia =  substr($data,0,2);
	$mes =  substr($data,3,2);
	$ano =  substr($data,6,9);
	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
	switch($diasemana){  
			case"0": $diasemana = "Domingo";	   break;  
			case"1": $diasemana = "Segunda-Feira"; break;  
			case"2": $diasemana = "Terça-Feira";   break;  
			case"3": $diasemana = "Quarta-Feira";  break;  
			case"4": $diasemana = "Quinta-Feira";  break;  
			case"5": $diasemana = "Sexta-Feira";   break;  
			case"6": $diasemana = "Sábado";		break;  
		 }
	return $diasemana;
} 