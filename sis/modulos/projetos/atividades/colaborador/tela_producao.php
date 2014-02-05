<?
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_function_colaborador_geral.php");

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Atividade Colaboradores Produção</title>
    <meta http-equiv="refresh" content="5"> 
</head>
<style>
BODY{ background:url(img/BGT.png) repeat-x #D8D8D8; font-family:Arial, Helvetica, sans-serif; color:#575757; font-size:12px;}
.colaborador{background:url(img/bgb.png); height:149px; width:382px; float:left}
.divisor {float:left; margin-right:0px; width:390px; height:400px;}
</style>
<body>


<div style="width:1583px;  height:125px; background:url(img/topo.png)"></div>
<?
$q= mq("SELECT * FROM usuario WHERE cliente_vekttor_id ='1'");
while($r=mf($q)){
	if($r->id==5||$r->id==6||$r->id==32||$r->id==65||$r->id==66){
	
		$ultima_atividade_tempo = verifica_ultima_situacao_usuario($r->id);
	
		$ultima_atividade = retorna_atividade($ultima_atividade_tempo->atividade_id);
		
		if(strpos($r->nome,' ')>0){
			$nome = substr($r->nome,0,strpos($r->nome,' '));
		}else{
			$nome = $r->nome;
		}
		if($ultima_atividade_tempo->id>0){
			$impp = 'p';
		}else{
			$impp = 'pa';
		}
		
		$tempo_andamento = calcula_tempo_andamento($ultima_atividade,$ultima_atividade_tempo);
		$tempo_atividade = substr($ultima_atividade->tempo_estimado_horas,0,5);
		$tempo_andamento_sec = mysql_result(mysql_query($t="SELECT TIME_TO_SEC('$tempo_andamento:00')"),0,0);
		$tempo_atividade_sec = mysql_result(mysql_query("SELECT TIME_TO_SEC('$tempo_atividade:00')"),0,0);
		
		
		
		if($tempo_andamento_sec>$tempo_atividade_sec){
			$cor_time= 'red';
		}else{
			$cor_time= '';
		}
		
	?>
    <div class='divisor'>
    <div class='colaborador'>
    <img src="img/<?=$r->id?>.jpg" width="61" height="81"  style="margin:34px 10px 0 14px; float:left;"/> 
	<div style="float:right; width:112px; height:57px;  font-size:16px; margin:25px 10px 0 0;">
    	<div style="float:left; margin-top:5px;">
			<span style="color:<?=$cor_time?>"><?=$tempo_andamento?></span><br />
            <span style="font-size:11px;"><?=$tempo_atividade ?></span>
    	</div> 
        <img src="img/<?=$impp?>.png" width="50" height="50" style="float:right" />
    </div>
    <div style="font-size:30px; margin:30px 0 0 0px; float:left; width:170px; height:50px;"><?=$nome?></div>
  <div style="font-size:14px; margin-left:10px; "><?=$ultima_atividade->nome?>(<?=soma_horas_diaAtividade(date('Y-m-d'),$r->id)?>)</div>
  </div>
  <?
  	if($ultima_atividade->id>0){
  		$qa= mq($t="SELECT * FROM projetos_atividades WHERE projeto_id='$ultima_atividade->projeto_id' AND funcionario_id='$r->id' AND id <>'$ultima_atividade->id' AND situacao ='0'   LIMIT 4");
	}else{
  		$qa= mq($t="SELECT * FROM projetos_atividades WHERE  funcionario_id='$r->id' AND situacao ='0'  LIMIT 4");
	}
	while($ra=mf($qa)){
  ?>
  <div style="width:390px; height:57px; background:url(img/bgxz.png);overflow:hidden; float:left;"><div style="line-height:57px; font-size:18px; margin:0 20px 0 20px; overflow:hidden;"><?=$ra->nome?></div></div>
  <?
  	}
  ?>
  </div>	
    <?
	}
}

?>

</body>
</html>