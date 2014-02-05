<?
include("sis/_config.php");

if($_SESSION['usuario']->id>0&&$_GET[cliente_id]<1){
	if($_SESSION['usuario']->tela_inicial>0){
		echo "<script>location='sis/?tela_id=".$_SESSION['usuario']->tela_inicial."'</script>";
	}else{
		echo "<script>location='sis/'</script>";
	}

	exit();
}
if($_GET[cliente_id]>0){
	setcookie('jI8u',0,time()+(3600*24*7));
	$_COOKIE['jI8u']=0;

}
if((isset($_POST['login'])&&isset($_POST['senha']))||$_COOKIE['jI8u']>0){
	$login = mysql_real_escape_string($_POST['login']);
	$login = str_replace("'",'',$login);
	$login = str_replace("=",'',$login);
	
	$senha = mysql_real_escape_string($_POST['senha']);
	$senha = str_replace("'",'',$senha);
	$senha = str_replace("=",'',$senha);
	
	if($_COOKIE['jI8u']>0){
		$usuario_id= (sqrt($_COOKIE['jI8u'])/7)-8;
		$usuario=mysql_fetch_object(mysql_query($t="SELECT * FROM usuario WHERE id='$usuario_id' AND status='1'"));
	}else{
		$usuario=mysql_fetch_object(mysql_query($t="SELECT * FROM usuario WHERE login='$login' AND senha='$senha' AND login!='' AND senha!='' AND status='1' LIMIT 1"));
		//echo $t;
	}
	
	$sis_cliente_vekttor = mysql_fetch_object(mysql_query($t="SELECT * FROM `clientes_vekttor`  WHERE id= '$usuario->cliente_vekttor_id'"));

	if($usuario->id>0 && $sis_cliente_vekttor->status==1){
		$_SESSION['usuario']=$usuario;
		
		$_SESSION['usuario_tipo']='usuario';
		// DECODIFICA
			if($sis_cliente_vekttor->img==1){
				setcookie('jI8i', pow(($sis_cliente_vekttor->id+8)*7,2), time()+(3600*25*7));
			}else{
				setcookie('jI8i', pow((0+8)*7,2), time()+(3600*25*7));
			}
			if($_POST[manter]==1){
				setcookie('jI8u', pow(($usuario->id+8)*7,2), time()+(3600*25*7));
				
			}
			$_SESSION[nome] 	= $sis_cliente_vekttor->nome;
			$_SESSION[cnpj] 	=  $sis_cliente_vekttor->cnpj;
			$_SESSION[endereco] =  $sis_cliente_vekttor->endereco;
			$_SESSION[bairro] =  $sis_cliente_vekttor->bairro;
			$_SESSION[cidade] =  $sis_cliente_vekttor->cidade;
			$_SESSION[estado] =  $sis_cliente_vekttor->estado;
			$_SESSION[cep] 	 =  $sis_cliente_vekttor->cep;
			$_SESSION[img] 	 =  $sis_cliente_vekttor->img;
			$_SESSION[telefone] 	 =  $sis_cliente_vekttor->telefone;
			$_SESSION[sms] 	 =  $sis_cliente_vekttor->quantidade_sms_mes;
			mysql_query($t="UPDATE clientes_vekttor SET ultimo_acesso=now() WHERE id= '$sis_cliente_vekttor->id'");
		//	echo $t;
			$qacessos = mysql_query($t="SELECT m.id,m.modulo_id FROM usuario_tipo_modulo as a ,sis_modulos as m  WHERE a.usuario_tipo_id = '$usuario->usuario_tipo_id' AND m.id=a.modulo_id");

		while($acessos = mysql_fetch_object($qacessos)){
			$_SESSION[acesso][$acessos->id]=1;
			$_SESSION[acesso][$acessos->modulo_id]=1;
		}
		if($usuario->tela_inicial>0){
			echo "<script>location='sis/?tela_id=$usuario->tela_inicial&NKJHiU'</script>";
		}else{
			if($usuario->ultima_tela_id>0){
			echo "<script>location='sis/?tela_id=$usuario->ultima_tela_id&NKJHiU'</script>";
			}else{
				echo "<script>location='sis/'</script>";
			}
		}
		
		exit();
	}else{
		// pesquisa aluno
		//echo 'tenteou buscar o aluno';
		$aluno=mysql_fetch_object(mysql_query($t="SELECT * FROM escolar2_alunos WHERE id='$login' AND senha='$senha' AND id!='' AND senha!=''  LIMIT 1"));
		$usuario=$aluno;
		//print_r($usuario);
		$sis_cliente_vekttor = mysql_fetch_object(mysql_query($t="SELECT * FROM `clientes_vekttor`  WHERE id= '$usuario->vkt_id'"));
			if($usuario->id>0 && $sis_cliente_vekttor->status==1){

				$_SESSION['aluno']=$aluno;
				$_SESSION['usuario_tipo']='aluno';
				$_SESSION['usuario']=$usuario;
				$_SESSION['usuario']->cliente_vekttor_id=$aluno->vkt_id;
				$_SESSION['usuario']->usuario_tipo_id='aluno';
			//$_SESSION['aluno']->id
				
				$_SESSION[nome] 	= $sis_cliente_vekttor->nome;
				$_SESSION[cnpj] 	=  $sis_cliente_vekttor->cnpj;
				$_SESSION[endereco] =  $sis_cliente_vekttor->endereco;
				$_SESSION[bairro] =  $sis_cliente_vekttor->bairro;
				$_SESSION[cidade] =  $sis_cliente_vekttor->cidade;
				$_SESSION[estado] =  $sis_cliente_vekttor->estado;
				$_SESSION[cep] 	 =  $sis_cliente_vekttor->cep;
				$_SESSION[img] 	 =  $sis_cliente_vekttor->img;
				echo "<script>location='sis/'</script>";
				exit();
			}else{
				
			}
	}
}
session_destroy();
setcookie('jI8u',0,time()+(3600*24*7));
?>

