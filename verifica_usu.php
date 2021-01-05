<?php 
    session_start();
    include("conexao.php");

    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    $consulta = "SELECT * FROM usuario WHERE email = '$usuario'";
    $resultado = mysqli_query($conexao, $consulta);

    $consulta1 = "SELECT * FROM local WHERE email = '$usuario'";
    $resultado1 = mysqli_query($conexao, $consulta1);

    if(mysqli_num_rows($resultado) > 0){
        $consulta .= " AND senha = '$senha'";
        $r2 = mysqli_query($conexao, $consulta);
        
        if(mysqli_num_rows($r2) > 0){
            echo "1";
            while($linha = mysqli_fetch_assoc($r2)){
                $_SESSION["nome"][] = $linha["nome"];
                $_SESSION["acesso"][] = "usuario";
                $_SESSION["identificador"][] = $linha["CPF"];
            }
        }else{
            echo "Senha Incorreta!";
        }
    }elseif(mysqli_num_rows($resultado1) > 0){
        $consulta1 .= " AND senha = '$senha'";
        $r3 = mysqli_query($conexao, $consulta1);
        
        if(mysqli_num_rows($r3) > 0){
            echo "1";
            while($linha = mysqli_fetch_assoc($r3)){
                $_SESSION["nome"][] = $linha["razao_social"];
                $_SESSION["acesso"][] = "loja";
                $_SESSION["identificador"][] = $linha["CNPJ"];
            }
        }else{
            echo "Senha Incorreta!";
        }
    }else{
        echo "Usuário e senha incorretos!";
    }
?>