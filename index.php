<?php include("menu.php"); ?>

        <script>
            $(document).ready(function(){
                $('#modal_bem_vindo').modal('show');
                listar_arredoar();
            });

            function listar_arredoar(){
                $("#arredoar").html("");
                $.ajax({
                    url: "listar_arredoar.php",
                    type: "get",
                    success: function(matriz){
                        for(i=0; i<matriz["arredoar"].length; i++){
                            list = '<div class = "col-md-3 col-sm-12 col-xs-12">';
                            list += '<div class = "card bg-dark text-light" style = "width: 18rem;">';
                            // list += '<img class = "card-img-top" src = ".../100px180/" alt = "Imagem de capa do card">';
                            list += '<div class = "card-body">';
                            list += '<h5 class = "card-title text-center">' + matriz["arredoar"][i].oqe + '</h5>';
                            list += '<p class = "card-text">';
                            list += '<p>Descrição: ' + matriz["arredoar"][i].desc_doa + '</p>';
                            list += '<p>Tipo: ' + matriz["arredoar"][i].tipo_doa + '</p>';
                            list += '<p>Quantidade: ' + matriz["arredoar"][i].qtd_doa + '</p>';
                            list += '<p>Data de Inicio: ' + matriz["arredoar"][i].ini_doa + '</p>';
                            list += '<p>Data de Término: ' + matriz["arredoar"][i].fim_doa + '</p>';
                            list += '</p>';
                            list += '<button type = "button" class = "btn btn-primary float-right" data-toggle = "modal" data-target = "#modalExemplo">Ver mais</button>';
                            list += '</div></div>';                             
                            list += '</div>';

                            $("#arredoar").append(list);
                        }
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
    </body> <!-- abriu no menu -->
</html> <!-- abriu no menu -->