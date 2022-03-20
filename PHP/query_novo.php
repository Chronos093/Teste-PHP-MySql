<?PHP
    include('connect.php');

    $nome = $_POST['nome_prod'];
    $cor = $_POST['cor_prod'];
    $preco = $_POST['preco_prod'];
    // TRANSFORMA A STRING PARA UPPER CASE
    $nome = strtoupper($nome);
    $cor = strtoupper($cor);

    //echo "Nome: " . $nome . ", Cor: " . $cor . ", Preço: " . $preco;

    $sql_produtos = "INSERT INTO produtos (NOME, COR) VALUES ('$nome', '$cor');";
    mysqli_query($con, $sql_produtos);
    // RECUPERA A ID DO PRODUTO NO BANCO PARA GRAVAR COM O PRECO
    $sql_id_produt = "SELECT produtos.IDPROD FROM produtos WHERE produtos.NOME = '$nome' AND produtos.COR = '$cor';";
    $query_id_produt = mysqli_query($con, $sql_id_produt);
    $linha = mysqli_fetch_assoc($query_id_produt);
    $id = $linha['IDPROD'];
    // ATUALIZA O VALOR DE IDPRECO NA TABELA PRODUTOS
    $sql_update_idPreco = "UPDATE produtos SET IDPRECO = '$id' WHERE IDPROD = '$id';";
    mysqli_query($con, $sql_update_idPreco);
    // GRAVA O MESMO IDPRECO DA TABELA PRODUTOS PARA A TABELA PRECO, JUNTO COMO VALOR 
    $sql_preco = "INSERT INTO preco (IDPRECO, PRECO) VALUES ('$id', '$preco');";
    mysqli_query($con, $sql_preco);

    header('Location: index.php');
?>