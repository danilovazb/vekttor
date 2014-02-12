<?
include("../../../../_config.php");
include("../../../../_functions_base.php");
include('form_planeja_midia_functions.php');
if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}



if($_GET['action']=='Abrir'){
	if($id>0){
		$orcamento=mf(mq($x="
			SELECT 
				po.id, 
				po.numero_proposta, 
				po.numero_pi,
				po.descricao,
				po.segundos_vt,
				cf.nome_fantasia as cliente
			FROM 
				paineis_orcamento as po, 
				cliente_fornecedor as cf 
			WHERE 
				po.vkt_id='$vkt_id'
			AND
				po.id='$id' 
			AND 
				cf.id = po.cliente_fornecedor_id 
		"));
		
		$selecionados=$_GET['selecionados'];

		$menor = mr("SELECT data_inicio FROM paineis_orcamento_item WHERE id IN ($selecionados) ORDER BY data_inicio ASC LIMIT 1");
		$maior = mr($a="SELECT data_fim FROM paineis_orcamento_item WHERE id IN ($selecionados) ORDER BY data_fim DESC LIMIT 1");
		$intervalo = mr($t="SELECT DATEDIFF('$maior','$menor')");
		$largura_tabela=150+($intervalo*90);
		$itens_q=mq($x="
			SELECT 
				p.nome as painel, 
				pi.*
			FROM 
				paineis_orcamento_item as pi,
				paineis as p
			WHERE
				pi.painel_id = p.id 
			AND
				pi.id IN ($selecionados)
		");
		$insercoes_q=mq($x="
			SELECT 
				h.*
			FROM 
				paineis_consumo_hora as h
			WHERE
				painel_orcamento_item_id IN ($selecionados)
		");
		
		$maior_intervalo 	= 0;
		$total_insercoes 	= 0;
		$total_planejadas 	= 0;
		
		while($item=mf($itens_q)){
			$total_insercoes+=$item->quantidade_insercoes;
			$item_orcamento[]=$item;
		}
		
		while($insercoes=mf($insercoes_q)){
			$total_planejadas += $insercoes->insercoes;
			$insercao_ocupada[$insercoes->painel_orcamento_item_id][$insercoes->data] = $insercoes->insercoes;
			$insercoes_painel[$insercoes->painel_orcamento_item_id] += $insercoes->insercoes;
			$insercoes_dia[$insercoes->data] += $insercoes->insercoes;
		}
		
		include("form_planeja_midia.php");	
	}
}
if($_GET['action']=='Inserir'){
	Inserir($_POST);
}