<html>
<head>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.png" type="image/png" />
<link rel="apple-touch-icon-precomposed" href="favicon.png"></link>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" href="fontes/css/sis.css">

<meta name="viewport" content="initial-scale=1.0; maximum-scale=0.8; user-scalable=0;"/>
<title>Vekttor</title>
<style>
 body{background:url(fontes/img/bglogin.png) repeat-x}
</style>
<link href="fontes/css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" /><!-- -->
<script src="fontes/js/sis.js"></script> <!-- -->
<script src="fontes/js/jquery.min.js"></script>
<script src="fontes/js/tooltip.js"></script>
<script src="fontes/js/menu.js"></script>
<script src="fontes/js/notificacao.js"></script>
<script>
localStorage.setItem("menuteste", '');

</script>
</head>

<body style="padding:0px; margin:0px;  ">
	<div id="topo" style="width:100%; float:left; ">
    <div style="height:130px; background:url(<?
	$imgid= (sqrt($_COOKIE['jI8i'])/7)-8;
	if($_COOKIE['jI8i']==0){
		echo "fontes/img/vekttor.png";
	}else{
		echo "sis/modulos/vekttor/clientes/img/$imgid.png";
	}
	?>) no-repeat center;"></div>
    
</div>
    <div style="background:url(fontes/img/bginputlogin.png) no-repeat center center; clear:both ; height:300px; ">
    <div style="height:50px; clear:both; "></div>
	<form action="" method="post" style="width:305px;  margin:20px auto 0 auto; font-family:Tahoma, Geneva, sans-serif; font-size:12px; font-weight:bold; display:block;color:#666 ">
		<label style="width:200px; float:left; margin-bottom:5px; ;" >Login</label>
		<input name="login" id="login" style="width:200px; float:left; margin-bottom:10px; border-radius:5px; border:1px solid #CCC; padding:5px; font-size:18px; color:#999; box-shadow:0px 0px 5px #999" type="text" value="" />
        <script>
        document.getElementById('login').focus();
        </script>
		<label style="width:200px; float:left; margin-bottom:5px">Senha</label>
		<input name="senha" style="width:200px; float:left; margin-bottom:10px; border-radius:5px; border:1px solid #CCC; font-size:18px;padding:5px; color:#999; box-shadow:0px 0px 5px #999" type="password" value="" />
        <div style="clear:both; height:10px;"></div>
 		<input style="float:right;" type="submit" value="Enviar" />
       
       <label style=" display:block;float:right; width:200px; font-weight:normal; text-align:right; margin-right:5px; font-size:9; color:#666"> <input type="checkbox" name="manter" value="1" /> Manter Conectado</label>
	</form>
    </div>
 <div style="background:url(fontes/img/assinaturavkt.png)"></div>   
 <div style="background:url(fontes/img/bt2.jpg)"></div>
 <?
/*
echo "<pre>";
print_r($_SERVER);
//echo $_SERVER[HTTP_USER_AGENT];
if(strpos($_SERVER[HTTP_USER_AGENT],'iPhone')>0){
	echo "<script>alert('coloque como favorito')</script>";
}
//print_r($_COOKIE);echo "($imgid)";
echo "<pre>";
*/
?>
</body>
</html>
