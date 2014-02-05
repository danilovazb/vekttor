<?
session_start();
$inicio_carregamento=microtime(true);

$titulo 	= 'Vekttor';
// offline

$host		= 'localhost';
$bd			= 'nv_sistema';
// online
$host		= 'localhost';
$login_bd	= 'nv';

//k6hop62amvfi
$senha_bd	= 'k6hop62amvfi';
$login_bd	= 'root';
$senha_bd	= '';
$bd			= 'nv_sistema';

/////

if($login_bd=='root'){
	
	/* manda informaçoes do ip offiline para o servidor online
	
	$meuip = file_get_contents("http://vkt.srv.br/~nv/checaip.php");

	mysql_connect('vkt.srv.br','nv','ybu4zfs60h')or die("nao conectou");
	mysql_select_db('nv_sistema')or die("nao acessiy");
	
	mysql_query("INSERT INTO ip_vekttor_local SET ip='$meuip',data_hora=now()")or die(mysql_error());
	mysql_close();
	*/
}


$empresa[nome] = $_SESSION[nome];
$empresa[cnpj] = $_SESSION[cnpj];
$empresa[endereco] = $_SESSION[endereco] ;
$empresa[bairro] = $_SESSION[bairro];
$empresa[cidade] = $_SESSION[cidade];
$empresa[estado] = $_SESSION[estado];
$empresa[cep] = $_SESSION[cidade];
$empresa[img] = $_SESSION[img];

$cliente_id=$_SESSION['usuario']->cliente_vekttor_id;
$cliente_tipo_id=$_SESSION['usuario']->usuario_tipo_id;

$vkt_id= $cliente_id;

if($empresa[img]==1){
	$logo ='modulos/vekttor/clientes/img/'.$vkt_id.'.png';
}else{
	$logo ='../fontes/img/vekttor.png';
}

global $vkt_id;

$usuario_id=$_SESSION['usuario']->id;
$usuario_cliente_fornecedor_id = $_SESSION['usuario']->cliente_fornecedor_id;
$login_id = $usuario_id;

global $login_id,$usuario_id;

$semana_abreviado = array("Dom","Seg","Ter","Qua","Qui","Sex","Sab");
$semana_extenso = array("Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado",);
$mes_abreviado = array("Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez");
$mes_extenso = array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
$bancos_codigos=array(001=>'Banco do Brasil',033=>'Banco Santander(Brasil) S.A.',237=>'Bradesco',104=>'Caixa Econômica Federal',409=>'Itaú Unibanco S/A',399=>"HSBC");

mysql_connect($host,$login_bd,$senha_bd);
mysql_select_db($bd);

//require_once("sysms/SendSms.php");
//			$config->SetHostEnvio('10.0.1.109'); /* Servidor*/
	//		$config->SetPortEnvio('8800');
			
			/*
			*	Modo de Envio do Servidor   0 = Modem , 1 = ComTele
			*/
		//	$config->SetServidorEnvio(0);
			
			//$config->SMSEnvia(5,'9282211733','teste');


?>