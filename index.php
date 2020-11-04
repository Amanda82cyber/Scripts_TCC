<?php include("menu.php"); ?>

        <script>
            $(document).ready(function(){
                $('#modal_bem_vindo').modal('show');
                listar_arredoar();
                $('[data-toggle="tooltip"]').tooltip();
            });

            function listar_arredoar(){
                $("#arredoar").html("");
                $.ajax({
                    url: "listar_arredoar.php",
                    type: "get",
                    success: function(matriz){
                        for(i=0; i<matriz["arredoar"].length; i++){
                            list = '<div class = "col-md-3 col-sm-6 col-xs-12">';
                            list += '<div class = "card bg-dark text-light" style = "width: 18rem;">';
                            // list += '<img class = "card-img-top" src = ".../100px180/" alt = "Imagem de capa do card">';
                            list += '<div class = "card-body">';
                            list += '<h5 class = "card-title text-center text-primary">' + matriz["arredoar"][i].oqe + '</h5>';
                            list += '<p class = "card-text">';
                            list += '<p><span class = "text-primary">Descrição:</span> ' + matriz["arredoar"][i].desc_doa + '</p>';
                            list += '<p><span class = "text-primary">Tipo:</span> ' + matriz["arredoar"][i].tipo_doa + '</p>';
                            list += '<p><span class = "text-primary">Quantidade:</span> ' + matriz["arredoar"][i].qtd_doa + ' UNIDADES</p>';
                            list += '<p><span class = "text-primary">Data de Inicio:</span> ' + matriz["arredoar"][i].ini_doa + '</p>';
                            list += '<p><span class = "text-primary">Data de Término:</span> ' + matriz["arredoar"][i].fim_doa + '</p>';
                            list += '</p>';
                            list += '<a class = "btn btn-primary float-right" onclick = "modal_ver_mais(' + matriz["arredoar"][i].id_doacoes + ')">Ver mais</a>';
                            list += '<a class = "btn btn-outline-primary float-right mr-2" data-toggle = "tooltip" data-placement = "bottom" title = "Compartilhar"><i class = "fa fa-share-alt" aria-hidden = "true"></i></a>';
                            list += '</div></div>';                             
                            list += '</div>';

                            $("#arredoar").append(list);
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
                            list = '<div class = "modal fade" id = "ver_mais" tabindex = "-1" role = "dialog" aria-labelledby = "ModalLabel" aria-hidden = "true">';
                            list += '<div class = "modal-dialog modal-lg">';
                            list += '<div class = "modal-content bg-dark text-light">';
                            list += '<div class = "modal-header border-primary">';
                            list += '<h4 class = "modal-title text-primary" id = "ModalLabel">' + matriz["mais_arredoar"][i].oqe_doa + ' (' + matriz["mais_arredoar"][i].ini_doa + ' à ' + matriz["mais_arredoar"][i].fim_doa + ')</h4>';
                            list += '<button type = "button" class = "close" data-dismiss = "modal" aria-label = "Fechar">';
                            list += '<span aria-hidden = "true" class = "text-primary">&times;</span>';
                            list += '</button></div>';
                            list += '<div class = "modal-body">';
                            list += '<ul class = "list-group list-group-flush">';
                            list += '<li class = "list-group-item bg-transparent"><h5 class = "text-primary">Informações Básicas</h5>';
                            list += '<ul class = "list-group list-group-flush">';

                            list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Descrição:</span> ' + matriz["mais_arredoar"][i].desc_doa + '</li>';

                            list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Tipo:</span> ' + matriz["mais_arredoar"][i].tipo_doa + '</li>';

                            list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Quantidade:</span> ' + matriz["mais_arredoar"][i].qtd_doa + ' UNIDADES</li>';

                            list += '<li class = "list-group-item bg-transparent border-light"><span class = "text-primary">Campanha:</span> ' + matriz["mais_arredoar"][i].desc_camp + ' (' + matriz["mais_arredoar"][i].ini_camp + ' à ' + matriz["mais_arredoar"][i].fim_camp + ')</li>';

                            list += '</ul></li>';

                            list += '<ul class = "list-group list-group-flush">';
                            list += '<li class = "list-group-item bg-transparent"><h5 class = "text-primary">Contato com o Doador/Arrecadador</h5>';

                            list += '<ul class = "list-group list-group-flush">';

                            if(matriz["mais_arredoar"][i].cel_usu){
                                list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Nome:</span> ' + matriz["mais_arredoar"][i].nome_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Celular:</span> ' + matriz["mais_arredoar"][i].cel_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Telefone:</span> ' + matriz["mais_arredoar"][i].tel_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">E-mail:</span> ' + matriz["mais_arredoar"][i].email_usu + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Endereço:</span> ' + matriz["mais_arredoar"][i].log_usu + ', ' + matriz["mais_arredoar"][i].num_usu + ' - ' + matriz["mais_arredoar"][i].bairro_usu + ' (' + matriz["mais_arredoar"][i].cid_usu + '/' + matriz["mais_arredoar"][i].estado_usu + ') - ' + matriz["mais_arredoar"][i].cep_usu + '</li>';
                            }else{
                                list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Nome Fantasia:</span> ' + matriz["mais_arredoar"][i].nome_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Razão Social:</span> ' + matriz["mais_arredoar"][i].razao_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Telefone:</span> ' + matriz["mais_arredoar"][i].tel_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">E-mail:</span> ' + matriz["mais_arredoar"][i].email_loc + '</li>';

                                list += '<li class = "list-group-item bg-transparent border-primary"><span class = "text-primary">Endereço:</span> ' + matriz["mais_arredoar"][i].log_loc + ', ' + matriz["mais_arredoar"][i].num_loc + ' - ' + matriz["mais_arredoar"][i].bairro_loc + ' (' + matriz["mais_arredoar"][i].cid_loc + '/' + matriz["mais_arredoar"][i].estado_loc + ') - ' + matriz["mais_arredoar"][i].cep_loc + '</li>';
                            }

                            list += '</ul></li></ul>';

                            list += '<ul class = "list-group list-group-flush">';
                            list += '<li class = "list-group-item bg-transparent"><h5 class = "text-primary">Visualizar a distância de sua casa até o local</h5>';
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
            <div class = "row" id = "arredoar">
            </div>
        </div>

        <div class = "modal fade" id = "modal_bem_vindo" tabindex = "-1" role = "dialog" aria-labelledby = "titulo_bem_vindo" aria-hidden = "true">
            <div class = "modal-dialog modal-dialog-centered" role = "document">
                <div class = "modal-content bg-dark text-light">
                    <div class = "modal-body">
                        <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Fechar">
                            <span aria-hidden =" true" class = "text-light">&times;</span>
                        </button>
                        <table class = "table table-borderless table-dark">
                            <tbody>
                                <tr>
                                    <td width = "70%">
                                        <h4>Seja muito bem-vindo!</h4>
                                        <h6 style = "text-align: justify; white-space: normal;">Meu nome é Ayla e espero conseguir, por meio desta plataforma repleta de informações sobre Campanhas Solidárias na cidade de Araraquara, lhe incentivar a ser solidário, ajudando outras pessoas e famílias.</h6>
                                    </td>
                                    <td style = "background-image: url(oie.png); background-size: 100% 100%; background-repeat: no-repeat;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id = "modal_ver_mais"></div>
    </body> <!-- abriu no menu -->
</html> <!-- abriu no menu -->