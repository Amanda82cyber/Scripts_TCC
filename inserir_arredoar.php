<?php
    include("conexao.php");
    session_start();

    $arre_doar = strtoupper($_POST["arredoar"]);
    $desc = strtoupper($_POST["desc"]);
    $tipo = strtoupper($_POST["tipo"]);
    $id = $_POST["id"];

    if(isset($_POST["q_tipo"])){
        $q_tipo = strtoupper($_POST["q_tipo"]);
    }

    $campanha = strtoupper($_POST["campanha"]);
    $quant = $_POST["quant"];
    $data_inicio = $_POST["data_inicio"];
    $data_fim = $_POST["data_fim"];
    $usuario = $_SESSION["identificador"][0];

    if(isset($_FILES['foto'])){
        $foto = $_FILES['foto']; // esta variável contém a imagem
    }
    
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
	
			$alterar_foto = ", foto='$nome_imagem'";
		}
	}else{
        $nome_imagem = "";
        $alterar_foto = "";
    }

    if($tipo == "OUTRO"){
        $tipo = $q_tipo;
    }

    if($_SESSION["acesso"] == "loja"){
        $var_usu = "cnpj_local";
    }else{
        $var_usu = "CPF_usuario";
    }

    if($id == 0){
        $consulta = "INSERT INTO doacoes(descricao, quantidade, tipo, data_inicio, data_fim, arre_doar, id_campanha, $var_usu, foto_doacao) VALUES('$desc', '$quant', '$tipo', '$data_inicio', '$data_fim', '$arre_doar', '$campanha', '$usuario', '$nome_imagem')";
    }else{
        $consulta = "UPDATE doacoes SET
                        descricao = '$desc',
                        quantidade = '$quant',
                        tipo = '$tipo',
                        data_inicio = '$data_inicio',
                        data_fim = '$data_fim',
                        arre_doar = '$arre_doar',
                        id_campanha = '$campanha',
                        $var_usu = '$usuario'
                        $alterar_foto
                    WHERE id_doacoes = $id";
    }

    mysqli_query($conexao, $consulta) or die(mysqli_error($conexao));

    echo "1";
?>