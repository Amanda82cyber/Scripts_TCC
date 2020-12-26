<?php include("menu.php"); ?>

        <div id = "map" style = "height: 100vh; width: 100%;"></div>
        <div id = "modal_ver_mais"></div>
        
        <script>
            function initMap() {
                var options = {
                zoom: 14,
                center: { lat: -21.79444, lng: -48.17556 }, // Latitude e Longitude de Araraquara
                };

                // Novo mapa
                var map = new google.maps.Map(document.getElementById('map'), options);

                trazer_arredoar(map);
            }

            function marcar_textinho(location, url, conteudo, map){
                axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
                    params: {
                        address: location,
                        key: 'AIzaSyAD4ZWbiJdpCv5_5Fv8FHV8c6YCF_JNca8'
                    }
                })
                .then(function(response){
                    console.log(response);
                    var lat = response.data.results[0].geometry.location.lat;
                    var lng = response.data.results[0].geometry.location.lng;
                    var endereco_formatado = response.data.results[0].formatted_address;

                    var marker = new google.maps.Marker({
                        position: {lat: lat, lng: lng},
                        map: map,
                        icon: url
                    });

                    var infoWindow = new google.maps.InfoWindow({
                        maxWidth: 350,
                        content: `${conteudo}
                                  <p><strong>Endereço:</strong> ${endereco_formatado}</p>
                                  </div>`
                    });

                    marker.addListener('click', function () {
                        infoWindow.open(map, marker);
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
            }

            function trazer_arredoar(map){
                $.ajax({
                    url: "carregar_google_arredoar.php",
                    type: "get",
                    success: function(matriz){
                        for(i = 0; i < matriz["google_arredoar"].length; i++){
                            var location = matriz["google_arredoar"][i].log + ", " + matriz["google_arredoar"][i].num + " - " + matriz["google_arredoar"][i].cid + "/" + matriz["google_arredoar"][i].estado;

                            var desc = matriz["google_arredoar"][i].desc_doa;
                            var tipo = matriz["google_arredoar"][i].tipo_doa;
                            var data_ini = matriz["google_arredoar"][i].ini_doa;
                            var data_fim = matriz["google_arredoar"][i].fim_doa;
                            var oqe = matriz["google_arredoar"][i].oqe_doa;
                            var id_doacao = matriz["google_arredoar"][i].id_doacao;

                            conteudo = `<div style = "text-align: justify; white-space: normal;">
                                        <h6>${oqe} - ${tipo}
                                        <button type = "button" class = "btn btn-outline-primary btn-sm" onclick = "ver_mais(${id_doacao})"><i class="fa fa-info" aria-hidden="true"></i> Ver Mais</button></h6>
                                        <p><strong>Descrição:</strong> ${desc}</p>
                                        <p><strong>Data de Início:</strong> ${data_ini}</p>
                                        <p><strong>Data de Termino:</strong> ${data_fim}</p>`;

                            if(oqe == "ARRECADAÇÃO"){
                                url = "http://maps.google.com/mapfiles/ms/icons/green-dot.png"; 
                            }else{
                                url = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                            }

                            for(c = 0; c < matriz["google_arredoar"].length; c++){
                                var location1 = matriz["google_arredoar"][c].log + ", " + matriz["google_arredoar"][c].num + " - " + matriz["google_arredoar"][c].cid + "/" + matriz["google_arredoar"][c].estado;

                                var desc1 = matriz["google_arredoar"][c].desc_doa;
                                var tipo1 = matriz["google_arredoar"][c].tipo_doa;
                                var data_ini1 = matriz["google_arredoar"][c].ini_doa;
                                var data_fim1 = matriz["google_arredoar"][c].fim_doa;
                                var oqe1 = matriz["google_arredoar"][c].oqe_doa;
                                var id_doacao = matriz["google_arredoar"][c].id_doacao;

                                if((location == location1) && (!(i == c))){
                                    conteudo += `<hr class = "bg-primary" />
                                                <h6>${oqe1} - ${tipo1}
                                                <button type = "button" class = "btn btn-outline-primary btn-sm" onclick = "ver_mais(${id_doacao})"><i class="fa fa-info" aria-hidden="true"></i> Ver Mais</button></h6>
                                                <p><strong>Descrição:</strong> ${desc1}</p>
                                                <p><strong>Data de Início:</strong> ${data_ini1}</p>
                                                <p><strong>Data de Termino:</strong> ${data_fim1}</p>
                                                <hr class = "bg-primary" />`;
                                    url = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
                                }

                            }

                            marcar_textinho(location, url, conteudo, map);
                        }
                    }
                });
            }

            function ver_mais(id){
                $("#modal_ver_mais").html("");
                $.ajax({
                    url: "listar_mais_arredoar.php",
                    type: "post",
                    data: {id},
                    success: function(matriz){
                        for(i = 0; i<matriz["mais_arredoar"].length; i++){
                            if(matriz["mais_arredoar"][i].oqe_doa == "DOAÇÃO"){
                                cor = "primary";
                            }else{
                                cor = "success";
                            }

                            list = 
                            `<div class = "modal fade" id = "ver_mais" tabindex = "-1" role = "dialog" aria-labelledby = "ModalLabel" aria-hidden = "true">
                                <div class = "modal-dialog modal-lg">
                                    <div class = "modal-content">
                                        <div class = "modal-header border-${cor}">
                                            <h4 class = "modal-title text-${cor}" id = "ModalLabel">${matriz["mais_arredoar"][i].oqe_doa} (${matriz["mais_arredoar"][i].ini_doa} à ${matriz["mais_arredoar"][i].fim_doa})</h4>
                                            <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Fechar">
                                                <span aria-hidden = "true" class = "text-${cor}">&times;</span>
                                            </button>
                                        </div>

                                        <div class = "modal-body">
                                            <ul class = "list-group list-group-flush">
                                                <li class = "list-group-item bg-transparent border-${cor}">
                                                    <h5 class = "text-${cor}">Informações Básicas</h5>
                                                    <ul class = "list-group list-group-flush">
                                                        <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Descrição:</span>${matriz["mais_arredoar"][i].desc_doa}</li>

                                                        <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Tipo: </span>${matriz["mais_arredoar"][i].tipo_doa}</li>

                                                        <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Quantidade: </span>${matriz["mais_arredoar"][i].qtd_doa} UNIDADES</li>

                                                        <li class = "list-group-item bg-transparent border-light"><span class = "text-${cor}">Campanha: </span>${matriz["mais_arredoar"][i].desc_camp} (${matriz["mais_arredoar"][i].ini_camp} à ${matriz["mais_arredoar"][i].fim_camp})</li>
                                                    </ul>
                                                </li>
                                            </ul>

                                            <ul class = "list-group list-group-flush">
                                                <li class = "list-group-item bg-transparent border-${cor}"><h5 class = "text-${cor}">Contato com o Doador/Arrecadador</h5>
                                                    <ul class = "list-group list-group-flush">`;

                                            if(matriz["mais_arredoar"][i].cel_usu){
                                                list += `<li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Nome: </span>${matriz["mais_arredoar"][i].nome_usu}
                                                
                                                <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Celular: </span>${matriz["mais_arredoar"][i].cel_usu}</li> 

                                                <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Telefone: </span>${matriz["mais_arredoar"][i].tel_usu}</li>

                                                <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">E-mail: </span>${matriz["mais_arredoar"][i].email_usu}</li>

                                                <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Endereço: </span>${matriz["mais_arredoar"][i].log_usu}, ${matriz["mais_arredoar"][i].num_usu} - ${matriz["mais_arredoar"][i].bairro_usu} (${matriz["mais_arredoar"][i].cid_usu}/${matriz["mais_arredoar"][i].estado_usu}) - ${matriz["mais_arredoar"][i].cep_usu}</li>`;
                                            }else{
                                                list += `<li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Nome Fantasia: </span>${matriz["mais_arredoar"][i].nome_loc}
                                                
                                                <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Razão Social: </span>${matriz["mais_arredoar"][i].razao_loc}</li> 

                                                <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Telefone: </span>${matriz["mais_arredoar"][i].tel_loc}</li>

                                                <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">E-mail: </span>${matriz["mais_arredoar"][i].email_loc}</li>

                                                <li class = "list-group-item bg-transparent border-${cor}"><span class = "text-${cor}">Endereço: </span>${matriz["mais_arredoar"][i].log_loc}, ${matriz["mais_arredoar"][i].num_loc} - ${matriz["mais_arredoar"][i].bairro_loc} (${matriz["mais_arredoar"][i].cid_loc}/${matriz["mais_arredoar"][i].estado_loc}) - ${matriz["mais_arredoar"][i].cep_loc}</li>`;
                                            }

                            list +=        `</ul></li></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                            $("#modal_ver_mais").append(list);
                        }
                        $('#ver_mais').modal('show');
                    }
                });
            }
        </script>

        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAD4ZWbiJdpCv5_5Fv8FHV8c6YCF_JNca8&callback=initMap"></script>

    </body>
</html>