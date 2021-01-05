<?php
    header("Content-Type: Application/json");

    include("conexao.php");

    $data = date("Y-m-d");

    $consulta = "SELECT d.descricao as 'desc_doa',
                        d.quantidade as 'qtd_doa',
                        d.tipo as 'tipo_doa',
                        d.data_inicio as 'ini_doa',
                        d.data_fim as 'fim_doa', 
                        d.arre_doar as 'oqe_doa',
                        c.descricao as 'desc_camp',
                        c.data_inicio as 'ini_camp',
                        c.data_fim as 'fim_camp',
                        u.nome as 'nome',
                        u.celular as 'cel',
                        u.telefone as 'tel',
                        u.email as 'email',
                        u.CEP as 'cep',
                        u.bairro as 'bairro',
                        u.estado as 'estado',
                        u.cidade as 'cid',
                        u.logradouro as 'log',
                        d.id_doacoes as 'id_doacao',
                        u.numero as 'num'
                 FROM doacoes d
                 INNER JOIN campanha c
                 ON d.id_campanha = c.id_campanha
                 INNER JOIN usuario u
                 ON d.CPF_usuario = u.CPF
                 WHERE d.data_fim >= '$data'
                 UNION 
                 SELECT d.descricao as 'desc_doa',
                        d.quantidade as 'qtd_doa',
                        d.tipo as 'tipo_doa',
                        d.data_inicio as 'ini_doa',
                        d.data_fim as 'fim_doa', 
                        d.arre_doar as 'oqe_doa',
                        c.descricao as 'desc_camp',
                        c.data_inicio as 'ini_camp',
                        c.data_fim as 'fim_camp',
                        l.nome_fantasia as 'nome',
                        l.nome_representante as 'cel',
                        l.telefone as 'tel',
                        l.email as 'email',
                        l.CEP as 'cep',
                        l.bairro as 'bairro',
                        l.estado as 'estado',
                        l.cidade as 'cid',
                        l.logradouro as 'log',
                        d.id_doacoes as 'id_doacao',
                        l.numero as 'num'
                 FROM doacoes d
                 INNER JOIN campanha c
                 ON d.id_campanha = c.id_campanha
                 INNER JOIN local l
                 ON d.cnpj_local = l.CNPJ
                 WHERE d.data_fim >= '$data'";

    $resultado = mysqli_query($conexao, $consulta) or die("Erro: " .mysqli_error($conexao));

    while($linha = mysqli_fetch_assoc($resultado)){
        $matriz["google_arredoar"][] = $linha;
    }

    echo json_encode($matriz);
?>