<?php
	if(!(isset($_SESSION["nome"]))){
        echo '<div class = "container-fluid mt-2">
                <div class = "alert alert-danger" role = "alert">
                    <h4 class = "alert-heading">Você não está logado! <img src = "triste.png" /></h4>
                    <p>Para acessar essa página, por favor, faça o <a class = "text-danger" href = "login.php">LOGIN</a>!</p>
                </div>
              </div>';
		echo "</body></html>";
		die(); // die acaba com o algoritmo no ponto que foi colocado.
	}
?>