<?
//Funes 


//avaliacao do tempo de carregamento e uso de memria
function avaliaCarregamento($start,$modulo_id){
	global $vkt_id;
	global $login_id;
	
	$result = microtime(true)-$start;
	mysql_query($a="INSERT INTO sis_modulos_avaliacao SET vkt_id='$vkt_id', modulo_id='$modulo_id', usuario_id='".$login_id."', memoria_usada='".round(memory_get_usage(false)/1024,5)."', memoria_pico='".round(memory_get_peak_usage(false)/1024,5)."', tempo_carregamento='".round(microtime(true)-$start,5)."', navegador='".$_SERVER['HTTP_USER_AGENT']."', parametros='".$_SERVER['QUERY_STRING']."', dados_enviados='".print_r($_REQUEST,true)."', datahora=NOW()");
	//echo $a;
}

function enableTour($tela_id){
	
}

function retornaModuloPaiID($tela_id){
	$modulo_pai=mysql_fetch_object(mysql_query(" SELECT * FROM sis_modulos WHERE id='$tela_id' "));
	if($modulo->modulo_id==0){
		$modulo_pai=mysql_fetch_object(mysql_query(" SELECT * FROM sis_modulos WHERE id='$modulo->modulo_id' "));
		return $modulo_pai->id;
	}else{
		retornaModuloPaiID($modulo->modulo_id);
	}
	
	
}

function criaMenu($modulo_id){}

function limitaTexto ($texto,$tamanho){
	/*
	Por:Adalberto 
	- fun??o para limitar o texto, vc envia o texto e o tamanho e ele retorna o texto reduzido
	
	Entra: texto, tamanho desejado
	Retorna: texto reduzido
	*/
	return substr($texto,0,$tamanho);
}

function validaNumero ($numero){
	/*
	Por:Adalberto 
	- Retorna se o n?mero ? n?mero no momento mas caso precise criar qualquer tipo de valida??o num?rica deve ser feita aqui
	
	Entra: numero
	Retorna: 0 ou 1
	*/
	return is_numeric($numero);
}

function validaDataUsa ($data){
	/*
	Por:Adalberto 
	- Diz se o campo enviado ? uma data USA, se for, retorna ela formatada para BR, senao retorna 0
	
	Entra: data usa
	Retorna: 0 ou data formatada
	*/
	if(isset($data)){
		$data_br=explode($data,"/");
		
		if(count($data_br)>0){
			$nova_data=dataBrToUsa($data);
			return $nova_data;
		}
	}
	return 0;
}

function validaDataBr ($data){
	/*
	Por:Adalberto 
	- Diz se o campo enviado ? uma data BR, se for, retorna ela formatada para USA, senao retorna 0
	
	Entra: data br
	Retorna: 0 ou data formatada
	*/
	if(isset($data)){
		$data_usa=explode($data,"-");
		$data_br=explode($data,"/");
		
		if(count($data_usa)==3){
			$nova_data=dataUsaToBr($data);
			return $nova_data;
		}elseif(count($data_br)==3){
			return $data;
		}
	}
	return 0;
}


function moedaUsaToBr($valor){
	/*  
	Por: M?rio N?vo 14/04/2010
	
	Descri??o:Fun??o que transforma valores monetarios americanos troca ou coloca o ',' separador de milhar por '.' e coloca o separador de desena como ',' com 2 casas
	
	Entra:1111,111,111.00
	
	Sai:1111.111.111,00 
	*/
	$nv = str_replace(',','',$valor);
	
	return @number_format($nv,2,',','.');
}


function moedaBrToUsa($valor){
		/*  
	Por: M?rio N?vo 14/04/2010
	
	Descri??o:Fun??o que transforma valores monetarios brasileiro remove ',' separador de milhar e troca   ','  por '.' como separador de desena 
	
	Entra:1111.111.111,00 
	Sai:    1111111111.00
	
	*/
	$nv = str_replace('.','',$valor);
	$nv = str_replace(',','.',$nv);
	
	return @number_format($nv,2,'.','');
	
}

