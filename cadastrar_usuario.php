<?php 
    include("menu.php");
    echo '<script>var oqe = "' . $_GET["fis_jur"] . '";</script>';
?>
    
        <script>
            var vetor_cpf = 0;
            var vetor_cnpj = 0;
            $(document).ready(function(){
                $("#cep").focusout(function(){
                    $.ajax({
                        url: 'https://viacep.com.br/ws/'+$(this).val()+'/json/unicode/',
                        dataType: 'json',
                        success: function(resposta){
                            $("#log").val(resposta.logradouro);
                            $("#bairro").val(resposta.bairro);
                            $("#cid").val(resposta.localidade);
                            $("#estado").val(resposta.uf);
                            $("#num").focus();
                        }
                    });
                });

                $("#cnpj").focusout(function(){
                    cnpj = $("#cnpj").val();
                    vetor_cnpj = Array.from(cnpj);

                    digit1 = validar_cnpj(5, 4, 9, 12);
                    digit2 = validar_cnpj(6, 5, 9, 13);

                    if((vetor_cnpj[12] == digit1) && (vetor_cnpj[13] == digit2)){
                        if(cnpj.length == 14) {
            
                            // Aqui rodamos o ajax para a url da API concatenando o número do CNPJ na url
                            $.ajax({
                                url:'https://www.receitaws.com.br/v1/cnpj/' + cnpj,
                                method:'GET',
                                dataType: 'jsonp', // Em requisições AJAX para outro domínio é necessário usar o formato "jsonp" que é o único aceito pelos navegadores por questão de segurança
                                complete: function(xhr){
                                
                                    // Aqui recuperamos o json retornado
                                    response = xhr.responseJSON;
                                    
                                    // Na documentação desta API tem esse campo status que retorna "OK" caso a consulta tenha sido efetuada com sucesso
                                    if(response.status == 'OK') {
                                    
                                        // Agora preenchemos os campos com os valores retornados
                                        $('#razao_social').val(response.nome);
                                        $('#nome_fant').val(response.fantasia);
                                        $("#nome_repre").focus();
                                    
                                    // Aqui exibimos uma mensagem caso tenha ocorrido algum erro
                                    } else {
                                        alert(response.message); // Neste caso estamos imprimindo a mensagem que a própria API retorna
                                    }
                                }
                            });
                        }
                    }else{
                        alert("Digite um CNPJ válido!!!");
                        $("#cnpj").val("");

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

            function deixar_bonitinho(oq){
                if((oq == "cpf") || (oq == "cpf_repre")){
                    valor_cpf = $("#" + oq).val();
                    vetor_cpf = Array.from(valor_cpf);
                    
                    dig1 = validar_cpf(10, 9);
                    dig2 = validar_cpf(11, 10);

                    if((vetor_cpf[9] == dig1) && (vetor_cpf[10] == dig2)){
                        $("#" + oq).attr("type", "text");
                        if(valor_cpf.length == 11){
                            resultado = valor_cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
                            $("#" + oq).val(resultado);
                        }
                    }else{
                        alert("Digite um CPF válido!!!");
                        $("#" + oq).val("");
                    }
                }else if(oq == "tel"){
                    valor_tel = $("#tel").val();
                    $("#tel").attr("type", "text");

                    if(valor_tel.length == 8){
                        resultado = valor_tel.replace(/(\d{4})(\d{4})/, "$1-$2");
                        $("#tel").val(resultado);
                    }else if(valor_tel.length == 10){
                        resultado = valor_tel.replace(/(\d{2})(\d{4})(\d{4})/, "($1)$2-$3");
                        $("#tel").val(resultado);
                    }
                }else{
                    valor_cel = $("#cel").val();
                    $("#cel").attr("type", "text");

                    if(valor_cel.length == 9){
                        resultado = valor_cel.replace(/(\d{5})(\d{4})/, "$1-$2");
                        $("#cel").val(resultado);
                    }else if(valor_cel.length == 11){
                        resultado = valor_cel.replace(/(\d{2})(\d{5})(\d{4})/, "($1)$2-$3");
                        $("#cel").val(resultado);
                    }
                }
            }

            function validar_cpf(d, qtd){
                soma = 0;
                desc_mult = d;

                for(i = 0; i < qtd; i++){
                    soma += vetor_cpf[i] * desc_mult;
                    desc_mult--;
                }

                if((11 - (soma%11)) > 9){
                    dig = 0;
                }else{
                    dig = (11 - (soma%11));
                }

                return dig;
            }

            function validar_cnpj(desc_s1, qtd1, desc_s2, qtdf){
                soma = 0;
                desc = desc_s1;

                for(i = 0; i < qtd1; i++){
                    soma += vetor_cnpj[i] * desc;
                    desc--;
                }

                desc2 = desc_s2;
                for(i = qtd1; i < qtdf; i++){
                    soma += vetor_cnpj[i] * desc2;
                    desc2--;
                }

                if((soma%11) < 2){
                    digi = 0;
                }else{
                    digi = (11 - (soma%11));
                }

                return digi;
            }
        </script>
        
        <div style = "margin-top:50px;" class = "container-fluid">
            <div class = "row">
                <div class = "col-md-1 col-sm-12 col-xs-12"></div>
                
                <div class = "col-md-10 col-sm-12 col-xs-12">
                    <div class = "card text-light bg-dark">
                        <div class = "card-header"><h3>Cadastro de Pessoa <script>document.write(oqe)</script></h3></div>

                        <div class = "card-body">
                            <form class = "needs-validation" novalidate>
                                <div class = "form-row">
                                    <?php if($_GET["fis_jur"] == "Jurídica"){ ?>

                                    <div class = "form-group col-md-6">
                                        <label class = "form-control-placeholder" for = "cnpj">CNPJ <small>(Apenas Números)</small></label>
                                        <input type = "number" class = "form-control" id = "cnpj" required />
                                    </div>

                                    <div class = "form-group col-md-6">
                                        <label class = "form-control-placeholder" for = "nome_fant">Nome Fantasia</label>
                                        <input type = "text" class = "form-control" style = "text-transform: uppercase" id = "nome_fant" required />
                                    </div>                                  

                                    <div class = "form-group col-md-6">
                                        <label class = "form-control-placeholder" for = "razao_social">Razão Social</label>
                                        <input type = "text" class = "form-control" style = "text-transform: uppercase" id = "razao_social" required />
                                    </div>

                                    <div class = "form-group col-md-6">
                                        <label class = "form-control-placeholder" for = "nome_repre">Nome Representante</label>
                                        <input type = "text" class = "form-control" style = "text-transform: uppercase" id = "nome_repre" required />
                                    </div>    

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "cpf_repre">CPF Representante <small>(Apenas Números)</small></label>
                                        <input type = "number" step = "1" class = "form-control" id = "cpf_repre" onblur = "deixar_bonitinho(this.id)" required />
                                    </div>

                                    <?php }else{ ?>

                                    <div class = "form-group col-md-6">
                                        <label class = "form-control-placeholder" for = "cpf">CPF <small>(Apenas Números)</small></label>
                                        <input type = "number" step = "1" class = "form-control" id = "cpf" onblur = "deixar_bonitinho(this.id)" required />
                                    </div>

                                    <div class = "form-group col-md-6">
                                        <label class = "form-control-placeholder" for = "nome">Nome</label>
                                        <input type = "text" class = "form-control" id = "nome" required  style = "text-transform: uppercase" />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "cel">Celular <small>(Apenas Números)</small></label>
                                        <input type = "number" step = "1" class = "form-control" id = "cel" onblur = "deixar_bonitinho(this.id)" required />
                                    </div>
                                    
                                    <?php } ?>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "tel">Telefone <small>(Apenas Números)</small></label>
                                        <input type = "number" step = "1" class = "form-control" id = "tel" onblur = "deixar_bonitinho(this.id)" required />
                                    </div>

                                    <div class = "form-group col-md-6">
                                        <label class = "form-control-placeholder" for = "email">E-mail</label>
                                        <input type = "email" class = "form-control" style = "text-transform: uppercase" id = "email" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "cep">CEP <small>(Apenas Números)</small></label>
                                        <input type = "number" class = "form-control" id = "cep" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "bairro">Bairro</label>
                                        <input type = "text" class = "form-control" style = "text-transform: uppercase" id = "bairro" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "cid">Cidade</label>
                                        <input type = "text" class = "form-control" style = "text-transform: uppercase" id = "cid" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "estado">Estado</label>
                                        <select class = "form-control" id = "estado" required>
                                            <option value = "" selected disabled>ESCOLHA UMA OPÇÃO</option>
                                            <option value = "AC">ACRE</option>
                                            <option value = "AL">ALAGOAS</option>
                                            <option value = "AP">AMAPÁ</option>
                                            <option value = "AM">AMAZONAS</option>
                                            <option value = "BA">BAHIA</option>
                                            <option value = "CE">CEARÁ</option>
                                            <option value = "DF">DISTRITO FEDERAL</option>
                                            <option value = "ES">ESPÍRITO SANTO</option>
                                            <option value = "GO">GOIÁS</option>
                                            <option value = "MA">MARANHÃO</option>
                                            <option value = "MT">MATO GROSSO</option>
                                            <option value = "MS">MATO GROSSO DO SUL</option>
                                            <option value = "MG">MINAS GERAIS</option>
                                            <option value = "PA">PARÁ</option>
                                            <option value = "PB">PARAÍBA</option>
                                            <option value = "PR">PARANÁ</option>
                                            <option value = "PE">PERNAMBUCO</option>
                                            <option value = "PI">PIAUÍ</option>
                                            <option value = "RJ">RIO DE JANEIRO</option>
                                            <option value = "RN">RIO GRANDE DO NORTE</option>
                                            <option value = "RS">RIO GRANDE DO SUL</option>
                                            <option value = "RO">RONDÔNIA</option>
                                            <option value = "RR">RORAIMA</option>
                                            <option value = "SC">SANTA CATARINA</option>
                                            <option value = "SP">SÃO PAULO</option>
                                            <option value = "SE">SERGIPE</option>
                                            <option value = "TO">TOCANTINS</option>
                                        </select>
                                    </div>

                                    <div class = "form-group col-md-5">
                                        <label class = "form-control-placeholder" for = "log">Logradouro</label>
                                        <input type = "text" class = "form-control" style = "text-transform: uppercase" id = "log" required />
                                    </div>

                                    <div class = "form-group col-md-1">
                                        <label class = "form-control-placeholder" for = "num">Número</label>
                                        <input type = "number" class = "form-control" id = "num" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "senha">Senha</label>
                                        <input type = "password" class = "form-control" id = "senha" required />
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "form-control-placeholder" for = "confirmar_senha">Confirmar Senha</label>
                                        <input type = "password" class = "form-control" id = "confirmar_senha" required />
                                    </div>

                                    <div id = "msn" class = "form-group col-md-6"></div>
                                
                                    <div class = "form-group col-md-3">
                                        <label class = "invisible">A</label>
                                        <a class = "btn btn-outline-primary btn-block btn-md" href = "login.php">Voltar ao Login</a>
                                    </div>

                                    <div class = "form-group col-md-3">
                                        <label class = "invisible">A</label>
                                        <input id = "salvar" class = "btn btn-success btn-block btn-md" type = "submit" value = "Cadastrar" />  
                                    </div>
                                </div>
                            </form> 
                        </div>
                    </div>     
                </div>
                <div class = "col-md-1 col-sm-12 col-xs-12"></div>
            </div>
        </div>
    </body> <!-- abriu no menu -->
</html> <!-- abriu no menu -->