<?php
    header("Content-Type: Application/json");

    include("conexao.php");
    
    $id = $_POST["id"];

    $consulta = "SELECT cnpj_local, CPF_usuario FROM doacoes WHERE id_doacoes = $id";

    $resultado = mysqli_query($conexao, $consulta) or die("Erro: " .mysqli_error($conexao));

    while($linha = mysqli_fetch_assoc($resultado)){
        if($linha["cnpj_local"] == NULL){
            $consulta1 = "SELECT d.descricao as 'desc_doa',
                                 d.quantidade as 'qtd_doa',
                                 d.tipo as 'tipo_doa',
                                 d.data_inicio as 'ini_doa',
                                 d.data_fim as 'fim_doa', 
                                 d.arre_doar as 'oqe_doa',
                                 d.foto_doacao as 'foto_doa',
                                 c.descricao as 'desc_camp',
                                 c.data_inicio as 'ini_camp',
                                 c.data_fim as 'fim_camp',
                                 u.nome as 'nome_usu',
                                 u.celular as 'cel_usu',
                                 u.telefone as 'tel_usu',
                                 u.email as 'email_usu',
                                 u.CEP as 'cep_usu',
                                 u.bairro as 'bairro_usu',
                                 u.estado as 'estado_usu',
                                 u.cidade as 'cid_usu',
                                 u.logradouro as 'log_usu',
                                 u.numero as 'num_usu'
                          FROM doacoes d
                          INNER JOIN campanha c
                          ON d.id_campanha = c.id_campanha
                          INNER JOIN usuario u
                          ON d.CPF_usuario = u.CPF
                          WHERE id_doacoes = $id";
        }else{
            $consulta1 = "SELECT d.descricao as 'desc_doa',
                                 d.quantidade as 'qtd_doa',
                                 d.tipo as 'tipo_doa',
                                 d.data_inicio as 'ini_doa',
                                 d.data_fim as 'fim_doa', 
                                 d.arre_doar as 'oqe_doa',
                                 d.foto_doacao as 'foto_doa',
                                 c.descricao as 'desc_camp',
                                 c.data_inicio as 'ini_camp',
                                 c.data_fim as 'fim_camp',
                                 l.razao_social as 'razao_loc',
                                 l.nome_fantasia as 'nome_loc',
                                 l.telefone as 'tel_loc',
                                 l.email as 'email_loc',
                                 l.nome_representante as 'repre_loc',
                                 l.CEP as 'cep_loc',
                                 l.bairro as 'bairro_loc',
                                 l.estado as 'estado_loc',
                                 l.cidade as 'cid_loc',
                                 l.logradouro as 'log_loc',
                                 l.numero as 'num_loc'
                          FROM doacoes d
                          INNER JOIN campanha c
                          ON d.id_campanha = c.id_campanha
                          INNER JOIN local l
                          ON d.cnpj_local = l.CNPJ
                          WHERE id_doacoes = $id";
        }
    }

    $resultado1 = mysqli_query($conexao, $consulta1) or die("Erro: " .mysqli_error($conexao));

    while($linha = mysqli_fetch_assoc($resultado1)){
        $matriz["mais_arredoar"][] = $linha;
    }

    echo json_encode($matriz);
    // echo "1";
?>