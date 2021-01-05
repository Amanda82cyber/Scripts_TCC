<?php session_start(); ?>
<!DOCTYPE html>

<html lang = "pt-BR">
    <head>
        <meta charset = "UTF-8" />
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0" />

        <meta property = "og:site_name" content = "ICSAR" />
        <meta property = "og:title" content = "Informações sobre Campanhas Solidárias em Araraquara" />
        <meta property = "og:type" content = "website" />

        <div id = "desc_comp_head">
            <meta property = "og:description" id = "desc_post" content = "Veja as campanhas solidárias, as doações e as arrecadações que estão ocorrendo neste momento em Araraquara!!!" />
            <meta property = "og:image" id = "img_post" itemprop = "image" content = "logo.png" />
        </div>

		<link rel = "stylesheet" href = "node_modules/bootstrap/bootstrap.css" />
        <link rel = "stylesheet" href = "node_modules/bootstrap/style.css" />
        <link rel = "stylesheet" type = "text/css" href = "estilo.css" />

        <script src = "node_modules/jquery/jquery.js"></script>
        <script src = "node_modules/popper/popper.js"></script>
        <script src = "node_modules/bootstrap/bootstrap.js"></script>

        <script defer src = "fontawesome/solid.js"></script>
        <script defer src = "fontawesome/fontawesome.js"></script>

        <script src = "https://unpkg.com/axios/dist/axios.min.js"></script>
    </head>

    <body>
        <nav class = "navbar navbar-expand-lg navbar-dark" style = "background-color: #3662d9; background-image: linear-gradient( to right, #204ac8, transparent, #6fffd9);">

            <a class = "navbar-brand" href = "index.php"><img src = "logo.png" width = "30" height = "30" class = "d-inline-block align-top" alt = "" /> ICSAR</a>

            <button class = "navbar-toggler" type = "button" data-toggle = "collapse" data-target = "#navbarNavAltMarkup" aria-controls = "navbarNavAltMarkup" aria-expanded = "false" aria-label = "Alterna navegação">
                <span class = "navbar-toggler-icon"></span>
            </button>

            <div class = "collapse navbar-collapse" id = "navbarNavAltMarkup">
                <div class = "container-fluid">
                    <div class = "navbar-nav">
                        <a class = "nav-item nav-link active" href = "index.php"><i class = "fa fa-home" aria-hidden = "true"></i> Home</a>
                        <a class = "nav-item nav-link" href = "lista_locais.php"><i class = "fa fa-map" aria-hidden = "true"></i> Mapa</a>

                        <?php 
                            if(isset($_SESSION["nome"])){
                        ?>
                        <li class = "nav-item dropdown">
                            <a class = "nav-link dropdown-toggle" href = "#" id = "doa_arr" role = "button" data-toggle = "dropdown" aria-haspopup = "true" aria-expanded = "false"><i class = "fa fa-handshake" aria-hidden = "true"></i> Arredações / Doações</a>

                            <div class = "dropdown-menu" aria-labelledby = "doa_arr">
                                <a class = "dropdown-item" href = "cadastrar_arredoar.php">Cadastrar</a>
                                <?php
                                    echo '<a class = "dropdown-item" href = "index.php?ident='. $_SESSION["identificador"][0] .'">Meus Cadastros</a>';
                                ?>
                            </div>
                        </li>
                        <?php 
                            };
                        ?>
                    </div>

                    <form class = "form-inline float-right">
                        <?php 
                            if(!(isset($_SESSION["nome"]))){
                        ?>
                                <a class = "btn btn-outline-primary my-2 my-sm-0 ml-1" href = "login.php"><i class = "fa fa-user" aria-hidden = "true"></i> Login</a>
                        <?php 
                            }else{
                                $nome = explode(" ", $_SESSION["nome"][0]);
                        ?>
                                <div class = "dropdown">
                                    <button class = "btn btn-outline-primary dropdown-toggle my-2 my-sm-0 ml-1" type = "button" id = "drop_usu" data-toggle = "dropdown" aria-haspopup = "true" aria-expanded = "false" data-flip = "true">
                                        <i class = "fa fa-user" aria-hidden = "true"></i> <?php echo $nome[0]?>
                                    </button>
                                    <div class = "dropdown-menu" aria-labelledby = "drop_usu" >
                                        <a class = "dropdown-item" href = "cadastrar_usuario.php"><i class = "fas fa-pencil-alt" aria-hidden = "true"></i> Editar Perfil</a>
                                        <a class = "dropdown-item" href = "logout.php"><i class = "fas fa-sign-out-alt" aria-hidden = "true"></i> Sair</a>
                                    </div>
                                </div>
                        <?php 
                            }
                        ?>
                    </form>
                </div>
            </div>

        </nav>