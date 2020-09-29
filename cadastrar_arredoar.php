<?php 
    include("menu.php");
?>
    
        <script>
            var temp = "";
            $(document).ready(function(){
                $("#q_tipo").attr("disabled", true);
            });

            (function() {
                'use strict';
                window.addEventListener('load', function() {

                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                        if (form.checkValidity()){
                            if($("#senha").val() == $("#confirmar_senha").val()){
                                if(oqe == "Jurídica"){
                                    $.ajax({
                                        url: "inserir_usuario.php",
                                        type: "post",
                                        data: {cnpj: $("#cnpj").val(), nome_fant: $("#nome_fant").val(), razao_social: $("#razao_social").val(), nome_repre: $("#nome_repre").val(), cpf_repre: $("#cpf_repre").val(), email: $("#email").val(), tel: $("#tel").val(), cep: $("#cep").val(), bairro: $("#bairro").val(), cid: $("#cid").val(), estado: $("#estado").val(), log: $("#log").val(), num: $("#num").val(), senha: $("#senha").val(), oqe},
                                        success: function(data){
                                            if(data == 1){
                                                $("#cnpj").val("");
                                                $("#nome_fant").val("");
                                                $("#razao_social").val("");
                                                $("#nome_repre").val("");
                                                $("#cpf_repre").val("");
                                                $("#email").val("");
                                                $("#tel").val("");
                                                $("#cep").val("");
                                                $("#bairro").val("");
                                                $("#cid").val("");
                                                $("#estado").val("");
                                                $("#log").val("");
                                                $("#num").val("");
                                                $("#senha").val("");
                                                $("#confirmar_senha").val("");
                                                $("#msn").html("Cadastro efetuado com sucesso!").css("color", "green");
                                            }else{
                                                $("#msn").html("Erro: " + data).css("color", "red");
                                            }
                                        }
                                    });
                                }else{
                                    $.ajax({
                                        url: "inserir_usuario.php",
                                        type: "post",
                                        data: {cpf: $("#cpf").val(), nome: $("#nome").val(), cel: $("#cel").val(), tel: $("#tel").val(), cep: $("#cep").val(), bairro: $("#bairro").val(), cid: $("#cid").val(), estado: $("#estado").val(), log: $("#log").val(), num: $("#num").val(), senha: $("#senha").val(), email: $("#email").val(), oqe},
                                        success: function(data){
                                            if(data == 1){
                                                $("#cpf").val("");
                                                $("#nome").val("");
                                                $("#cel").val("");
                                                $("#tel").val("");
                                                $("#cep").val("");
                                                $("#bairro").val("");
                                                $("#cid").val("");
                                                $("#estado").val("");
                                                $("#log").val("");
                                                $("#num").val("");
                                                $("#senha").val("");
                                                $("#email").val("");
                                                $("#confirmar_senha").val("");
                                                $("#msn").html("Cadastro efetuado com sucesso!").css("color", "green");
                                            }else{
                                                $("#msn").html("Erro: " + data).css("color", "red");
                                            }
                                        }
                                    });
                                }
                            }else{
                                $("#msn").html("Os campos 'Senha' e 'Confirmar Senha' devem ser iguais!!").css("color", "red");
                            }
                        } else {
                            $("#msn").html("*Preencha os campos obrigatórios!").css("color", "red");
                        }    

                        event.preventDefault();
                        event.stopPropagation();
                        form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();

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

            function nova_campanha(opcao){
                if(temp == ""){
                    temp = $("#campanha").html();
                }

                if(opcao == "ARRECADAÇÃO"){
                    incremento = $("#campanha").html();
                    incremento += '<option><button type = "button" class = "btn btn-outline-primary m-2" data-toggle = "modal" data-target = "#nova_campanha">CADASTRAR NOVA</button></option>';
                    $("#campanha").html(incremento);
                }else{
                    $("#campanha").html(temp);
                }
            }
        </script>
        
        <div style = "margin-top:50px;" class = "container-fluid">
            <div class = "row">
                <div class = "col-md-1 col-sm-12 col-xs-12"></div>
                
                <div class = "col-md-10 col-xs-12 col-xs-12">
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
                            <form class = "needs-validation" novalidate>
                                <div class = "form-row">
                                    <div class = "form-group col-md-12">
                                        <label class = "form-control-placeholder" for = "desc">Descrição</label>
                                        <input type = "text" class = "form-control" id = "desc" style = "text-transform: uppercase" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "quant">Quantidade</label>
                                        <input type = "number" step = "1" min = "1" class = "form-control" id = "quant" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "tipo">Tipo</label>
                                            <select class = "form-control" id = "tipo" required onchange = "qual(this.id)">
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
                                        <input type = "text" class = "form-control" style = "text-transform: uppercase" id = "q_tipo" />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "data_inicio">Data de Início</label>
                                        <input type = "date" class = "form-control" id = "data_inicio" />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "data_fim">Data de Término</label>
                                        <input type = "date" class = "form-control" id = "data_fim" />
                                    </div>

                                    <div class = "form-group col-md-4">
                                        <label class = "form-control-placeholder" for = "campanha">Campanha</label>
                                            <select class = "form-control" id = "campanha" required>
                                                <option value = "" selected disabled>ESCOLHA UMA OPÇÃO</option>
                                                <?php
                                                    include("conexao.php");

                                                    $consulta = "SELECT * FROM campanha";
                                                    $resultado = mysqli_query($conexao, $consulta);

                                                    while($linha = mysqli_fetch_assoc($resultado)){
                                                        echo '<option value = "' . $linha["id_campanha"] . '">' . $linha["descricao"] . ' ( ' . $linha["data_inicio"] . ' - ' . $linha["data_fim"] . ' )</option>';
                                                    };
                                                ?>
                                            </select>
                                        </label>
                                    </div>
                                    
                                    <div class = "form-group col-md-2">
                                        <label class = "invisible">A</label>
                                        <input id = "salvar" class = "btn btn-success btn-block btn-md" type = "submit" value = "Cadastrar" />  
                                    </div>

                                    <div id = "msn" class = "form-group col-md-12"></div>
                                </div>
                            </form> 
                        </div>
                    </div>   
                    

                    <div class = "modal fade" id = "nova_campanha" tabindex = "-1" role = "dialog" aria-labelledby = "label" aria-hidden = "true">
                        <div class = "modal-dialog" role = "document">
                            <div class = "modal-content">
                                <div class = "modal-header">
                                    <h5 class = "modal-title" id = "label">Nova mensagem</h5>
                                    <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Fechar">
                                        <span aria-hidden = "true">&times;</span>
                                    </button>
                                </div>
                                
                                <div class = "modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Destinatário:</label>
                                            <input type="text" class="form-control" id="recipient-name">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Mensagem:</label>
                                            <textarea class="form-control" id="message-text"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="button" class="btn btn-primary">Enviar</button>
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