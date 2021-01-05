<?php
    include("conexao.php");

    $email = $_POST["email"];
    $identificador = $_POST["identificador"];
    $oqe = $_POST["oqe"];
    $data_envio = date('d/m/Y');
    $hora_envio = date('H:i:s');

    if($oqe == "Física"){
        $consulta = "SELECT * FROM usuario WHERE CPF = '$identificador' AND email = '$email'";
    }else{
        $consulta = "SELECT * FROM local WHERE CNPJ = $identificador AND email = '$email'";
    }

    $resultado = mysqli_query($conexao, $consulta) or die("Erro: " .mysqli_error($conexao));

    if(mysqli_num_rows($resultado) <= 0){
        echo ", Não existe um usuário com estes dados!";
    }else{
        while($linha = mysqli_fetch_assoc($resultado)){
            if($oqe = "Física"){
                $nome = $linha["nome"];
            }else{
                $nome = $linha["nome_fantasia"];
            }
        }

        $min = 00001;
        $max = 99999;
        $codigo = rand($min, $max);

        $estilo_email = '<html lang = "pt-BR">
                            <head>
                                <meta charset = "utf-8" />
                                <style type = "text/css">
                                    img{
                                        display: block;
                                        margin-left: auto;
                                        margin-right: auto;
                                        width: 50%;
                                        max-width: 100%;
                                        height: auto;
                                    }
                        
                                    table{
                                        border-color: #204ac8;
                                    }
                        
                                    body {
                                        margin: 0px;
                                        font-family: Verdane;
                                        font-size: 20px;
                                        color: #204ac8;
                                    }
                                </style>
                            </head>
                        
                            <body>
                                <table width = "100%" border = "1" cellpadding = "1" cellspacing = "1" bgcolor = "#CCE5FF">
                                    <tr>
                                        <td rowspan = "3" width = "35%">
                                            <img src = "http://www.icsar.tk/cadeado.png" alt = "Imagem de capa do card" />
                                        </td>
                    
                                        <th>Alteração de senha requisitada no dia <span style = "color: #3662d9"> '. $data_envio .' </span> às <span style = "color: #3662d9"> '. $hora_envio .' </span></th>
                                    </tr>
                    
                                    <tr>
                                        <th>Olá <span style = "color: #3662d9;"> '.$nome.' </span> ! Seu código está abaixo.</th>
                                    </tr>
                    
                                    <tr>
                                        <th style = "background-color: #3662d9; background-image: linear-gradient( to right, #204ac8, transparent, #6fffd9); font-size: 30px; color: #fff;"><h3>'.$codigo.'</h3></th>
                                    </tr>

                                    <tr>
                                        <th colspan = "2" style = "text-align: center;">Sempre estamos ao seu dispor! Qualquer dúvida, entre em contato conosco pelo e-mail: equipeicsar@gmail.com</th>
                                    </tr>
                                </table>
                            </body>
                        </html>';

        $meu_email = "equipeicsar@gmail.com";
        $assunto = "Código para alterar a senha";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: Equipe ICSAR <$meu_email>";

        $enviar_email = mail($email, $assunto, $estilo_email, $headers);
        if($enviar_email){
            echo "1, " . $codigo;
        }else{
            echo ", Erro ao enviar e-mail!";
        }
    }
?>