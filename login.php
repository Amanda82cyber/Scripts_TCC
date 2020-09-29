<?php include("menu.php"); ?>

        <script>
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
    </body> <!-- abriu no menu -->
</html> <!-- abriu no menu -->