<?php 
    include("menu.php"); 
    if(isset($_GET["ident"])){
        $ident = $_GET["ident"];
        echo "<script>var usu = 1; var ident = '$ident'; $(document).ready(function(){listar_arredoar('$ident')})</script>";
    }else{
        echo "<script>var usu = 2; $(document).ready(function(){listar_arredoar()})</script>";
    }
?>
        <script>
            $(document).ready(function(){
                $('[data-toggle = "tooltip"]').tooltip();
            });

            function listar_arredoar(ident){
                $("#arredoar").html("");
                $.ajax({
                    url: "listar_arredoar.php",
                    type: "get",
                    data: {ident},
                    success: function(matriz){
                        for(i=0; i<matriz["arredoar"].length; i++){
                            if(matriz["arredoar"][i].oqe == "DOAÇÃO"){
                                cor = "primary";
                            }else{
                                cor = "success";
                            }
                            list = '<div class = "card bg-dark text-light pb-2">';
                            if(matriz["arredoar"][i].foto){
                                list += '<img class = "card-img-top" src = "fotos/' + matriz["arredoar"][i].foto + '" />';
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
                            list += '<a class = "btn btn-outline-' + cor + ' float-left mr-2" data-toggle = "tooltip" data-placement = "bottom" title = "Compartilhar"><i class = "fa fa-share-alt" aria-hidden = "true"></i></a>';
                            list += '<a class = "btn btn-' + cor + ' float-left" onclick = "modal_ver_mais(' + matriz["arredoar"][i].id_doacoes + ')">Ver mais</a>';                            
                            list += '</div></div>';

                            $("#arredoar").append(list);
                        }
                    }
                });
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
                            list += '<li class = "list-group-item bg-transparent"><h5 class = "text-' + cor + '">Informações Básicas</h5>';
                            list += '<ul class = "list-group list-group-flush">';

                            list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Descrição:</span> ' + matriz["mais_arredoar"][i].desc_doa + '</li>';

                            list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Tipo:</span> ' + matriz["mais_arredoar"][i].tipo_doa + '</li>';

                            list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Quantidade:</span> ' + matriz["mais_arredoar"][i].qtd_doa + ' UNIDADES</li>';

                            list += '<li class = "list-group-item bg-transparent border-light"><span class = "text-' + cor + '">Campanha:</span> ' + matriz["mais_arredoar"][i].desc_camp + ' (' + matriz["mais_arredoar"][i].ini_camp + ' à ' + matriz["mais_arredoar"][i].fim_camp + ')</li>';

                            list += '</ul></li>';

                            list += '<ul class = "list-group list-group-flush">';
                            list += '<li class = "list-group-item bg-transparent"><h5 class = "text-' + cor + '">Contato com o Doador/Arrecadador</h5>';

                            list += '<ul class = "list-group list-group-flush">';

                            if(matriz["mais_arredoar"][i].cel_usu){
                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Nome:</span> ' + matriz["mais_arredoar"][i].nome_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Celular:</span> ' + matriz["mais_arredoar"][i].cel_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Telefone:</span> ' + matriz["mais_arredoar"][i].tel_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">E-mail:</span> ' + matriz["mais_arredoar"][i].email_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Endereço:</span> ' + matriz["mais_arredoar"][i].log_usu + ', ' + matriz["mais_arredoar"][i].num_usu + ' - ' + matriz["mais_arredoar"][i].bairro_usu + ' (' + matriz["mais_arredoar"][i].cid_usu + '/' + matriz["mais_arredoar"][i].estado_usu + ') - ' + matriz["mais_arredoar"][i].cep_usu + '</li>';
                            }else{
                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Nome Fantasia:</span> ' + matriz["mais_arredoar"][i].nome_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Razão Social:</span> ' + matriz["mais_arredoar"][i].razao_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Telefone:</span> ' + matriz["mais_arredoar"][i].tel_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">E-mail:</span> ' + matriz["mais_arredoar"][i].email_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-' + cor + '"><span class = "text-' + cor + '">Endereço:</span> ' + matriz["mais_arredoar"][i].log_loc + ', ' + matriz["mais_arredoar"][i].num_loc + ' - ' + matriz["mais_arredoar"][i].bairro_loc + ' (' + matriz["mais_arredoar"][i].cid_loc + '/' + matriz["mais_arredoar"][i].estado_loc + ') - ' + matriz["mais_arredoar"][i].cep_loc + '</li>';
                            }

                            list += '</ul></li></ul>';

                            list += '<ul class = "list-group list-group-flush">';
                            list += '<li class = "list-group-item bg-transparent"><h5 class = "text-' + cor + '">Visualizar a distância de sua casa até o local</h5>';
                            list += '</ul></li>';
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
                            <p>Meu nome é Ayla e espero conseguir, por meio desta plataforma repleta de informações sobre Campanhas Solidárias na cidade de Araraquara, lhe incentivar a ser solidário, ajudando outras pessoas e famílias.</p>
                            <p><strong>VEJA ABAIXO AS ÚLTIMAS DOAÇÕES / ARRECADAÇÕES CADASTRADAS OU <a href = "login.php" class = "alert-link">CADASTRE UMA NOVA!</a></strong></p>
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