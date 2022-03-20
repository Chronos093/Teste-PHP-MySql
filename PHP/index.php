<?PHP
    include('connect.php');

    if (empty($_GET['ord'])) { 
        $sql_ord = ";"; 
    } else {
        $ord = $_GET['ord'];
        switch ($ord) {
            case "nome":
                $sql_ord = "ORDER BY produtos.NOME ASC;";
                break;
            case "cor":
                $sql_ord = "ORDER BY produtos.COR ASC;";
                break;
            case "preco":
                $sql_ord = "ORDER BY preco.PRECO ASC;";
                break;
            }     
        }
    $sql_list_all = "SELECT produtos.IDPROD, produtos.NOME, produtos.COR, preco.PRECO FROM produtos INNER JOIN preco on produtos.IDPRECO = preco. IDPRECO $sql_ord";
    $query_list_all = mysqli_query($con, $sql_list_all);

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Teste PHP/MySql</title>
  </head>
  <body>
    <div class="container p-5 my-5 border">
      <h4 class="display-4"><a href="index.php" style="text-decoration: none; color:black;">Controle de Estoque</a></h4>
      <div class="container p-3 border">
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalNovo"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Novo</button>
      </div>
      <div class="container p-5 border">
      <div class="table-responsive-sm">
        <table class="table table-hover table-bordered rounded-top">
          <thead>
            <tr class="table-secondary">
                <th>ID</th>
                <th><a href="index.php?ord=nome" style="text-decoration:none; color:black;">Nome Produto</a></th>
                <th><a href="index.php?ord=cor" style="text-decoration:none; color:black;">Cor</a></th>
                <th><a href="index.php?ord=preco" style="text-decoration:none; color:black;">Preço</a></th>
                <th>Com Desconto</th>
                <th></th>
            </tr>
          </thead>           
            <?PHP
                if (mysqli_num_rows($query_list_all) > 0) {
                    // SAÍDA DOS DADOS DO BANCO 
                    while ($linha = mysqli_fetch_assoc($query_list_all)){  
                        $cor = $linha["COR"];
                        if ($cor == "AMARELO") {
                            $cor = $linha["COR"];
                            $off = "10% OFF";
                            $preco = $linha["PRECO"];
                            $offValor = 20 * $preco / 100;
                            $precoCdesconto = number_format($preco - $offValor, 2, '.', '');  
                        } elseif ($cor == "VERMELHO" && $linha["PRECO"] > "50.00") {
                            $cor = $linha["COR"];
                            $off = "5% OFF";
                            $preco = $linha["PRECO"];
                            $offValor = 20 * $preco / 100;
                            $precoCdesconto = number_format($preco - $offValor, 2, '.', ''); 
                        }  elseif ($cor == "VERMELHO" || $cor == "AZUL") {
                            $cor = $linha["COR"];
                            $off = "20% OFF";
                            $preco = $linha["PRECO"];
                            $offValor = 20 * $preco / 100;
                            $precoCdesconto = number_format($preco - $offValor, 2, '.', '');
                        }else {
                            $cor = $linha["COR"];
                            $off = "Não Aplicável.";
                            $precoCdesconto = "0.00";
                        }  
            ?>
            <tbody>
            <tr class="table-bordered">
                <th><?PHP echo $linha["IDPROD"]; ?></th>
                <th><?PHP echo $linha["NOME"]; ?></th>
                <th><?PHP echo $cor; ?></th>
                <th><?PHP echo "R$ " . $linha["PRECO"]; ?></th>
                <th data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="<?PHP  echo $off; ?>"><?PHP echo "R$ " . $precoCdesconto ?></th>
                <th>
                  <a class="btn btn-secondary" data-bs-toggle="modal" onclick="setaDadosModalEditar('<?PHP echo $linha['IDPROD']?>')" data-bs-target="#modalEditar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                  <a class="btn btn-danger" data-bs-toggle="modal" onclick="setaDadosModalExcluir('<?PHP echo $linha['IDPROD']?>')" data-bs-target="#modalExluir"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </th>
            </tr>
          </tbody>
            <?PHP 
                    }
                } else {
                    echo "0 Resultados da consulta.";
                }
            ?>
          </table>
        </div>
      </div>
        <!-- MODAL NOVO -->
        <div class="modal" id="modalNovo">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="query_novo.php" class="was-validated">
                <!-- MODAL TOPO -->
                <div class="modal-header">
                  <h4 class="modal-title">Novo Produto </h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- MODAL CORPO -->
                <div class="modal-body">
                  <div class="form-control">
                    <div class="mb-3 mt-3">
                      <label for="nome_prod" class="form-label">Nome do Produto:</label>
                      <input type="text" class="form-control text-uppercase" id="nome_prod" placeholder="Nome do Produto" name="nome_prod" required>
                    </div>
                    <div class="mb-3 mt-3">
                      <label for="cor_prod" class="form-label">Cor:</label>
                      <input type="text" class="form-control text-uppercase" id="cor_prod" placeholder="COR" name="cor_prod" required>
                    </div>
                    <div class="mb-3 mt-3">
                      <label for="preco_prod" class="form-label">Preço:</label>
                      <input type="text" class="form-control text-uppercase" id="preco_prod" placeholder="Preço" name="preco_prod" required>
                      <p><small>* Utilize o ponto '.' no lugar da vírgula ',' para separar as casas decimais do preço.</small></p>
                    </div>
                  </div>
                </div>

                <!-- MODAL ROTAPE -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <input type="submit" class="btn btn-danger" value="Enviar"></input>
                </div>
             </form>
            </div>
          </div>
        </div>
        <!-- MODAL EDITAR -->
        <div class="modal" id="modalEditar">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="query_editar.php" class="was-validated">
                <!-- MODAL TOPO -->
                <div class="modal-header">
                  <h4 class="modal-title">Editando Produto</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- MODAL CORPO -->
                <div class="modal-body">
                  <div class="p-3">
                    <label class="float-left" for="idEditar">ID:</label>
                    <input id="idEditar" name="idEditar" readonly></input>
                  </div>
                  <div class="form-control">
                    <div class="mb-3 mt-3">
                      <label for="nome_prod" class="form-label">Nome do Produto:</label>
                      <input type="text" class="form-control text-uppercase" id="nome_prod" placeholder="Nome do Produto" name="nome_prod" required>
                    </div>
                    <div class="mb-3 mt-3">
                      <label for="preco_prod" class="form-label">Preço:</label>
                      <input type="text" class="form-control text-uppercase" id="preco_prod" placeholder="Preço" name="preco_prod" required>
                      <p><small>* Utilize o ponto '.' no lugar da vírgula ',' para separar as casas decimais do preço.</small></p>
                    </div>
                  </div>
                </div>

                <!-- MODAL ROTAPE -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <input type="submit" class="btn btn-danger" value="Enviar"></input>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- MODAL EXLUIR -->
        <div class="modal" id="modalExluir">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="query_excluir.php">
                <!-- MODAL TOPO -->
                <div class="modal-header">
                  <h4 class="modal-title">Exluir Produto</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- MODAL CORPO -->
                <div class="modal-body">
                  Tem certeza que deseja <b>EXCLUIR</b> este item ?
                </br>
                  <label for="idExcluir" class="">ID do Produto: </label>
                  <input type="text" class="" id="idExcluir" name="idExcluir" style="padding: 5px;" readonly></input>
                </div>

                <!-- MODAL ROTAPE -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <input type="submit" class="btn btn-danger" value="EXCLUIR"></input>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
    <script type="text/javascript">
        // PASSAR ID PARA MODAL
        function setaDadosModalExcluir(valor) {
            document.getElementById('idExcluir').value = valor;
            }
        function setaDadosModalEditar(valor) {
            document.getElementById('idEditar').value = valor;
            }
    </script>
  </body>
</html>