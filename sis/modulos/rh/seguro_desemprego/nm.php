<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>emissao</title>
<style type="text/css">
<!--
body {		background-repeat:no-repeat;	font-family:"Lucida Console","Lucida Sans Unicode", "Lucida Grande", sans-serif;	font-size:14px;	letter-spacing:10px;	word-spacing:-4px;}
div{position:absolute;}

#nome{top:95px; left:33px;}
#nomeMae{top:145px; left:33px;}
#endereco{top:195px; left:33px;}

#complemento{top:240px; left:33px;}
#cep{
	top:232px;
	left:335px;
}
#uf{
	top:232px;
	left:502px;
}
#telefone{
	top:232px;
	left:563px;
}

#PIS{top:297px; left:33px;}
#carteira{top:297px;left:292px;}
#carteira_n{
	top:297px;
	left:452px;
}
#carteira_s{
	top:297px;
	left:400px;
}
#CPF{
	top:298px;
	left:540px;
}

#tipo{	top:365px;	left:122px;}
#cnpj{	top:366px;	left:159px;}
#ativEconomica{
	top:365px;
	left:437px;
}

#CBO{	top:414px;	left:33px;}
#cboDescricao{	top:414px;	left:160px;}

#emissao{
	top:502px;
	left:30px;
}
#dispensa{
	top:502px;
	left:179px;
}
#sexo{
	top:502px;
	left:383px;
}
#instrucao{
	top:502px;
	left:471px;
}
#nascimento{
	top:502px;
	left:551px;
}
#horas_trabalhadas{
	top:502px;
	left:683px;
}

#mes{
	top:553px;
	left:31px;
}
#antepenutimoSalario{
	top:553px;
	left:75px;
}
#mes2{
	top:553px;
	left:278px;
}
#penultimoSalario{
	top:553px;
	left:324px;
}
#mes3{
	top:553px;
	left:516px;
}
#utimoSalario{
	top:553px;
	left:554px;
}
#somaSalarios{
	top:608px;
	left:33px;
}
#bancario{
	top:608px;
	left:280px;
}
#mesesTrabalhados{
	top:605px;
	left:694px;
}
#recebeuSalario{
	top:648px;
	left:212px;
}
#avisoPrevio{	top:649px;	left:431px;}
#pisPazepNit2{	top:935px;	left:33px;}
#nome2{	top:982px;	left:33px;}
-->
</style></head>

<body style="height:1200px; margin:0px; padding:0px;">
	<img src="bg2.png" style="width:187mm" />
<div id='nome'><?=$empregado?></div>
	<div id='nomeMae'><?=$mae?></div>
	<div id='endereco'><?=$endereco?></div>
	<div id='complemento'><?=$complemento?></div>
	<div id='cep'><?=$cep?></div>
	<div id='uf'style="letter-spacing:9px;"><?=$uf?></div>
<div id='telefone' style="letter-spacing:9px;"><?=$telefone?></div>
<div id='PIS'><?=$pis?></div>
	<div id='carteira'><?=$ctps?></div>
	<div id='carteira_n'><?=$ctps_uf?></div>
	<div id='carteira_s'><?=$ctps_numero?></div>
<div id='CPF' style="letter-spacing:9px"><?=$cpf?></div>
<div id='tipo'><?=$tipo_inscricao?></div>
	<div id='cnpj' style="letter-spacing:9px"><?=$cnpj?></div>
	<div id='ativEconomica'><?=$atividade?></div>
<div id='CBO'><?=$cbo?></div>
<div id='cboDescricao'><?=$ocupacao?></div>
<div id='emissao'><?=$admissao?></div>
	<div id='dispensa'><?=$dispensa?></div>
	<div id='sexo'><?=$sexo?></div>
	<div id='instrucao'><?=$grau?></div>
	<div id='nascimento'><?=$nascimento?></div>
	<div id='horas_trabalhadas'><?=$horas?></div>
<div id='mes'><?=$mes2?></div>
	<div id='antepenutimoSalario'><?=$salario2?></div>
	<div id='mes2'><?=$mes3?></div>
	<div id='penultimoSalario'><?=$salario3?></div>
	<div id='mes3'><?=$mes4?></div>
<div id='utimoSalario'><?=$salario4?></div>
	<div id='somaSalarios'><?=$soma?></div>
	<div id='bancario'><?=$banco.$agencia?></div>
	<div id='mesesTrabalhados'><?=$meses?></div>
	<div id='recebeuSalario'><?=$recebeu?></div>
	<div id='avisoPrevio'><?=$aviso?></div>
    <? if($pagina==1){ ?>
<div id='pisPazepNit2' style="letter-spacing:9px"><?=$pis?></div>
	<div id='nome2'><?=$empregado?></div>
	<?
    }
	?>
																																																																																																																							                                                                                                             </div></body>
</html>
