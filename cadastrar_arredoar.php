<?php 
    include("menu.php");
?>
    
        <script>
            var temp = "";
            var joga = "";
            var foto = "";
            $(document).ready(function(){
                $("#q_tipo").attr("disabled", true);
                $("#div_campanha").addClass("col-md-4");
                $("#div_senha").addClass("col-md-2");
                select_campanha();

                $("#cad_campanha").click(function(){
                    if(!(($("#desc1").val() == "") && ($("#data_ini").val() == "0000-00-00") && ($("#data_ter").val() == "0000-00-00"))){
                        $.ajax({
                            url: "inserir_campanhas.php",
                            type: "post",
                            data: {descricao: $("#desc1").val(), data_ini: $("#data_ini").val(), data_ter: $("#data_ter").val()},
                            success: function(data){
                                if(data == 1){
                                    $("#msn1").html("*Campanha cadastrada com sucesso!").css("color", "green");
                                    select_campanha();
                                }else{
                                    $("#msn1").html("*Erro: " + data).css("color", "red");
                                }
                            }
                        });
                    }else{
                        $("#msn1").html("*Preencha todos os campos!").css("color", "red");
                    }
                });

                $("#arredoar").change(function(){
                    if($("#arredoar").val() == "DOAÇÃO"){
                        $("#div_campanha").addClass("col-md-6");
                        $("#div_foto").addClass("col-md-6");

                        $("#div_foto").html('<div class = "input-group"><div class = "custom-file"><input type = "file" class = "custom-file-input" name = "foto" onchange = "mudar_texto_foto(this.value)" /><label class = "custom-file-label" id = "label_foto" for = "foto">Escolher foto</label></div></div>');
                        $("#div_senha").html('<input id = "salvar" class = "btn btn-primary btn-block btn-md" type = "submit" value = "Cadastrar" />');
                    }else{
                        $("#div_campanha").addClass("col-md-4").removeClass("col-md-6");
                        $("#div_senha").html('<label class = "invisible">A</label><input id = "salvar" class = "btn btn-primary btn-block btn-md" type = "submit" value = "Cadastrar" />');
                        $("#div_foto").html("").removeClass("col-md-6");
                    }
                });
            });

            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                        var form = $("#f")[0]; //recebe o formulário inteiro
                        var formData = new FormData(form);
                        formData.append("arredoar", $("#arredoar").val());
                        console.log(formData);

                        if (form.checkValidity()){
                            if(!($("#arredoar").val() == null)){
                                $.ajax({
                                    url: "inserir_arredoar.php",
                                    type: "post",
                                    enctype: "multipart/form-data",
                                    data: formData,
                                    processData: false,  
		                            contentType: false,
                                    success: function(data){
                                        if(data == 1){
                                            $("#arredoar").val("");
                                            $("#desc").val("");
                                            $("#quant").val("");
                                            $("#tipo").val("");
                                            $("#q_tipo").val("");
                                            $("#data_inicio").val("");
                                            $("#data_fim").val("");
                                            $("#campanha").val("");
                                            if($("#arredoar").val() == "DOAÇÃO"){ $("#foto").val(""); };
                                            $("#msn").html("Cadastro efetuado com sucesso!").css("color", "green");
                                        }else{
                                            $("#msn").html("Erro: " + data).css("color", "red");
                                        }
                                    }
                                });
                            }else{
                                $("#msn").html("O cadastro é de que? Doação ou arrecadação? Selecione uma opção!").css("color", "red");
                            }
                        }else{
                            $("#msn").html("*Preencha os campos obrigatórios!").css("color", "red");
                        }    

                        event.preventDefault();
                        event.stopPropagation();
                        form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();

            function mudar_texto_foto(valor){
                $("#label_foto").html(valor);
            }

            function qual(op){
                v = '#'+op;
                v2 = '#q_'+op;
                if($(v).val() == "OUTRO" || $(v).val() == "OUTRA"){
                    $(v2).attr("disabled", false);
                    $(v2).attr("placeholder", "Diga qual...");
                }else{
                    $(v2).attr("disabled", true);
                    $(v2).attr("placeholder", "");
                }
            }

            function cadastrar_campanha(valor){
                if(valor == "CADASTRAR NOVA"){
                    $('#nova_campanha').modal('show');
                }
            }

            function select_campanha(){
                $("#campanha").html("");
                $.ajax({
                    url: "select_campanha.php",
                    type: "get",
                    success: function(matriz){
                        option = '<option value = "" selected disabled>ESCOLHA UMA OPÇÃO</option>';
                        for(i=0; i<matriz["campanhas"].length; i++){
                            if(matriz["campanhas"][i].id_campanha == 1){
                                option += '<option value = "' + matriz["campanhas"][i].id_campanha + '">' + matriz["campanhas"][i].descricao + '</option>';
                            }else{
                                option += '<option value = "' + matriz["campanhas"][i].id_campanha + '">' + matriz["campanhas"][i].descricao + ' (' + matriz["campanhas"][i].data_inicio + ' à ' + matriz["campanhas"][i].data_fim + ') </option>';
                            }
                        }
                        $("#campanha").html(option);
                    }
                });
            }

            function nova_campanha(opcao){
                if(temp == ""){
                    temp = $("#campanha").html();
                }

                if(opcao == "ARRECADAÇÃO"){
                    incremento = $("#campanha").html();
                    incremento += '<option value = "CADASTRAR NOVA">CADASTRAR NOVA</option>';
                    $("#campanha").html(incremento);
                }else{
                    $("#campanha").html(temp);
                }
            }
        </script>
        
        <div style = "margin-top:20px;" class = "container-fluid">
            <div class = "row">
                <div class = "col-md-1 col-sm-12 col-xs-12"></div>
                
                <div class = "col-md-10 col-sm-12 col-xs-12">
                    <div class = "card text-light bg-dark">
                        <div class = "card-header">
                            <form>
                                <div class = "form-group row">
                                    <h3>&nbsp Cadastro de</h3>
                                    <div class = "col-md-3">
                                        <select class = "form-control" id = "arredoar" required onchange = "nova_campanha(this.value)">
                                            <option value = "" selected disabled>Escolha...</option>
                                            <option value = "ARRECADAÇÃO">Arrecadação</option>
                                            <option value = "DOAÇÃO">Doação</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class = "card-body">
                            <form class = "needs-validation" novalidate id = "f" enctype = "multipart/form-data">
                                <div class = "form-row">
                                    <div class = "form-group col-md-12">
                                        <label class = "form-control-placeholder" for = "desc">Descrição</label>
                                        <input type = "text" class = "form-control" id = "desc" name = "desc" style = "text-transform: uppercase" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "quant">Quantidade</label>
                                        <input type = "number" step = "1" min = "1" class = "form-control" id = "quant" name = "quant" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "tipo">Tipo</label>
                                            <select class = "form-control" name = "tipo" required onchange = "qual(this.id)">
                                                <option value = "" selected disabled>ESCOLHA UMA OPÇÃO</option>
                                                <option value = "VESTIMENTAS">VESTIMENTAS</option>
                                                <option value = "SAPATOS">SAPATOS</option>
                                                <option value = "ALIMENTÍCIA">ALIMENTÍCIA</option>
                                                <option value = "BRINQUEDOS">BRINQUEDOS</option>
                                                <option value = "LIVROS">LIVROS</option>
                                                <option value = "MONETÁRIA">MONETÁRIA</option>
                                                <option value = "OUTRO">OUTRO</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div class = "form-group col-md-6">
                                        <label class = "form-control-placeholder" for = "q_tipo">Qual?</label>
                                        <input type = "text" class = "form-control" name = "q_tipo" style = "text-transform: uppercase" id = "q_tipo" />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "data_inicio">Data de Início</label>
                                        <input type = "date" class = "form-control" id = "data_inicio" name = "data_inicio" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "data_fim">Data de Término</label>
                                        <input type = "date" class = "form-control" id = "data_fim" name = "data_fim" required />
                                    </div>

                                    <div class = "form-group" id = "div_campanha">
                                        <label class = "form-control-placeholder" for = "campanha">Campanha</label>
                                            <select class = "form-control" id = "campanha" name = "campanha" required onchange = "cadastrar_campanha(this.value)">
                                                
                                            </select>
                                        </label>
                                    </div>

                                    <div class = "form-group" id = "div_foto"></div>
                                    
                                    <div class = "form-group" id = "div_senha">
                                        <label class = "invisible">A</label>
                                        <input id = "salvar" class = "btn btn-primary btn-block btn-md" type = "submit" value = "Cadastrar" />  
                                    </div>

                                    <div class = "form-group col-md-12" id = "msn"></div>
                                    
                                </div>
                            </form> 
                        </div>
                    </div>   
                    

                    <div class = "modal fade" id = "nova_campanha" tabindex = "-1" role = "dialog" aria-labelledby = "label" aria-hidden = "true">
                        <div class = "modal-dialog" role = "document">
                            <div class = "modal-content bg-dark text-light">
                                <div class = "modal-header border-primary">
                                    <h5 class = "modal-title text-primary" id = "label">Nova Campanha Solidária</h5>
                                    <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Fechar">
                                        <span aria-hidden = "true" class = "text-primary">&times;</span>
                                    </button>
                                </div>
                                
                                <div class = "modal-body">
                                    <form>
                                        <div class = "form-group">
                                            <label for = "desc1" class = "col-form-label">Descrição</label>
                                            <input type = "text" class = "form-control" id = "desc1" placeholder = "Ex.: Campanha de Inverno" style = "text-transform: uppercase" />
                                        </div>

                                        <div class = "form-group">
                                            <label for = "data_ini" class = "col-form-label">Data de Início</label>
                                            <input type = "date" class = "form-control" id = "data_ini" />
                                        </div>

                                        <div class = "form-group">
                                            <label for = "data_ter" class = "col-form-label">Data de Termino</label>
                                            <input type = "date" class = "form-control" id = "data_ter" />
                                        </div>
                                    </form>
                                </div>

                                <div id = "msn1"></div>

                                <div class = "modal-footer border-primary">
                                    <button type = "button" id = "cad_campanha" class = "btn btn-outline-primary">Cadastrar</button>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class = "col-md-1 col-sm-12 col-xs-12"></div>
            </div>
        </div>
    </body> <!-- abriu no menu -->
</html> <!-- abriu no menu -->