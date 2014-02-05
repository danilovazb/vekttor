<?php
	
	$acao = $_GET["acao"];

/* FUNCAO PARA DIFERENÇA DE DATA */
	function DiferencaData($startDate, $endDate) { 
		 $startDate = strtotime($startDate); 
            $endDate = strtotime($endDate); 
            if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate) 
                return false; 
                
            $years = date('Y', $endDate) - date('Y', $startDate); 
            
            $endMonth = date('m', $endDate); 
            $startMonth = date('m', $startDate); 
            
            // Calculate months 
            $months = $endMonth - $startMonth; 
            if ($months < 0)  { 
                $months += 12; 
                $years--; 
            } 
            if ($years < 0) 
                return false; 
            
            // Calculate the days 
                        $offsets = array(); 
                        if ($years > 0) 
                            $offsets[] = $years . (($years == 1) ? ' year' : ' years'); 
                        if ($months > 0) 
                            $offsets[] = $months . (($months == 1) ? ' month' : ' months'); 
                        $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now'; 

                        $days = $endDate - strtotime($offsets, $startDate); 
                        $days = date('z', $days); 
						//
						//$r =  strtotime($endDate);  
                        
            return array($years, $months, $days); 
	 } 
	
	
	
	if($acao == "ferias"){
		
		$mes_admissao = $_POST["mes_admissao"];
		$mes_demissao = $_POST["mes_demissao"];
		
		
		$meses = mysql_result(mysql_query($tpy="SELECT TIMESTAMPDIFF(MONTH, '$data_admissao','$data_demissao')"),0,0);
		echo $meses;
	}
	


?>