<?
//Funções 

function tamanhoArquivo($arquivo1,$arquivo2){
        
      $tamanho = $arquivo1+$arquivo2;
      
       /*$kb = 1024;
       $mb = 1048576;
       $gb = 1073741824;
      $tb = 1099511627776;*/
 		alert($tamanho);
		$max_permitido = 838860800;
		
		if(!$max_permitido>$tamanho){
			return 1;
		}else{ 
			return 0;
		}
       
	   /*if($tamanho<$kb){
     
         return $tamanho;
   
       }else if($tamanho>=$kb&&$tamanho<$mb){
  
         $kilo = number_format($tamanho/$kb,2);
     
         return $kilo;
   
       }else if($tamanho>=$mb&&$tamanho<$gb){
      
        $mega = number_format($tamanho/$mb,2);
   
         return $mega;
   
       }else if($tamanho>=$gb&&$tamanho<$tb){
       
        $giga = number_format($tamanho/$gb,2);
      
        return $giga;
      }*/
 
  } 

//Cliente Fornecedor
function cadastraItemMenu($modulo_id,$nome_item,$tela,$caminho,$acao_menu,$ordem_menu,$menu_escondido){
			
			$cadastra = mysql_query($t="INSERT INTO sis_modulos 
						SET 
						modulo_id  = '$modulo_id',
						nome       = '$nome_item',
						ordem_menu = '$ordem_menu',
						tela       = '$tela',
						caminho    = '$caminho',
						acao_menu = '$acao_menu',
						menu_escondido ='$menu_escondido'
						");
				return 1;
				//echo $t;
}

function alteraItemMenu($id,$modulo_id,$nome_item,$tela,$caminho,$acao_menu,$ordem_menu,$menu_escondido){
			$altera = mysql_query($t=" UPDATE sis_modulos 
									SET 
									modulo_id = '$modulo_id',
									nome = '$nome_item',
									ordem_menu = '$ordem_menu',
									tela = '$tela',
									caminho = '$caminho',
									acao_menu = '$acao_menu',
						menu_escondido ='$menu_escondido'

									WHERE id = '$id' ");
			
			
			
			return 1;
	
}

function alteraItensTutorial($dados,$sys_modulo_id){
	$tutoriais = mysql_query("SELECT * FROM sis_modulos_tutorial WHERE sis_modulo_id=$sys_modulo_id");
	
	$tutorial_id = $dados['tutorial_id'];
		
	while($tutorial=mysql_fetch_object($tutoriais)){
		
		if(!in_array($tutorial->id,$tutorial_id)){
			mysql_query($y="DELETE FROM sis_modulos_tutorial WHERE id='$tutorial->id'");
				//echo $y;
			@unlink("modulos/vekttor/item_menu/tutorial/".$tutorial->id.$tutorial->extensao1);
			@unlink("modulos/vekttor/item_menu/tutorial/".$tutorial->id.$tutorial->extensao2);
		}
		
		
		
	}

}

function excluiItem($id){
		
		$filhos = mysql_result(mysql_query("SELECT COUNT(*) FROM sis_modulos WHERE modulo_id='$id'"),0,0)*1;
		if($filhos==0){
		mysql_query($trace="
					DELETE FROM sis_modulos
					WHERE id ='".$id."'
					");
		}
		$tutoriais = mysql_query($trace="
					SELECT * FROM sis_modulos_tutorial
					WHERE id ='".$id."'
					");
		while($t=mysql_fetch_object($tutoriais)){
			
			unlink("modulos/vekttor/item_menu/tutorial/".$t->id.$t->extensao1);	
			unlink("modulos/vekttor/item_menu/tutorial/".$t->id.$t->extensao2);	
			
			mysql_query("DELETE FROM sis_modulos_tutorial
					WHERE id ='".$t->id."'
					");
					
		}
		return 1;
	

}

function ManipulaTutorial($dados,$vkt_id){
	
	global $vkt_id;
	
	if(!$dados['id']>0){
		$inicio = "INSERT INTO";
		$fim    = "";
	}else{
		$inicio = "UPDATE";
		$fim    = "WHERE id={$dados['id']}";
	}
	
	mysql_query($t="$inicio
					sis_modulos_tutorial 
				SET 
					vkt_id='$vkt_id',
					sis_modulo_id ='{$dados['modulo_id']}',
					sequencia     ='{$dados['ordem']}',
					titulo        ='{$dados['titulo']}',
					texto         ='{$dados['texto']}'					
				$fim");
	//echo $t;
	if(!$dados['id']>0){
		$arquivo_id = mysql_insert_id();		
	}else{
		$arquivo_id = $dados['id'];
	}
	
	if(strlen($_FILES['arquivo1']['name'])>3){
		
		upload_arquivo($arquivo_id,1,"extensao1");
	}
	
	if(strlen($_FILES['arquivo2']['name'])>3){
		
		upload_arquivo($arquivo_id,2,"extensao2");
	}
		echo "<script>window.open('modulos/vekttor/item_menu/form.php?id={$dados['modulo_id']}','carregador')</script>";
}

function upload_arquivo($arquivo_id,$ordem_arquivo,$campo){
	
	$filis_autorizados = array('jpg','gif','png','pdf','wav','mp3','avi','wmv','ogg','flv');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT * FROM  sis_modulos_tutorial WHERE id='$arquivo_id'"));
	
	if(strlen($_FILES['arquivo1']['name'])>4){
	  $pasta 	= 'modulos/vekttor/item_menu/tutorial/';
	  $extensao = strtolower(substr($_FILES['arquivo1']['name'],-3));
	  $arquivo 	= $pasta.$arquivo_id."_".$ordem_arquivo.'.'.$extensao;
	  $arquivodel= $pasta.$arquivo_id.'.';
	}else if(strlen($_FILES['arquivo2']['name'])>4){
	  $pasta 	= 'modulos/vekttor/item_menu/tutorial/';
	  $extensao = strtolower(substr($_FILES['arquivo2']['name'],-3));
	  $arquivo 	= $pasta.$arquivo_id."_".$ordem_arquivo.'.'.$extensao;
	  $arquivodel= $pasta.$arquivo_id.'.';
	}
	 if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['arquivo1'][tmp_name],$arquivo)||move_uploaded_file($_FILES['arquivo2'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE sis_modulos_tutorial SET $campo='_$ordem_arquivo.$extensao' WHERE id='$arquivo_id'");
			  //echo $f;
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	 
	
	
}
?>