function dataUsaToBr($d){// 2010-07-03 -> 03/07/2010

	$d1 = explode(" ",$d);
	if(count($d1)==2){
		$d2 = explode("-",$d1[0]);
	}else{
		$d2 = explode("-",$d);
	}
	if($d2[0]<1){$d2[0]='0000';}
	if($d2[1]<1){$d2[1]='00';}
	if($d2[2]<1){$d2[2]='00';}
	return $d2[2]."/".$d2[1]."/".$d2[0];
}

function dataBrToUsa($d){// 03/07/2010 -> 2010-07-03 
	
	$d2 = explode("/",$d);
	
	return $d2[2]."-".$d2[1]."-".$d2[0];
}

function paginacao_limite($registros,$pagina,$limitador){
	
	if($pagina<1){
		$pagina=1;
	}
	if($limitador<1){
		$limitador=30;
	}
	$inicio = ($pagina-1)*$limitador;
	$fim = $limitador;
	
	return "$inicio,$fim";
}

function paginacao_links($pagina,$registros,$limitador,$parametros=NULL){
	if($parametros!=NULL && is_array($parametros)){
		$string_parametros='';
		foreach($parametros as $i=>$k){
			$string_parametros.="&$i=".$k;
		}
	}elseif($parametros!=NULL){
			$string_parametros =$parametros;
	}
	
	if($pagina<1){
		$pagina=1;
	}
	if($limitador<1){
		$limitador=30;
	}
	$anterior=$pagina-1;
	$proximo=$pagina+1;
	
	if($pagina==1){
		$link_volta = '<a class="bt_left_disabled"></a>';
	}else{
		$link_volta = '<a href="?tela_id='.$_GET[tela_id].'&pagina='.$anterior.'&limitador='.$limitador.'&busca='.$_GET[busca].'&ordem='.$valor.'&ordem_tipo='.$ordem_tipo.$string_parametros.'" class="bt_left"></a>';
	}
	
	$registros_p_p = $limitador*$pagina;
	
	if($registros_p_p>=$registros){
		$link_proximo = '<a class="bt_rigth_disabled"></a>';
	}else{
		$link_proximo = '<a href="?tela_id='.$_GET[tela_id].'&pagina='.$proximo.'&limitador='.$limitador.'&busca='.$_GET[busca].'&ordem='.$valor.'&ordem_tipo='.$ordem_tipo.$string_parametros.'" class="bt_rigth"></a>';
	}
	
	$retorno=$link_volta.'<input name="textfield" class="nPaginacao" type="text" id="textfield" value="'.$pagina.'" onkeydown="if(event.keyCode==13){location=\'?tela_id='.$_GET[tela_id].'&busca='.$_GET[busca].'&ordem='.$valor.'&ordem_tipo='.$ordem_tipo.'&pagina=\'+this.value+\'&limitador='.$limitador.$string_parametros.'\'}" size="2" value="1" />'.$link_proximo;
	
	return $retorno;
}

function linkOrdem($titulo,$valor,$ativo){
	$link_ordem="?tela_id=".$_GET[tela_id]."&pagina=".$_GET[pagina]."&limitador=".$_GET[limitador]."&busca=".$_GET[busca];
	
	$ordem_tipo="ASC";
	$seta='';
	
	if($_GET['ordem']==$valor){
		if($_GET['ordem_tipo']=="DESC"||empty($_GET['ordem_tipo'])){
			$ordem_tipo="ASC";
			$seta='<span class="sup"></span>';
		}else{
			$ordem_tipo="DESC";
			$seta='<span class="sdown"></span>';
		}
	}
	if($ativo&&empty($_GET['ordem'])){
		$ordem_tipo="DESC";
		$seta='<span class="sdown"></span>';
	}
	return '<a href="'.$link_ordem.'&ordem='.$valor.'&ordem_tipo='.$ordem_tipo.'" class="tda">'.$titulo.' '.$seta.'</a>';
}


