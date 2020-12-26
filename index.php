<?php 
    include("menu.php"); 
    if(isset($_GET["ident"])){
        $ident = $_GET["ident"];
        echo "<script>var usu = 1; var ident = '$ident'; $(document).ready(function(){listar_arredoar('$ident')})</script>";
    }else{
        echo "<script>var usu = 2; $(document).ready(function(){listar_arredoar()})</script>";
    }

    if(isset($_GET["ver_mais"])){
        $id = $_GET["ver_mais"];
        echo "<script>$(document).ready(function(){modal_ver_mais('$id')})</script>";
    }
?>
        <!-- Parâmetro sensor é utilizado somente em dispositivos com GPS -->
        <script src = "https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyAD4ZWbiJdpCv5_5Fv8FHV8c6YCF_JNca8"></script> 
        
        <script>
            $(document).ready(function(){
                $('[data-toggle = "tooltip"]').tooltip();
            });   

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

            function compartilhar(lugar, desc, foto_banco, tipo, id_arredoar){
                $("meta[property = 'og:description']").attr("content", desc);

                if(foto_banco == ""){
                    $("meta[property = 'og:image']").attr("content", 'fotos_definidas/' + fotos_definidas(tipo));
                }else{
                    $("meta[property = 'og:image']").attr("content", 'fotos/' + foto_banco);
                }

                if(lugar == "face"){
                    window.location.href = "https://www.facebook.com/sharer/sharer.php?u=icsar.tk/index.php?ver_mais=" + id_arredoar;
                }else{
                    window.location.href = "https://api.whatsapp.com/send?text=u=icsar.tk/index.php?ver_mais=" + id_arredoar;
                }
            }

            function listar_arredoar(ident){
                $("#arredoar").html("");
                $.ajax({
                    url: "listar_arredoar.php",
                    type: "get",
                    data: {ident},
                    success: function(matriz){
                        for(i=0; i<matriz["arredoar"].length; i++){
                            list = '<div class = "card bg-dark text-light pb-2">';

                            if(matriz["arredoar"][i].oqe == "DOAÇÃO"){
                                cor = "primary";

                                if(matriz["arredoar"][i].foto){
                                    list += '<img class = "card-img-top" src = "fotos/' + matriz["arredoar"][i].foto + '" />';
                                }else{
                                    list += '<img class = "card-img-top" src = "fotos_definidas/' + fotos_definidas(matriz["arredoar"][i].tipo_doa) + '" />';
                                }
                            }else{
                                cor = "success";

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
                            list += '<div class = "dropdown-menu" aria-labelledby = "menu_compartilhar">';
                            list += `<a class = "dropdown-item" id = "face" onclick = "compartilhar('${this.id}', '${matriz["arredoar"][i].desc_doa}', '${matriz["arredoar"][i].foto}', '${matriz["arredoar"][i].tipo_doa}', '${matriz["arredoar"][i].id_doacoes}')">Facebook</a>`;
                            list += `<a class = "dropdown-item" id = "whats" onclick = "compartilhar('${this.id}', '${matriz["arredoar"][i].desc_doa}', '${matriz["arredoar"][i].foto}', '${matriz["arredoar"][i].tipo_doa}', '${matriz["arredoar"][i].id_doacoes}')">Whatsapp</a>`;
                            list += '</div></div>';
                            list += '<a class = "btn btn-' + cor + ' float-left" onclick = "modal_ver_mais(' + matriz["arredoar"][i].id_doacoes + ')">Ver mais</a>';                            
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
                            listar_arredoar(ident);
                        }else{
                            alert(data);
                        }
                    }
                });
            }

            function modal_ver_mais(id){
                $("#modal_ver_mais").html("");
                $.ajax({
                    url: "listar_mais_arredoar.php",
                    type: "post",
                    data: {id},
                    success: function(matriz){
                        for(i=0; i<matriz["mais_arredoar"].length; i++){
                            if(matriz["mais_arredoar"][i].oqe_doa == "DOAÇÃO"){
                                cor = "primary";
                            }else{
                                cor = "success";
                            }

                            list = '<div class = "modal fade" id = "ver_mais" tabindex = "-1" role = "dialog" aria-labelledby = "ModalLabel" aria-hidden = "true">';
                            list += '<div class = "modal-dialog modal-lg">';
                            list += '<div class = "modal-content bg-dark text-light">';
                            list += '<div class = "modal-header border-' + cor + '">';
                            list += '<h4 class = "modal-title text-' + cor + '" id = "ModalLabel">' + matriz["mais_arredoar"][i].oqe_doa + ' (' + matriz["mais_arredoar"][i].ini_doa + ' à ' + matriz["mais_arredoar"][i].fim_doa + ')</h4>';
                            list += '<button type = "button" class = "close" data-dismiss = "modal" aria-label = "Fechar">';
                            list += '<span aria-hidden = "true" class = "text-' + cor + '">&times;</span>';
                            list += '</button></div>';
                            list += '<div class = "modal-body">';
                            list += '<ul class = "list-group list-group-flush">';
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
                            <p><strong><a href = "lista_locais.php" class = "alert-link text-info">CLIQUE AQUI </a>PARA VER TODAS AS DOAÇÕES (AZUL) E ARRECADAÇÕES (VERDE) CADASTRADAS!</strong></p>
                        </h6>
                    </div>
                </div>
            </div>

            <div class = "card-columns" id = "arredoar">
            </div>
        </div>

        <div id = "modal_ver_mais"></div>
    </body> <!-- abriu no menu -->
</html> <!-- abriu no menu -->