<?php
    include("conexao.php");
    session_start();

    $arre_doar = strtoupper($_POST["arredoar"]);
    $desc = strtoupper($_POST["desc"]);
    $tipo = strtoupper($_POST["tipo"]);

    if(isset($_POST["q_tipo"])){
        $q_tipo = strtoupper($_POST["q_tipo"]);
    }

    $campanha = strtoupper($_POST["campanha"]);
    $quant = $_POST["quant"];
    $data_inicio = $_POST["data_inicio"];
    $data_fim = $_POST["data_fim"];
    $usuario = $_SESSION["identificador"][0];

    $foto = $_FILES['foto']; // esta variável contém a imagem
	
	if (!empty($foto["name"])) {
 
		$error = array();
 
    	// Verifica se o arquivo é uma imagem
    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
     	   $error[1] = "Isso não é uma imagem.";
   	 	} 
 
		// Se não houver nenhum erro
		if (count($error) == 0) {
		
			// Pega extensão da imagem
			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
 
        	// Gera um nome único para a imagem
        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
 
        	// Caminho de onde ficará a imagem
        	$caminho_imagem = "fotos/" . $nome_imagem;
 
			// Faz o upload da imagem para seu respectivo caminho
			move_uploaded_file($foto["tmp_name"], $caminho_imagem);
	
			// $alterar_foto = ", foto='$nome_imagem'";
		}
	}
	// else{
	// 	$alterar_foto = "";
	// }

    if($tipo == "OUTRO"){
        $tipo = $q_tipo;
    }

    if($_SESSION["acesso"] == "loja"){
        $inserir = "INSERT INTO doacoes(descricao, quantidade, tipo, data_inicio, data_fim, arre_doar, id_campanha, cnpj_local, foto_doacao) VALUES('$desc', '$quant', '$tipo', '$data_inicio', '$data_fim', '$arre_doar', '$campanha', '$usuario', '$nome_imagem')";
    }else{
        $inserir = "INSERT INTO doacoes(descricao, quantidade, tipo, data_inicio, data_fim, arre_doar, id_campanha, CPF_usuario, foto_doacao) VALUES('$desc', '$quant', '$tipo', '$data_inicio', '$data_fim', '$arre_doar', '$campanha', '$usuario', '$nome_imagem')";
    }

    mysqli_query($conexao, $inserir) or die(mysqli_error($conexao));

    echo "1";
?>