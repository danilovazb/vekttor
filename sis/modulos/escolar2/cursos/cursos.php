<?php
$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 
include ("_functions.php");
include ("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<style>
.adiciona{ margin-top:0px; float:right}
.remove{ margin-top:0px; float:right}
.erro{ color:#F33;}
.status_add_mat{ display:none;}
#label_materia input{ color:#999;  }
#serie_materia tr { background:#FFF;}
#serie_edit tr { background:#FFF;}
#lista_serie tr { background:#FFF;} 
</style>
<script type="text/javascript">

$(document).ready(function(){
	$("tr:odd").addClass('al');
});

$(document).ready(function (){
	 
 $("#tabela_dados tr").live("click",function(){  
	  var ensino = $(this).attr('ensino');
	  var serie_id = $(this).attr("serie");
	  if( $.trim($(this).attr("ensino")) != ""){
		  window.open('modulos/escolar2/cursos/form.php?id='+ensino+'&serie_id='+serie_id,'carregador');
	  } else if( $.trim($(this).attr("serie")) != "" ) {	
		 window.open('modulos/escolar2/cursos/form_serie.php?serie_id='+serie_id,'carregador');
	  }
	  
 });
 
 $("#adiciona_serie").live("click",function(){
	 
   var idade_min = $("#idade_min").val();
   var idade_max = $("#idade_max").val();
   
   var aula_dia = $("#aulas_por_dia").val(); 
   
   if( $.trim($("#ensino_id").val()) != "" && $.trim($("#serie").val()) != "" ){
   
	 var serie     = $("#serie").val();	
	 var ordem     = $("#ordem_ensino").val();
	 var ensino_id = $("#ensino_id").val();
	 var html_lista = "";
	 
	 $.post("modulos/escolar2/cursos/requisicao.php",{
			funcao:"serie_as_ensino",
			ordem:ordem,serie:serie,
			ensino_id:ensino_id,
			idade_min:idade_min,
			idade_max:idade_max,
			aula_dia:aula_dia
		},function(data){
		 html_lista += " <tr id="+data+" style='background:#7A97E6; color:#FFF;'>\
		 <td width='100'>"+serie+"</td>\
		 <td width='30'>"+ordem+"</td>\
		 <td>"+idade_min+"</td>\
         <td>"+idade_max+"</td>\
		 <td>"+aula_dia+"</td>\
		 <td style='padding-left:5px;'><div style='width:10px;'><a href='#' id='remove_serie'>excluir</a></div></td>\
		 </tr>";
		 $("#lista_serie").append(html_lista);
	 	 //$("#lista_serie tr:odd").addClass('al');
	     $("#serie").val("");
		 $("#aulas_por_dia").val(1);
		 $("#idade_min").val(0);
		 $("#idade_max").val(0);
	 });
   
   } else {
		alert("Informe Ensino/Série");
		return false;   
   }
 
 });
 
});
</script>

<script>

$("#ensino").live("click",function(){
	window.open('modulos/escolar2/ensino/form.php','carregador');
});
//
$("#materia").live("focus",function(){
	var texto = $(this).val(); 
	$(this).css("color","#333");
	if( ($.trim($(this).val()) != "Matéria") &&  ($.trim($(this).val()) != "")){
		$(this).val(texto);
	} else {
		$(this).val("");
	}
	
});
//
$("#materia").live("blur",function(){
	if( ($.trim($(this).val()) != "Matéria") &&  ($.trim($(this).val()) != "")){
		return true;	
	} else {
		$(this).val("Matéria");
		$(this).css("color","#999");
	}
});

/* script adicionar materia */
var serie_existe = "";
var html_lista = "";
var cabecalho = "";
var valida = 0;

$("#add_materia").live("click",function(){
	var erros = 0; var msg = "";
	var serie    = $("#nome_serie").val();
	var serie_id = $("#serie_id").val();
	var grupo_id = $("select#grupo_materia_id").val();
	var grupo    = $("#grupo_materia_id option:selected").text();
	
	var materia_id = 0;
	
	if( $.trim($("#materia_id").val()) != ""){
		materia_id = $("#materia_id").val();
	}
	
	if( $.trim(grupo_id) == 0 ){
		
		erros++;
		msg += " Informe o grupo para materia\n";	
	
	} if( $.trim($("#materia").val()) == "" ){
		erros++;
		msg += " Informe a materia\n";
	
	} if( $.trim($("#materia").val()) == "Matéria" ){
		erros++;
		msg += " O nome da matéria não pode ser matéria \n";
	}  
	if( erros > 0 ){
		alert(msg);
	} else {
		
		var materia  = $("#materia").val();
	    var qtd_aula = $("#qtd_aula").val();
		
		if(serie_existe != serie) 
			serie_existe = serie;
		else  serie_existe = "";
	
		var html_lista = "";
		
		if(valida == 0){ 
		   if($.trim($("#n_serire_id").val())  == ""){
			cabecalho = "<tr><td width='80'>"+serie_existe+"</td><td width='50'></td> <td>  </td> </tr>";
			html_lista += cabecalho;
		   }
		}
		$(".status_add_mat").show();
		
		$.post("modulos/escolar2/cursos/requisicao.php",{ funcao:"serie_has_materia",
			serie_id:serie_id,
			qtd_aula:qtd_aula,
			materia:materia,
			materia_id:materia_id,
			grupo_id:grupo_id
		  }, function(data){	 
			$(".status_add_mat").hide();
			
		  $.each(data.result,function(i,item){
			  var mat_id;
			  
			  console.log(item.materia_id);
			  
			  if( $.trim(materia_id) == 0 )
				  mat_id = item.materia_id;
			  else 
				  mat_id = materia_id;
				  
			  html_lista += "<tr id='"+item.serie_materia_id+"' materia_id='"+mat_id+"'>"+
							"<td width='80'>"+grupo+"</td>"+
							"<td width='50' class='n_materia_"+mat_id+"' id='n_materia'>"+materia+"</td>"+
							"<td><div style='width:10px; text-align:center'><a href='#' id='remove_materia'>excluir</a></div></td></tr>";
		  });
			
			
			if($.trim($("#n_serire_id").val())  != ""){
				$("#serie_edit").append(html_lista);
				$("#serie_materia tr:odd").addClass('al');
			}
			else{
				$("#serie_materia").append(html_lista);
				$("#serie_materia tr:odd").addClass('al');
			}
			
			$("#serie_materia tr:odd").addClass('al');
			
			serie_existe = serie;
			
			$("select#grupo_materia_id").val("");
			
		},'json');/* $.post() */
		
		if( $.trim(cabecalho) != ""  ){ valida = 1; }
		
		$("#materia").val("");
		$("#materia_id").val("");
		$("#qtd_aula").val("1");
	}
				
});//

$("#remove_materia").live("click",function(){
	var id = $(this).parent().parent().parent().attr("id");
	var linha = $(this).parent().parent().parent();
	$(".result_materia_"+id+"").show();
	
	$(".status_add_mat").show();
	
	$.post("modulos/escolar2/cursos/requisicao.php",{funcao:"remove_serie_has_materia",id:id},function(data){
		$(".status_add_mat").hide();
		console.log(data);
		if( data == "erro")
			$("  .result_materia_"+id+"").html("<div class='erro'>Não pode ser excluido</div>").show().delay(2050).hide("slow");
		else
			linha.hide();
	});
	
});//

$("#remove_serie").live("click",function(){
	var id    = $(this).parent().parent().parent().attr("id");
	var linha = $(this).parent().parent().parent();
	var result = confirm("Deseja realmente Excluir?");
	if(result == true){
		
		$.post("modulos/escolar2/cursos/requisicao.php",{funcao:"remove_serie",id:id},function(data){
			if(data == "erro"){
				alert("Está Série está vinculada a uma matéria!");
				return false;
			} else if(data == "success"){
		  		linha.hide();
			}
			
		});
		
	} else if(result == false) {
	 	return false;
	}
});

$("#n_materia").live("click",function(){
	var $modal = $(".janela");
	var tr = $(this).closest("tr");
	var materia_id = tr.attr("materia_id");
	var serie_materia = tr.attr("id");
	var materia_nome = $(this).text();
	$modal.find("input#serie_materia_modal").val(serie_materia);
	$modal.find("input#materia_id_modal").val(materia_id);
	$modal.find("input#nome_materia").val(materia_nome);
	$(".janela").show();
});

$("#btn-at-materia").live("click",function(){
	  $(".janela .carregador").show();
	  var materia_id = $("#materia_id_modal").val();
	  var serie_materia = $("#serie_materia_modal").val();
	  var materia_nome = $("#nome_materia").val();
	  var dados = {nome:materia_nome,id:materia_id}
	  
	  $.post("modulos/escolar2/cursos/requisicao.php",{funcao:"atualiza_materia",dados:dados},function(data){
		  if(data == "success"){
			 $(".n_materia_"+materia_id).text(materia_nome);
			 $(".janela").hide();
		   }
		    $(".janela .carregador").hide();
	  });
	  
});

</script>


<div id="conteudo">
<!--
    ///////////////////////////////////////
    Barra de Navegação
    ///////////////////////////////////////
-->
    <?
  //  pr($_POST);
	?>
    <div id="navegacao">
        <form class='form_busca' action="" method="get">
             <a></a>
            <input type="hidden" name="limitador" value="<?php echo $_GET['limitador']; ?>" />
            <input type="hidden" name="tela_id" value="<?php echo $_GET['tela_id']; ?>" />
            <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>" />
            <input type="text" value="<?php echo $_GET[busca]; ?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
        </form>
         <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"><span></span><?=$tela->nome?></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
      <button type="button" id="ensino" style="margin-top:3px;"><strong>Cadastrar o Ensino</strong></button>
      <!--<button type="button" id="serie">Série</button>-->
      <!--<a href="modulos/escolar2/cursos/form.php" target="carregador" class="mais"></a>-->	
      <button style="margin-top:1px; float:right; margin-right:20px;"><img src="../fontes/img/imprimir.png"></button>
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="180">Ciclos</td>
                <td width="130">Series</td>
                <td width="140">Materias</td>
                <td>&nbsp;</td>
            </tr>
        </thead>
    </table>
    
    
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
<div id="dados">
    
		<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
            <tbody>
         		<?php
                  $sql_ensino = mysql_query(" SELECT * FROM escolar2_ensino WHERE vkt_id = '$vkt_id' ORDER BY ordem_ensino ASC");
					while($ensino=mysql_fetch_object($sql_ensino)){
					
					$sql_serie = (mysql_query($p=" SELECT * FROM escolar2_series WHERE ensino_id = '$ensino->id' ORDER BY ordem_ensino ASC "));
						
				?>
            
                <tr ensino="<?=$ensino->id?>" >
                    <td width="180"><div style=" padding-right:15px; font-weight:bold; "><?=$ensino->nome;?></div></td>                  
                    <td width="130"></td>
                    <td width="140"></td>
                    <td></td>
                </tr>
                <?php while($serie=mysql_fetch_object($sql_serie)){ ?>
                
                <tr	serie="<?=$serie->id;?>">
                    <td width="180" align="right"></td>                  
                    <td width="130"><?=$serie->nome?></td>
                    <td width="140"></td>
                    <td></td>
                </tr>
                <?php
                	$sql_materia = mysql_query(" SELECT * FROM escolar2_serie_has_materias WHERE serie_id = '$serie->id'"); 
					
					while($seria_materia=mysql_fetch_object($sql_materia)){
						$materia = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_materias WHERE id = '$seria_materia->materia_id' "));
				?>
                 <tr serie="<?=$serie->id;?>">
                    <td width="180" align="right"></td>                  
                    <td width="130"></td>
                    <td width="140"><?=$materia->nome?></td>
                    <td></td>
                </tr>
                
                <?php
					
					    }// fim while materia 
					  } // fim while serie 
					} // fim de while ensino
				?> 
            </tbody>
        </table>
        
    </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
               <td width="260">&nbsp;</td>
               <td width="260">&nbsp;</td>
               <td >&nbsp;</td>
            </tr>
        </thead>
    </table>

</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">

	<?php echo $registros; ?> Registros 
    <?php
	
		if( $_GET[limitador] < 1 ){
			$limitador = 30;
		} else {
			$limitador = $_GET[limitador];
		}
		$qtd_selecionado[$limitador] = 'selected="selected"';
	
	?>
    
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?php echo $qtd_selecionado[15]; ?>>15</option>
        <option <?php echo $qtd_selecionado[30]; ?>>30</option>
        <option <?php echo $qtd_selecionado[50]; ?>>50</option>
        <option <?php echo $qtd_selecionado[100]; ?>>100</option>
    </select>
    Por P&aacute;gina 
  
    <div style="float:right; margin:0px 20px 0 0">
        <?php echo paginacao_links( $_GET[pagina], $registros, $_GET[limitador] ); ?>
    </div>
    
</div>