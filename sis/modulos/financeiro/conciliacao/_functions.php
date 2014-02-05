<?php

function mov_arquivo($d,$f){
	global $vkt_id,$tb;

	
	if($f){
		$arquivo = $f["name"];
		$caminho = "../upload/financeiro/conciliacao/";
		$caminho_completo = $caminho.$arquivo;
		
		$extensao = substr($arquivo,-3);
		
		if(move_uploaded_file($f['tmp_name'], $caminho_completo)){
			mysql_query("DELETE FROM $tb WHERE vkt_id='$vkt_id'");
			if($extensao=="ofx"){
				include('OFXParser.php');
				$ofx= new OFXParser();
				$ofx->loadFromFile($caminho_completo);

				$creditos = $ofx->getCredits();
				$debitos = $ofx->getDebits();
				//pr($creditos);pr($debitos);
				//echo var_dump($creditos)."<br>";
		
				$c = array_merge($creditos,$debitos);
			
				foreach($c as $c){
			
				
					//for($i=0;$i<count($c);$i++){
					//	pr($c);
					//if($c[TRNTYPE]=='DEBIT'){$tipo=0;}else{$tipo=1;}
					if($c[TRNAMT]<0){$tipo=0;}else{$tipo=1;}
				
					$info = mf(mq("SELECT * FROM $tb WHERE vkt_id='$vkt_id' AND item_arquivo_id='$c[FITID]'"));
					if($info->id<1){
						$sql = "INSERT INTO $tb SET
					vkt_id='$vkt_id', conta_id='$d[conta_id]', item_arquivo_id='$c[FITID]', descricao='$c[MEMO]', valor='".abs(moedaBrToUsa($c[TRNAMT]))."', data='$c[DTPOSTED]', tipo='$tipo', data_arqivo=now()\n ";
					}else{
						$sql = "UPDATE $tb SET
					vkt_id='$vkt_id', conta_id='$d[conta_id]', item_arquivo_id='$c[FITID]', descricao='$c[MEMO]', valor='".abs(moedaBrToUsa($c[TRNAMT]))."', data='$c[DTPOSTED]', tipo='$tipo', data_arqivo=now() WHERE id='$info->id'\n ";
					}
					//echo $sql."<br>";
					//pr($sql);
					mysql_query ($sql);
				}
			}
			if($extensao=="xls"||$extensao=="txt"){
				/*include('excel_reader2.php');
				$arquivo_excel = "../upload/financeiro/conciliacao/".$arquivo;
				
				$data = new Spreadsheet_Excel_Reader($arquivo_excel,false);
														
				for( $i=1; $i <= $data->rowcount($sheet_index=0); $i++ ){
        			echo "$i: " . $data->val($i, 1) . "</td><td>" . $data->val($i, 2) . "</td><td>" . $data->val($i, 3) . "</td><td>" . $data->val($i, 4) . "<br>";
    			}*/
				$file = fopen($caminho_completo,"r");
				
				$cont=count($file);
				
				/*for($l=0;$l<$cont;$l++){
					$linha =$file[$l];
					if($linha!=''){
						echo strlen($linha)." $linha<br>";
					}
				}*/
				
				while(!feof($file)){
					$linha = fgets($file);
					echo $linha;
				}
			}
		}else{
			alert('Erro ao enviar arquivo:'.$arquivo)	;
		}
	}
	

}

?>