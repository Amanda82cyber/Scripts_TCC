<?php 
    include("menu.php"); 
    if(isset($_GET["ident"])){
        $ident = $_GET["ident"];
        echo "<script>var usu = 1; var ident = '$ident'; $(document).ready(function(){listar_arredoar('$ident', 0)})</script>";
    }else{
        if(isset($_GET["ver_mais"])){
            $id = $_GET["ver_mais"];
            echo "<script>var usu = 2; var ident = ''; $(document).ready(function(){listar_arredoar('', 0); modal_ver_mais('$id')})</script>";
        }else{
            echo "<script>var usu = 2; var ident = ''; $(document).ready(function(){listar_arredoar('', 0)})</script>";
        }
    }

    
?>
        <!-- Parâmetro sensor é utilizado somente em dispositivos com GPS -->
        <script src = "https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyAD4ZWbiJdpCv5_5Fv8FHV8c6YCF_JNca8"></script>
        
        <script>
            var filtro1 = "";
            var filtro2 = "";
            var filtro3 = "";
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;

            $(document).ready(function(){
                $('[data-toggle = "tooltip"]').tooltip();

                $("a[name = 'btn_pagina']").click(function(){
                    p = $(this).html();
                    p = (p-1)*10;
                    listar_arredoar(ident, p);
                });

                $("#filtro_tipo").val("");
                $("#filtro_val").val("");
                $("#filtro_esp").val("");
            });   
            
            function filtrar(){
                $.ajax({
                    url: "paginacao_arredoar.php",
                    type: "post",
                    data: {filtro1: $("select[id = 'filtro_tipo']").val(), filtro2: $("select[id = 'filtro_val']").val(), filtro3: $("#filtro_esp").val()},
                    success: function(d){
                        $("#paginacao").html(d);
                        filtro1 = $("select[id = 'filtro_tipo']").val();
                        filtro2 = $("select[id = 'filtro_val']").val();
                        filtro3 = $("#filtro_esp").val();
                        listar_arredoar(ident, 0);
                    }
                });
            }

            function calcula_distancia(destino){
                if($("#pesq").val() == ""){
                    $("#msn_google").html("Os dois campos devem estar preenchidos para ser feita a pesquisa!").css("color", "red");
                }else{
                    // if($("#mode").val() == "DRIVING"){
                    //     modo_viagem =  google.maps.TravelMode.DRIVING;
                    // }else if($("#mode").val() == "WALKING"){
                    //     modo_viagem = google.maps.TravelMode.WALKING;
                    // }else{
                    //     modo_viagem = google.maps.TravelMode.BICYCLING;
                    // }

                    // alert(modo_viagem);
                   
                    var service = new google.maps.DistanceMatrixService();
                    // Executa o DistanceMatrixService.
                    
                    service.getDistanceMatrix({
                        origins: [$("#pesq").val()], // Origem
                        destinations: [destino], // Destino
                        travelMode: google.maps.TravelMode.DRIVING, // Modo (DRIVING | WALKING | BICYCLING)
                        unitSystem: google.maps.UnitSystem.METRIC // Sistema de medida (METRIC | IMPERIAL)
                    }, callback); // Vai chamar o callback
                }
            }    

            // Tratar o retorno do DistanceMatrixService
            function callback(response, status) {
                // Verificar o status.
                if (status == google.maps.DistanceMatrixStatus.OK) { // Se o status for "OK".
                    //Atualizar o mapa.
                    $("#map").attr("src", "https://maps.google.com/maps?saddr=" + response.originAddresses + "&daddr=" + response.destinationAddresses + "&output=embed&key=AIzaSyAD4ZWbiJdpCv5_5Fv8FHV8c6YCF_JNca8");
                }else{
                    $("#msn_google").html(status).css("color", "red");
                }
            }

            function listar_arredoar(ident, p){
                $("#arredoar").html("");
                $.ajax({
                    url: "listar_arredoar.php",
                    type: "post",
                    data: {ident, p, filtro1, filtro2, filtro3},
                    success: function(matriz){
                        for(i=0; i<matriz["arredoar"].length; i++){
                            if(matriz["arredoar"][i].oqe == "DOAÇÃO"){
                                if(matriz["arredoar"][i].fim_doa <= today){
                                    cor = "danger";
                                    list = '<div class = "card cards_invalidos pb-2">';
                                }else{
                                    cor = "primary";
                                    list = '<div class = "card cards_doacao pb-2">';
                                }

                                if(matriz["arredoar"][i].foto){
                                    list += '<img class = "card-img-top" src = "fotos/' + matriz["arredoar"][i].foto + '" />';
                                }else{
                                    list += '<img class = "card-img-top" src = "fotos_definidas/' + fotos_definidas(matriz["arredoar"][i].tipo_doa) + '" />';
                                }
                            }else{
                                if(matriz["arredoar"][i].fim_doa <= today){
                                    cor = "danger";
                                    list = '<div class = "card cards_invalidos pb-2">';
                                }else{
                                    cor = "success";
                                    list = '<div class = "card cards_arrecadacao pb-2">';
                                }                                    

                                list += '<img class = "card-img-top" src = "fotos_definidas/' + fotos_definidas(matriz["arredoar"][i].tipo_doa) + '" />';
                            }
                            
                            list += '<div class = "card-body">';
                            list += '<h5 class = "card-title text-left text-' + cor + '">' + matriz["arredoar"][i].oqe + '</h5>';
                            list += '<p class = "card-text">';
                            list += '<p><span class = "text-' + cor + '">Descrição:</span> ' + matriz["arredoar"][i].desc_doa + '</p>';
                            list += '<p><span class = "text-' + cor + '">Tipo:</span> ' + matriz["arredoar"][i].tipo_doa + '</p>';
                            list += '<p><span class = "text-' + cor + '">Quantidade:</span> ' + matriz["arredoar"][i].qtd_doa + ' UNIDADES</p>';
                            list += '<p><span class = "text-' + cor + '">Data de Inicio:</span> ' + matriz["arredoar"][i].ini_doa + '</p>';
                            list += '<p><span class = "text-' + cor + '">Data de Término:</span> ' + matriz["arredoar"][i].fim_doa + '</p>';
                            list += '</p>';
                            if(usu == 1){
                                list += '<a class = "btn btn-outline-' + cor + ' float-left mr-2" data-toggle = "tooltip" data-placement = "bottom" title = "Editar" href = "cadastrar_arredoar.php?id=' + matriz["arredoar"][i].id_doacoes + '"><i class = "fa fa-wrench" aria-hidden = "true"></i></a>';
                                list += '<a class = "btn btn-outline-' + cor + ' float-left mr-2" data-toggle = "tooltip" data-placement = "bottom" title = "Apagar" onclick = "apagar(' + matriz["arredoar"][i].id_doacoes + ')"><i class = "fa fa-trash" aria-hidden = "true"></i></a>';
                            }

                            list += '<div class = "dropdown">';
                            list += '<button class = "btn btn-outline-' + cor + ' float-left mr-2 dropdown-toggle" type = "button" id = "menu_compartilhar" data-toggle = "dropdown" aria-haspopup = "true" aria-expanded = "false">';
                            list += '<i class = "fa fa-share-alt" aria-hidden = "true"></i> Compartilhar</button>';

                            if(cor == "primary"){
                                list += '<div class = "dropdown-menu cards_doacao" aria-labelledby = "menu_compartilhar">';
                            }else if(cor == "success"){
                                list += '<div class = "dropdown-menu cards_arrecadacao" aria-labelledby = "menu_compartilhar">';
                            }else{
                                list += '<div class = "dropdown-menu cards_invalidos" aria-labelledby = "menu_compartilhar">';
                            }
                            
                            list += `<a class = "dropdown-item" name = "fb_share" type = "box_count" id = "face" href = "https://www.facebook.com/sharer/sharer.php?u=http://www.icsar.tk/index.php?ver_mais=${matriz["arredoar"][i].id_doacoes}"><img src = "facebook.png" width = "20px" height = "20px" /> Facebook</a>`;

                            list += `<a class = "dropdown-item" id = "whats" href = "https://api.whatsapp.com/send?text=http://www.icsar.tk/index.php?ver_mais=${matriz["arredoar"][i].id_doacoes}"><img src = "whatsapp.png" width = "20px" height = "20px" /> Whatsapp</a>`;

                            list += `<a class = "dropdown-item" id = "twitter" href = "https://twitter.com/intent/tweet?url=http://www.icsar.tk/index.php?ver_mais=${matriz["arredoar"][i].id_doacoes}"><img src = "twitter.png" width = "20px" height = "20px" />  Twitter</a>`;

                            list += '</div></div>';
                            list += '<a class = "btn btn-' + cor + ' float-left text-light" onclick = "modal_ver_mais(' + matriz["arredoar"][i].id_doacoes + ', ' + "'" + cor + "'" + ')">Ver mais</a>';                            
                            list += '</div></div>';

                            $("#arredoar").append(list);
                        }
                    }
                });
            }

            function fotos_definidas(tipo){
                if(tipo == "VESTIMENTAS"){
                    nome_foto = 'vestimentas.jpg';
                }else if(tipo == "SAPATOS"){
                    nome_foto = 'sapatos.jpg';
                }else if(tipo == "ALIMENTÍCIA"){
                    nome_foto = 'alimenticia.jpg';
                }else if(tipo == "BRINQUEDOS"){
                    nome_foto = 'brinquedos.jpg';
                }else if(tipo == "MONETÁRIA"){
                    nome_foto = 'monetaria.jpeg';
                }else if(tipo == "LIVROS"){
                    nome_foto = 'livros.jpg';
                }else{
                    nome_foto = 'outro.jpg';
                }

                return nome_foto;
            }

            function apagar(id){
                $.ajax({
                    url: "apagar_arredoar.php",
                    type: "post",
                    data: {id},
                    success: function(data){
                        if(data == 1){
                            listar_arredoar(ident, 0);
                        }else{
                            alert(data);
                        }
                    }
                });
            }

            function modal_ver_mais(id, cor){
                $("#modal_ver_mais").html("");
                $.ajax({
                    url: "listar_mais_arredoar.php",
                    type: "post",
                    data: {id},
                    success: function(matriz){
                        for(i=0; i<matriz["mais_arredoar"].length; i++){
                            list = '<div class = "modal fade" id = "ver_mais" tabindex = "-1" role = "dialog" aria-labelledby = "ModalLabel" aria-hidden = "true">';
                            list += '<div class = "modal-dialog modal-lg">';

                            if(matriz["mais_arredoar"][i].oqe_doa == "DOAÇÃO"){
                                list += '<div class = "modal-content cards_doacao">';
                            }else if(matriz["mais_arredoar"][i].oqe_doa == "ARRECADAÇÃO"){
                                list += '<div class = "modal-content cards_arrecadacao">';
                            }else{
                                list += '<div class = "modal-content cards_invalidos">';
                            }

                            list += '<div class = "modal-header border-' + cor + '">';
                            list += '<h4 class = "modal-title text-' + cor + '" id = "ModalLabel">' + matriz["mais_arredoar"][i].oqe_doa + ' (' + matriz["mais_arredoar"][i].ini_doa + ' à ' + matriz["mais_arredoar"][i].fim_doa + ')</h4>';
                            list += '<button type = "button" class = "close" data-dismiss = "modal" aria-label = "Fechar">';
                            list += '<span aria-hidden = "true" class = "text-' + cor + '">&times;</span>';
                            list += '</button></div>';
                            list += '<div class = "modal-body">';
                            list += '<ul class = "list-group list-group-flush">';

                            if(matriz["mais_arredoar"][i].oqe_doa == "DOAÇÃO"){
                                if(matriz["mais_arredoar"][i].foto_doa){
                                    list += '<li class = "list-group-item bg-transparent border-' + cor + '"><img width = "50%" height = "auto" src = "fotos/' + matriz["mais_arredoar"][i].foto_doa + '" /></li>';
                                }else{
                                    list += '<li class = "list-group-item bg-transparent border-' + cor + '"><img width = "50%" height = "auto" src = "fotos_definidas/' + fotos_definidas(matriz["mais_arredoar"][i].tipo_doa) + '" /></li>';
                                }
                            }else{
                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><img width = "50%" height = "auto" src = "fotos_definidas/' + fotos_definidas(matriz["mais_arredoar"][i].tipo_doa) + '" /></li>';
                            }

                            list += '<li class = "list-group-item bg-transparent border-' + cor + '"><h5 class = "text-' + cor + '">Informações Básicas</h5>';
                            list += '<ul class = "list-group list-group-flush">';

                            list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Descrição:</span> ' + matriz["mais_arredoar"][i].desc_doa + '</li>';

                            list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Tipo:</span> ' + matriz["mais_arredoar"][i].tipo_doa + '</li>';

                            list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Quantidade:</span> ' + matriz["mais_arredoar"][i].qtd_doa + ' UNIDADES</li>';

                            list += '<li class = "list-group-item bg-transparent border-light"><span class = "text-' + cor + '">Campanha:</span> ' + matriz["mais_arredoar"][i].desc_camp + ' (' + matriz["mais_arredoar"][i].ini_camp + ' à ' + matriz["mais_arredoar"][i].fim_camp + ')</li>';

                            list += '</ul></li>';

                            list += '<ul class = "list-group list-group-flush">';
                            list += '<li class = "list-group-item bg-transparent border-' + cor + '"><h5 class = "text-' + cor + '">Contato com o Doador/Arrecadador</h5>';

                            list += '<ul class = "list-group list-group-flush">';

                            if(matriz["mais_arredoar"][i].cel_usu){
                                var destino = matriz["mais_arredoar"][i].log_usu + ", " + matriz["mais_arredoar"][i].num_usu + " - " + matriz["mais_arredoar"][i].cid_usu + "/" + matriz["mais_arredoar"][i].estado_usu;

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Nome:</span> ' + matriz["mais_arredoar"][i].nome_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Celular:</span> ' + matriz["mais_arredoar"][i].cel_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Telefone:</span> ' + matriz["mais_arredoar"][i].tel_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">E-mail:</span> ' + matriz["mais_arredoar"][i].email_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Endereço:</span> ' + matriz["mais_arredoar"][i].log_usu + ', ' + matriz["mais_arredoar"][i].num_usu + ' - ' + matriz["mais_arredoar"][i].bairro_usu + ' (' + matriz["mais_arredoar"][i].cid_usu + '/' + matriz["mais_arredoar"][i].estado_usu + ') - ' + matriz["mais_arredoar"][i].cep_usu + '</li>';
                            }else{
                                var destino = matriz["mais_arredoar"][i].log_loc + ", " + matriz["mais_arredoar"][i].num_loc + " - " + matriz["mais_arredoar"][i].cid_loc + "/" + matriz["mais_arredoar"][i].estado_loc;

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Nome Fantasia:</span> ' + matriz["mais_arredoar"][i].nome_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Razão Social:</span> ' + matriz["mais_arredoar"][i].razao_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Telefone:</span> ' + matriz["mais_arredoar"][i].tel_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">E-mail:</span> ' + matriz["mais_arredoar"][i].email_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Endereço:</span> ' + matriz["mais_arredoar"][i].log_loc + ', ' + matriz["mais_arredoar"][i].num_loc + ' - ' + matriz["mais_arredoar"][i].bairro_loc + ' (' + matriz["mais_arredoar"][i].cid_loc + '/' + matriz["mais_arredoar"][i].estado_loc + ') - ' + matriz["mais_arredoar"][i].cep_loc + '</li>';
                            }

                            list += '</ul></li>';

                            list += '<ul class = "list-group list-group-flush">';
                            list += '<li class = "list-group-item bg-transparent"><h5 class = "text-' + cor + '">Visualizar a distância de carro de sua casa até o local</h5>';
                            list += '<ul class = "list-group list-group-flush">';
                            list += '<li class = "list-group-item bg-transparent border-' + cor + '"><div class = "input-group mb-3"><input type = "text" id = "pesq" class = "form-control" placeholder = "Seu Endereço..." aria-describedby = "pesquisar" />';
                            // list += '<select class = "custom-select" id = "mode"><option value = "" selected disabled>Locomoção...</option><option value = "DRIVING">Dirigindo</option><option value = "WALKING">Andando</option><option value = "BICYCLING">De Bicicleta</option></select>';
                            list += `<div class = "input-group-append"><button class = "btn btn-outline-${cor}" type = "button" id = "pesquisar" onclick = "calcula_distancia('${destino}')"><i class = "fa fa-search" aria-hidden = "true"></i></button></div></div>`;
                            list += '<div id = "mapa"><iframe width = "100%" height = "400px" id = "map" src = "https://maps.google.com/maps?saddr=S&atilde;o Paulo&daddr=Rio de Janeiro&output=embed"></iframe></div></li>';
                            list += '<li class = "list-group-item bg-transparent border-' + cor + '"><div id = "msn_google"></div></li>';
                            list += '</ul></li></ul>';
                            list += '</div>';
                            list += '</div></div></div>';

                            $("#modal_ver_mais").append(list);
                        }
                        $('#ver_mais').modal('show');
                    }
                });
            }
        </script>
        
        <div style = "margin-top:20px;" class = "container-fluid">
            <div class = "alert alert-primary" role = "alert">
                <div class = "row">
                    <div class = "col-md-12">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close">
                            <span aria-hidden = "true">&times;</span>
                        </button>
                    </div>

                    <img src = "oie2.png" class = "col-md-2 text-center" style = "width: 50%; height: auto; margin-left: auto;
                    margin-right: auto;"/>
                    
                    <div class = "col-md-10">
                        <div class = "alert-heading">                            
                            <h2>Seja bem-vindo!</h2>
                        </div>

                        <h6 style = "text-align: justify; white-space: normal;">
                            <p>Meu nome é Ayla e espero conseguir, por meio desta plataforma repleta de informações sobre Campanhas Solidárias na cidade de Araraquara, lhe incentivar a ser solidário, ajudando outras pessoas e famílias.</p></strong>
                            <p><strong>VEJA ABAIXO AS ÚLTIMAS DOAÇÕES / ARRECADAÇÕES CADASTRADAS OU 
                            <?php
                                if(isset($_SESSION["nome"])){
                                    echo '<a href = "cadastrar_arredoar.php" class = "alert-link text-info">CADASTRE UMA NOVA!</a></strong></p>';
                                }else{
                                    echo '<a href = "login.php" class = "alert-link text-info">CADASTRE UMA NOVA!</a></strong></p>';
                                }
                            ?>    
                            <p><strong><a href = "lista_locais.php" class = "alert-link text-info">CLIQUE AQUI </a>PARA VER NO MAPA TODAS AS DOAÇÕES E ARRECADAÇÕES CADASTRADAS!</strong></p>
                        </h6>
                    </div>
                </div>
            </div>

            <div class = "alert alert-primary" role = "alert">
                <form class = "form-inline">
                    <div class = "form-group">
                        <strong><h5>Filtros: </h5></strong>
                    </div>

                    <div class = "form-group mx-sm-1">
                        <select class = "custom-select" id = "filtro_tipo" onchange = "filtrar()">
                            <option value = "" disabled selected>Tipo da doação / arrecadação</option>
                            <option value = "VESTIMENTAS">VESTIMENTAS</option>
                            <option value = "SAPATOS">SAPATOS</option>
                            <option value = "ALIMENTÍCIA">ALIMENTÍCIA</option>
                            <option value = "BRINQUEDOS">BRINQUEDOS</option>
                            <option value = "LIVROS">LIVROS</option>
                            <option value = "MONETÁRIA">MONETÁRIA</option>
                        </select>
                    </div>

                    <div class = "form-group mx-sm-1">
                        <select class = "custom-select" id = "filtro_val" onchange = "filtrar()">
                            <option value = "" disabled selected>Validez da doação / arrecadação</option>
                            <option value = "VÁLIDA">VÁLIDA</option>
                            <option value = "INVÁLIDA">INVÁLIDA</option>
                        </select>
                    </div>

                    <div class = "form-group mx-sm-1">
                        <input type = "text" size = "50%" id = "filtro_esp" class = "form-control" placeholder = "+ Específico, como 'Casaco de Pele'..." onkeydown = "filtrar()" style = "text-transform: uppercase" />
                    </div>
                </form>
            </div>

            <div class = "card-columns" id = "arredoar">
            </div>

            <div id = "paginacao">
                <?php include("paginacao_arredoar.php"); ?>
            </div>
        </div>

        <div id = "modal_ver_mais"></div>
    </body> <!-- abriu no menu -->
</html> <!-- abriu no menu -->