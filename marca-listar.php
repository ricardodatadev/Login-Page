<h1>Frotas Cadastradas</h1>
<?php
    $sql = "SELECT * FROM equipamentos";
    $res = $conn->query($sql);
    $qtd = $res->num_rows;
    
    if($qtd > 0){
        print "<p>Encontrou <b>$qtd</b> resultado(s).</p>";
        print "<table class='table table-bordered table-striped table-hover'>";
         print "<tr>";
            print "<th>Número da Frota</th>";
            print "<th>Marca</th>";
            print "<th>Modelo</th>";
            print "<th>Placa</th>";
            print "<th>Data de Aquisição</th>";
            print "<th>Ações";
            print "</tr>";
        while($row = $res->fetch_object()){
            print "<tr>";
            print "<td>". $row->frota."</td>";
            print "<td>". $row->marca."</td>";
            print "<td>". $row->modelo."</td>";
            print "<td>". $row->placa."</td>";
            print "<td>". $row->data_aquisicao."</td>";
            print "<td>
                     <button class='btn btn-primary'>Editar</button>
                     <button class='btn btn-danger'>Excluir</button>
                   </td>";
            print "</tr>";
        }
        
    }else{
        print "Não encontrou resultado";
    }
    