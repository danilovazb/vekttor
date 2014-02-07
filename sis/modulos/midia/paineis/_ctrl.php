<?


if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}

if($_POST['action']=='Salvar'){
	$ultimo_cadastrado=salvaPainel($_POST);
}

if($_POST['action']=='Excluir'){
	$salvou=deletaPainel($_POST['id']);
}


if($id>0){
	$painel=mf(mq("
				SELECT 
				*,
					TIME_FORMAT(seg_ini,'%H:%i') as seg_ini,
					TIME_FORMAT(ter_ini,'%H:%i') as ter_ini,
					TIME_FORMAT(qua_ini,'%H:%i') as qua_ini,
					TIME_FORMAT(qui_ini,'%H:%i') as qui_ini,
					TIME_FORMAT(sex_ini,'%H:%i') as sex_ini,
					TIME_FORMAT(sab_ini,'%H:%i') as sab_ini,
					TIME_FORMAT(dom_ini,'%H:%i') as dom_ini,
					TIME_FORMAT(seg_fim,'%H:%i') as seg_fim,
					TIME_FORMAT(ter_fim,'%H:%i') as ter_fim,
					TIME_FORMAT(qua_fim,'%H:%i') as qua_fim,
					TIME_FORMAT(qui_fim,'%H:%i') as qui_fim,
					TIME_FORMAT(sex_fim,'%H:%i') as sex_fim,
					TIME_FORMAT(sab_fim,'%H:%i') as sab_fim,
					TIME_FORMAT(dom_fim,'%H:%i') as dom_fim
				 FROM paineis WHERE id='$id'"
			));
}

