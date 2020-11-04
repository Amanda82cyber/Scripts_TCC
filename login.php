<?php 
    include("menu.php"); 
    echo '$(document).ready(function(){codigo = '. $_SESSION["codigo"] .'});';
?>

        <script>
            cont = 0;
            $(document).ready(function(){

                $("#btn_senha").click(function(){
                    if($("#senha").attr("type") ==  "password"){
                        $("#btn_senha").html('<i class = "fa fa-eye" aria-hidden = "true"></i>');
                        $("#senha").attr("type", "text");
                    }else{
                        $("#btn_senha").html('<i class = "fa fa-eye-slash" aria-hidden = "true"></i>');
                        $("#senha").attr("type", "password");
                    }
                });

                $("#prosseguir").click(function(){
                    if($("input[name = 'fis_jur']:checked").length <= 0){
                        $("#msn").html("Escolha uma das opções!!").css("color", "red");
                    }else{
                        window.location.href = "cadastrar_usuario.php?fis_jur=" + $("input[name = 'fis_jur']:checked").val();
                    }
                });

                $("input[name = 'oqs']").change(function(){
                    if($("input[name = 'oqs']:checked").val() == "Física"){
                        campo = '<div class = "form-group"><label for = "ident_alt" class = "col-form-label">CPF <small> (Com Pontuação)</small></label><input type = "text" class = "form-control" id = "ident_alt" /></div>';
                    }else{
                        campo = '<div class = "form-group"><label for = "ident_alt" class = "col-form-label">CNPJ <small> (Apenas Números)</small></label><input type = "number" class = "form-control" id = "ident_alt" /></div>';
                    }
                    campo += '<div class = "form-group"><label for = "email_alt" class = "col-form-label">E-mail</label><input type = "email" class = "form-control" id = "email_alt" /></div>';
                    $("#continuacao").html(campo);
                });

                $("#OK").click(function(){
                    nome = $("button[id = 'OK']").attr("name");
                    if(nome == "OK"){
                        if($("input[name = 'oqs']:checked").length <= 0){
                            $("#msn2").html("Selecione uma das opções!").css("color", "red");
                        }else{
                            if(($("#email_alt").val() == "") && ($("#ident_alt").val() == "")){
                                $("#msn2").html("Os campos acima são obrigatórios!").css("color", "red");
                            }else{
                                $.ajax({
                                    url: "consultar_usu_alt.php",
                                    type: "post",
                                    data: {email: $("#email_alt").val(), identificador: $("#ident_alt").val(), oqe: $("input[name = 'oqs']:checked").val()},
                                    success: function(data){
                                        if(data == 1){
                                            $("#msn2").html("Digite no campo 'Código' a sequência de números que recebeu em seu e-mail!");
                                            $("#continuacao").html('<div class = "form-group"><label for = "cod" class = "col-form-label">Código</label><input type = "number" class = "form-control" id = "cod" /></div>');
                                            $("button[id = 'OK']").attr("name", "Confirmar");
                                            $("button[id = 'OK']").html("Confirmar");
                                        }else{
                                            $("#msn2").html(data).css("color", "red");
                                        }
                                    }
                                });
                            }
                        }
                    }else if(nome == "Confirmar"){
                        if($("#cod").val() == codigo){
                            $("#msn2").html("Você é você mesmo! Digite sua nova senha e a confirme nos campos acima!");
                            $("#continuacao").html('<div class = "form-group"><label for = "senha_alt" class = "col-form-label">Nova Senha</label><input type = "number" class = "form-control" id = "senha_alt" /><label for = "confirme_senha_alt" class = "col-form-label">Confirmar Senha</label><input type = "number" class = "form-control" id = "confirme_senha_alt" /></div>');
                            $(this).prop("name", "Alterar").html("Alterar");
                        }else{
                            cont++;
                            if(cont < 4){
                                $("#msn2").html("Verifique se digitou o código corretamente!");
                            }else{
                                $("button[data-target = '#troquesenha']").click();
                            }
                        }
                    }else{

                    }
                });
            });

            (function() {
                'use strict';
                window.addEventListener('load', function() {

                    var forms = document.getElementsByClassName('needs-validation');

                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity()) {
                                $.ajax({
                                    url: "verifica_usu.php",
                                    type: "post",
                                    data: {usuario: $("#usuario").val(), senha: $("#senha").val()},
                                    success: function(data){
                                        if(data == 1){
                                            $("#senha").val("");
                                            $("#usuario").val("");
                                            window.location.href = "index.php";
                                        }else{
                                            $("#msg_login").html("Erro: " + data).css("color", "red");
                                        }
                                    }
                                });
                            }else{
                                $("#msg_login").html("*Preencha os campos obrigatórios!").css("color", "red");
                            }    

                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>

        <div style = "margin-top:50px;" class = "container-fluid">
            <div class = "row">
                <div class = "col-md-4 col-sm-12 col-xs-12"></div>

                <div class = "col-md-4 col-sm-12 col-xs-12">
                    <div class = "card text-white bg-dark" style = "-webkit-box-shadow: 0px 4px 20px 5px rgba(0,0,0,0.75);-moz-box-shadow: 0px 4px 20px 5px rgba(0,0,0,0.75); box-shadow: 0px 4px 20px 5px rgba(0,0,0,0.75);">
                        <div class = "card-header text-center"><h3>Login</h3></div>

                        <div class = "card-body">
                            <form id = "form_login" class = "needs-validation" novalidate>
                                <div class = "form-row">
                                    <div class = "form-group col-md-12">
                                        <div class = "input-group">
                                            <div class = "input-group-prepend">
                                                <span class = "input-group-text bg-transparent border-primary text-primary" id = "basic-addon1">@</span>
                                            </div>
                                            <input type = "email" class = "form-control" id = "usuario" placeholder = "Usuário" aria-label = "Usuário" aria-describedby = "basic-addon1" />
                                        </div>
                                    </div>

                                    <div class = "form-group col-md-12">
                                        <div class = "input-group">
                                            <input class = "form-control" type = "password" id = "senha" placeholder = "Senha" aria-describedby = "btn_senha" />
                                            <div class = "input-group-append">
                                                <button class = "btn btn-outline-primary" type = "button" id = "btn_senha"><i class = "fa fa-eye-slash" aria-hidden = "true"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class = "form-group col-md-12" id = "msg_login"></div>

                                    <div class = "form-group col-md-12 mt-3">
                                        <input id = "entrar" class = "btn btn-primary btn-block btn-md" type = "submit" value = "Entrar" />
                                    </div>

                                    <div class = "form-group col-md-6">
                                        <button type = "button" class = "btn btn-outline-primary btn-block btn-sm" data-toggle = "modal" data-target = ".bd-example-modal-sm">Cadastrar</button>
                                    </div>

                                    <div class = "form-group col-md-6">
                                        <button type = "button" class = "btn btn-outline-primary btn-block btn-sm" data-toggle = "modal" data-target = "#troqueSenha">Alterar Senha</button>
                                    </div>
                                    
                                </div>
                            </form>       
                        </div>
                    </div>          
                </div>

                <div class = "col-md-4 col-sm-12 col-xs-12"></div>
            </div>
        </div>

        <div class = "modal fade bd-example-modal-sm" tabindex = "-1" role = "dialog" aria-labelledby = "perguntinha" aria-hidden = "true">
            <div class = "modal-dialog modal-sm">
                <div class = "modal-content bg-dark text-light">
                    <div class = "modal-header border-primary">
                        <h5 class = "modal-title" id = "perguntinha">Sou uma pessoa...</h5>
                        <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Fechar">
                            <span aria-hidden = "true" class = "text-primary">&times;</span>
                        </button>
                    </div>

                    <div class = "modal-body">
                        <form>
                            <div class = "form-group">
                                <input type = "radio" name = "fis_jur" id = "fis" value = "Física" />
                                <label for = "fis">FÍSICA</label>
                                <input type = "radio" name = "fis_jur" id = "jur" value = "Jurídica" />
                                <label for = "jur">JURÍDICA</label>
                            </div>
                        </form>
                        <div id = "msn"></div>
                    </div>

                    <div class = "modal-footer border-primary">
                        <button type = "button" id = "prosseguir" class = "btn btn-outline-primary">Prosseguir</button>
                    </div>
                </div>
            </div>
        </div>

        <div class = "modal fade" id = "troqueSenha" tabindex = "-1" role = "dialog" aria-labelledby = "tit_troc_sen" aria-hidden = "true">
            <div class = "modal-dialog" role = "document">
                <div class = "modal-content bg-dark text-light">
                    <div class = "modal-header border-primary">
                        <h5 class = "modal-title text-primary" id = "tit_troc_sen">Alterar Senha</h5>
                        <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Fechar">
                            <span aria-hidden = "true" class = "text-primary">&times;</span>
                        </button>
                    </div>

                    <div class = "modal-body">
                        <form id = "form_alt">
                            <div class = "form-group">
                                <label for = "oqs" class = "col-form-label">Sou uma pessoa...</label>
                                <input type = "radio" name = "oqs" id = "fis_alt" value = "Física" />
                                <label for = "fis_alt">FÍSICA</label>
                                <input type = "radio" name = "oqs" id = "jur_alt" value = "Jurídica" />
                                <label for = "jur_alt">JURÍDICA</label>
                            </div>

                            <div id = "continuacao"></div>
                        </form>
                        <div id = "msn2"></div>
                    </div>

                    <div class = "modal-footer border-primary">
                        <button type = "button" name = "OK" class = "btn btn-primary" id = "OK">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </body> <!-- abriu no menu -->
</html> <!-- abriu no menu -->