function salvaUsuarioHistorico($tela,$acao,$tabela,$id){
	
	$usuario_id=$_SESSION['usuario']->id;
	if(!$tela)$tela=$PHP_SELF;
	if(!$acao)$acao="nenhuma";
	
	if($id>0){
		$row =  mysql_fetch_array(mysql_query("SELECT * FROM $tabela WHERE id ='$id'"));
		
		$q = mysql_query("SHOW COLUMNS FROM $tabela");
		while($r=mysql_fetch_object($q)){
			$campos[] = $r->Field."=".$row[$r->Field];
		}
		
		
		$chaves = array_keys($_POST);
		$valores =array_values($_POST);
		for($x=0;$x<count($_POST);$x++){
			
			$posts[] =  $chaves[$x]."=".$valores[$x];
			
		}
		
		$novos_dados=@implode($posts);
		$antigos_dados= @implode(',',$campos);
		
	}

	$navegador = $_SERVER[HTTP_USER_AGENT];
	$ip = $_SERVER[REMOTE_ADDR];
	
	mysql_query("INSERT INTO usuario_historico
				 SET usuario_id='".$usuario_id."',
					 tela='".$tela."',
					 acao='".$acao."',
					 data_hora=NOW(),
					 tabela ='$tabela',
					 tabela_id='$id',
					 novos_dados='".$novos_dados."',
					 antigos_dados = '$antigos_dados',
					 ip='$ip',
					 navegador='$navegador'
				");
	
	return 1;
	
}

function validaUsuario(){
	
	if(empty($_SESSION['usuario'])){
		
		echo "<script>alert('Voc? precisa estar logado no sistema');</script>";
		echo "<script>location='../index.php'</script>";
		exit();
		
	}
	
}

function alert($msg){
	$msg = str_replace("'","\'",$msg);
	$msg = str_replace("\n",'\n',$msg);
	echo "<script>alert('$msg');</script>";

}

function pr($v){
	echo "<pre>";
	print_r($v);
	echo "</pre>";
}

function mq($q){
	$info = mysql_query($q);
	if($info){
		return $info;	
	}else{
		echo mysql_error();	
	}
}
function mf($q){
	return mysql_fetch_object($q);
}
function mr($q){
	return mysql_result(mq($q),0,0);
}
function location($l){
	echo"<script>top.location='$l'</script>";
	exit();
}

function getExtensao($file){
	$tipo = strtolower(substr($file,-4));
	$tipo = str_replace('.','',$tipo);
	
	return $tipo;
	

}

function calcula_idade( $data_nasc ){ // entra aaaa-mm-dd

	$data_nasc = explode("-", $data_nasc);
	
	$data = date("Y-m-d");
	$data = explode("-", $data);
	$anos = $data[0] - $data_nasc[0];
	
	if ( $data_nasc[1] >= $data[1] ){
		
		if ( $data_nasc[2] <= $data[2] ){
			return $anos; break;
		}else{
			return $anos-1;
			break;
		}
	}else{
		return $anos;
	}
}
/* 
Inicio da fun??o escrever valor por estenso
para escrever por estenso dei um echo na fun??o
Ex: echo numero($numero,"moeda") ; 
caso nao deseje escrever valores reais trocar moeda por 0
*/

function unidade($unidade){
	$num_unidade = array("","um","dois","tr?s","quatro","cinco","seis","sete","oito","nove");
	if(substr($unidade,0,1) == 0){
		$num_unidade = array("00" => "","01" => "um","02" => "dois","03" => "tr?s","04" => "quatro","05" => "cinco","06" => "seis","07" => "sete","08" => "oito","09" => "nove");
	}
	return $num_unidade[$unidade];
}

function desena($desena){
	if($desena > 9 && $desena < 20){
		$num_desena = array(10 => "dez",11 => "onze",12 => "doze",13 => "treze",14=> "quatorze",15 => "quinze",16 => "dezesseis",17 => "dezessete",18 => "dezeoito",19 => "dezenove");
		return $num_desena[$desena];
	}elseif($desena > 19){
		$decimal = substr($desena,0,1);
		$unidade =substr($desena,-1);
		$num_desena = array("","","vinte","trinta","quarenta","cinquenta","sessenta","setenta","oitenta","noventa") ;
		if(substr($desena,-1) == "0"){$e = "";}else{$e = " e ";}
		return $num_desena[$decimal].$e.unidade($unidade);
	}
}

function centena($centena){
	if($centena == 100){
		return "cem";
	}else{
		$centensa = substr($centena,0,1) ;
		$desena =substr($centena,-2) ;

		$num_centena = array("","cento","duzentos","trezentos","quatrocentos","quinhentos","seiscentos","setecentos","oitocentos","novecentos",);
		if($desena < 10){
			if($desena == "00"){
				return $num_centena[$centensa];
			}else{
				$desena =substr($centena,-1) ;
				if($ventena>0){
					$e ='e';
				}
				return $num_centena[$centensa]." $e  ".unidade($desena);
			}
		}else{
				if($ventena>0){
					$e ='e';
				}
			return $num_centena[$centensa]." $e  ".desena($desena);
		}
	}
	
}

function milhar($milhar){
	$centena = substr($milhar,-3);
	$milhar = str_replace("$centena", "", $milhar);

	$tamanho = strlen($milhar);

	if(substr($centena,-3) == "000"){$e = "";}else{$e = "e ";}

	if($tamanho == 1){
		return unidade($milhar)." mil $e".centena($centena);
	}
	if($tamanho == 2){ 
		return desena($milhar)." mil $e".centena($centena);
	}
	if($tamanho == 3){
		return centena($milhar)." mil $e".centena($centena);
	}
}

function escreve($numero){
	if($numero < 10){
		return unidade($numero);
	}
	if($numero > 9 && $numero < 100){
		return desena($numero);
	}
	if($numero > 100 && $numero < 1000){
		return centena($numero);
	}
	if($numero > 999 && $numero < 1000000){
		return milhar($numero);
	}
}

function numero($valor,$tipo){
	if(preg_match('/./i', "$valor")){
			$valor = str_replace(".", "", $valor); 
		}
	if(preg_match('/,/i', "$valor")){
			$valor = str_replace(",", ".", $valor); 
		}
	list($numero,$centavos) = explode(".",$valor,2);

	if($tipo == "moeda"){
			
		if($numero > 0){
			$real = " reais ";

			if($centavos > 1){
				$real = " reais e ";
				$esc_centavos = " centavos";
			}elseif($centavos == "01"){
				$real = " reais";
				$esc_centavos = " centavo";
			}else{
				$esc_centavos = "";
			}
		}
		if($numero == 1){
			$real = " real";
			if($centavos > 0){
				$real = " real e ";
				$esc_centavos = " centavos";
			}
			if($centavos == "01"){
				$real = " real ";
				$esc_centavos = " centavo";
			}

		}
			return escreve($numero).$real.escreve($centavos).$esc_centavos;
	}else{
		return escreve($numero);
	}
}

/*
fim do escreve numero
*/

function limitador_decimal($n){
	// entra usa e sai usa
	$n = $n*1;
	$nn = explode(".",$n,2);
	
	if(strlen($nn[1])>0){
		if(strlen($nn[1])>3){
			$nn[1]= substr($nn[1],0,2);
		}
		return n($nn[0].'.'.$nn[1]);
	}else{
		return $nn[0];
	}	
}
function limitador_decimal_br($n){
	// entra usa sai br
	$n = $n*1;
	$nn = explode(".",$n);
	
	if(strlen($nn[1])>0){
		if(strlen($nn[1])>3){
			$nn[1]= substr($nn[1],0,2);
		}
		return $nn[0].','.$nn[1];
	}else{
		return $nn[0];
	}	
}
function limitador_decimal_usa($n){
	// entra br sai usa
	$n = $n;
	$nn = explode(",",$n);
	
	if(strlen($nn[1])>0){
		if(strlen($nn[1])>3){
			$nn[1]= substr($nn[1],0,2);
		}
		return $nn[0].'.'.$nn[1];
	}else{
		return $nn[0];
	}	
}

function n($n){
	return moedaUsaToBr($n);
}

/*--*/
function LimitarString($string,$tamanho=NULL){
			$pontos = "<i style='font-size:10px;'>...</i>";
			if(!empty($tamanho)){
				if(strlen($string) > $tamanho)
					return trim(substr($string,0,$tamanho)," ").$pontos;	
				 else
					return $string;
			} else{
					return $string;	
			}
}



function qtdUsaToBr($v,$limitador=NULL){
	
	/*
	Serve para retornar um valor com virgula ou se for inteiro sem casas decimais, caso casas decimais tenha seja definido ca chamada da funcao
	*/
	$v = $v *1;
	
	if($limitador==NULL){
		$nv = str_replace('.',',',$v);
		return $nv;
	}else{
		if(strpos($v,'.')){
			return number_format($v,$limitador,',','.');
		}else{
			return $v;
		}
	}
	
}

function qtdBrToUsa($v){
	
	/*
	Serve para retornar um valor com virgula ou se for inteiro sem casas decimais, caso casas decimais tenha seja definido ca chamada da funcao
	*/
	$v=$v.'';
	$nv = str_replace('.','',$v);
	$nv = str_replace(' ','',$nv);
	$nv = str_replace(',','.',$nv);
	
	return $nv;	
}

function removeAcentos($string, $slug = false) {
	$string = strtolower($string);
	// C?digo ASCII das vogais
	$ascii['a'] = range(224, 230);
	$ascii['e'] = range(232, 235);
	$ascii['i'] = range(236, 239);
	$ascii['o'] = array_merge(range(242, 246), array(240, 248));
	$ascii['u'] = range(249, 252);

	// C?digo ASCII dos outros caracteres
	$ascii['b'] = array(223);
	$ascii['c'] = array(231);
	$ascii['d'] = array(208);
	$ascii['n'] = array(241);
	$ascii['y'] = array(253, 255);

	foreach ($ascii as $key=>$item) {
		$acentos = '';
		foreach ($item AS $codigo) $acentos .= chr($codigo);
		$troca[$key] = '/['.$acentos.']/i';
	}

	$string = preg_replace(array_values($troca), array_keys($troca), $string);

	// Slug?
	if ($slug) {
		// Troca tudo que n?o for letra ou n?mero por um caractere ($slug)
		$string = preg_replace('/[^a-z0-9]/i', $slug, $string);
		// Tira os caracteres ($slug) repetidos
		$string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
		$string = trim($string, $slug);
	}

   $string = eregi_replace('( )','',$string);
	//tirando outros caracteres invalidos
	$string = eregi_replace('[^a-z0-9\-]','',$string);
	$string = eregi_replace('--','-',$string);
	return $string;
}

function cria_menu($pai_id,$nivel,$lista_itens_menu ){
// nao esta sendo usada
	$q = mysql_query($t="SELECT p . *
FROM usuario_tipo_modulo AS t, sis_modulos AS m, sis_modulos AS p
WHERE usuario_tipo_id = '".$_SESSION['usuario']->usuario_tipo_id. "'
AND m.id = t.modulo_id
AND m.modulo_id = p.id
AND p.modulo_id = '$pai_id'
GROUP BY p.id
ORDER BY p.ordem_menu, p.nome, m.ordem_menu, m.nome
");
			///echo $t.mysql_error();
	$nivel++;
	
	while($r = mysql_fetch_object($q)){		

		$q2 = mysql_query($t="SELECT m.* FROM usuario_tipo_modulo as t ,sis_modulos as m WHERE m.id=t.modulo_id AND usuario_tipo_id = '".$_SESSION['usuario']->usuario_tipo_id. "' AND m.modulo_id='$r->id' order by ordem_menu,nome ");
		//	echo $t.mysql_error();
		$filhos=array();
		while($r2 = mysql_fetch_object($q2)){		
			$filhos[$r2->id] = array(
				'id'=>$r2->id,
				'pai'=>$r2->modulo_id,
				'nome'=>$r2->nome,
				'ordem'=>$r2->ordem_menu,
				'acao_menu'=>$r2->acao_menu,
				'ativo'=>$r2->acao_menu,
				);
		
		}
		$lista_itens_menu[$r->modulo_id][]= array(
			'id'=>$r->id,
			'pai'=>$r->modulo_id,
			'nome'=>$r->nome,
			'ordem'=>$r->ordem_menu,
			'acao_menu'=>$r->acao_menu,
			'ativo'=>$r->acao_menu,
				
				'filhos' => $filhos
			);
			
		$lista_itens_menu = cria_menu($r->id,$nivel,$lista_itens_menu );

	}
	
	return $lista_itens_menu;
}
function conta_sms_mes($vkt_id){
		$n=mysql_result(mysql_query($t="SELECT COUNT(*) FROM rel_sms WHERE vkt_id='$vkt_id' AND month(data_envio)=month(now()) AND year(data_envio)=year(now())"),0,0);
	//	echo $t;
		return $n;
	
}
function envia_sms($telefone,$msg,$from,$cliente_id){
	
		global $vkt_id;
		$telefone = str_replace('(','',$telefone);
		$telefone = str_replace(')','',$telefone);
		$telefone = str_replace('-','',$telefone);
		$telefone = str_replace(' ','',$telefone);
		$telefone = str_replace('.','',$telefone);
	
		$id = file_get_contents("http://webapi.comtele.com.br/api/api_fuse_connection.php?fuse=get_id&user=50624&pwd=novo624");
		
		$id = trim($id);
		
		
		//echo "?fuse=send_msg&id=".rawurlencode($id)."&from=".rawurlencode($origem)."&msg=".rawurlencode($msg)."&number=".rawurlencode($telefone);
		
		$url = "http://webapi.comtele.com.br/api/api_fuse_connection.php?fuse=send_msg&id=".rawurlencode($id)."&from=".rawurlencode($origem)."&msg=".rawurlencode( utf8_encode($msg))."&number=".rawurlencode($telefone);
		$conta_sms_mes = conta_sms_mes($vkt_id);	
		if($conta_sms_mes<=$_SESSION[sms]){
	
			$r = file_get_contents($url);
			echo "'$r'";
			if(strpos($r,'true')){
				echo 'entrou true'; 
				$sql = mysql_query($t="INSERT INTO rel_sms (vkt_id,cliente_id,numero_destino,msg,data_envio,status) VALUES($vkt_id,$cliente_id,'$telefone','$msg',now(),'1')");
			}else{
				echo 'entrou false'; 	
			}
		}else{
			echo "<scipt>alert('sms excedido')</script>"; 
		}
}
function config_envia_email ($smtp, $porta, $senha, $usuario, $remetente, $remetentenome, $destinatario, $destinatarionome, $assunto, $mensagem, $debug) {
 
  $headers = "MIME-Version: 1.0\r\n".
             "Content-type: text/html; \r\n".
             "Precedence: bulk\r\n".
            "From: \"" . $remetentenome . "\" <" . $remetente . ">\r\n".
             "Reply-To: \"" . $remetentenome . "\" <" . $remetente . ">\r\n".
             "To: \"" . $destinatarionome . "\" <" . $destinatario . ">\r\n".
             "Subject: " . $assunto . " \r\n";

  $corpo = "\r\n<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n". 
           "<body bgcolor=\"#FFFFFF\">\r\n".
           $mensagem . "\r\n".
           "</body>\r\n".
           "</html>\r\n".
           "\n";
  $conn = fsockopen($smtp, $porta, $errno, $errstr, 30);
  fputs($conn, "EHLO " . $smtp . "\r\n");
  fputs($conn, "AUTH LOGIN\r\n");
  fputs($conn, base64_encode($usuario) . "\r\n");
  fputs($conn, base64_encode($senha) . "\r\n");
  fputs($conn, "MAIL FROM: " . $remetente . "\r\n");
  fputs($conn, "RCPT TO: " . $destinatario . "\r\n");
  fputs($conn, "DATA\r\n");
  fputs($conn, $headers);
  fputs($conn, $corpo . "\r\n");
  fputs($conn, ".\r\n");
  fputs($conn, "QUIT\r\n");
  $log = "";
  
  
  /*
  
    $response = fgets($socket,4096);
  if ($debug) echo $response;
*/
  while (!feof($conn)) {
    $log .= fgets($conn) . "<BR>\n";
  }
 	 $log .= $headers;
	 $log .= $corpo;
	// echo $log;
   fclose($conn);
}

function envia_emailx($nome,$email,$assunto,$mensagem){
//	echo "'cloud.vkt.srv.br', '587', 'cdwq8i9o','vekttor@vkt.srv.br', 'vekttor@vkt.srv.br', 'Vekttor', $email, $nome, $assunto, $mensagem, true";
	config_envia_email ('cloud.vkt.srv.br', '587', 'cdwq8i9o','vekttor@vkt.srv.br', 'vekttor@vkt.srv.br', 'Vekttor', $email, $nome, $assunto, $mensagem, true);
}


?>