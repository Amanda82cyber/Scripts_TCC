<?php
    session_start();
    include("conexao.php");

    $cep = $_POST["cep"];
    $bairro = strtoupper($_POST["bairro"]);
    $cid = strtoupper($_POST["cid"]);
    $estado = strtoupper($_POST["estado"]);
    $log = strtoupper($_POST["log"]);
    $num = $_POST["num"];
    $tel = $_POST["tel"];
    $senha = $_POST["senha"];
    $email = strtoupper($_POST["email"]);

    
    if($_POST["oqe"] == "Jurídica"){
        $cnpj = $_POST["cnpj"];
        $nome_fant = strtoupper($_POST["nome_fant"]);
        $razao_social = strtoupper($_POST["razao_social"]);
        $nome_repre = strtoupper($_POST["nome_repre"]);
        $cpf_repre = $_POST["cpf_repre"];

        if(!(isset($_SESSION["acesso"]))){
            $consulta = "SELECT * FROM local WHERE CNPJ = $cnpj";
            $resultado = mysqli_query($conexao, $consulta) or die ("0" . mysqli_error($conexao));

            if(mysqli_num_rows($resultado) > 0){
                echo "Você já está cadastrado!";
            }else{
                $comando = "INSERT INTO local(CNPJ, nome_fantasia, razao_social, nome_representante, cpf_representante, email, CEP, bairro, cidade, estado, logradouro, numero, telefone, senha) VALUES('$cnpj', '$nome_fant', '$razao_social', '$nome_repre', '$cpf_repre', '$email', '$cep', '$bairro', '$cid', '$estado', '$log', '$num', '$tel', '$senha')";

                mysqli_query($conexao, $comando) or die ("0" . mysqli_error($conexao));

                echo "1";
            }
        }else{
            $alterar = "UPDATE local SET
                            CNPJ = $cnpj,
                            nome_fantasia = '$nome_fant',
                            razao_social = '$razao_social',
                            nome_representante = '$nome_repre',
                            cpf_representante = '$cpf_repre',
                            email = '$email',
                            CEP = $cep,
                            bairro = '$bairro',
                            cidade = '$cid',
                            estado = '$estado',
                            logradouro = '$log',
                            numero = $num,
                            telefone = '$tel',
                            senha = '$senha'
                        WHERE CNPJ = " . $_SESSION['identificador'][0] . "";

            mysqli_query($conexao, $alterar) or die ("0" . mysqli_error($conexao));

            echo "2";
        }
    }else{
        $cpf = $_POST["cpf"];
        $nome = strtoupper($_POST["nome"]);
        $cel = $_POST["cel"];

        if(!(isset($_SESSION["acesso"]))){
            $consulta1 = "SELECT * FROM usuario WHERE CPF = '$cpf'";
            $resultado1 = mysqli_query($conexao, $consulta1) or die ("0" . mysqli_error($conexao));

            if(mysqli_num_rows($resultado1) > 0){
                echo "Você já está cadastrado!";
            }else{
                $comando1 = "INSERT INTO usuario(CPF, nome, celular, CEP, bairro, cidade, estado, logradouro, numero, telefone, senha, email) VALUES('$cpf', '$nome', '$cel', '$cep', '$bairro', '$cid', '$estado', '$log', '$num', '$tel', '$senha', '$email')";

                mysqli_query($conexao, $comando1) or die ("0" . mysqli_error($conexao));

                echo "1";
            }
        }else{
            $alterar1 = "UPDATE usuario SET
                            CPF = '$cpf',
                            nome = '$nome',
                            celular = '$cel',
                            email = '$email',
                            CEP = $cep,
                            bairro = '$bairro',
                            cidade = '$cid',
                            estado = '$estado',
                            logradouro = '$log',
                            numero = $num,
                            telefone = '$tel',
                            senha = '$senha'
                        WHERE CPF = '" . $_SESSION['identificador'][0] . "'";

            mysqli_query($conexao, $alterar1) or die ("0" . mysqli_error($conexao));

            echo "2";
        }
    }
?>