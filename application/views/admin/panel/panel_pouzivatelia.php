<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Používatelia</h4>
                                <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target='#novy-pouzivatel_admin'><i
                                        class="fa fa-plus-circle"></i><span>Nový používatel</span></a>
                                <p class="category">Zoznam všetkých použivatelov</p>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Meno</th>
                                    <th>Heslo</th>
                                    <th>Token</th>
                                    <th>Vytvorený</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($zoznam_pouzivatelov)){
                                if(!empty($zoznam_pouzivatelov)){
                                    foreach ($zoznam_pouzivatelov as $pouzivatel) {
                                        echo "<tr>";
                                        echo "<td>".$pouzivatel['idPouzivatel']."</td>";
                                        echo "<td>".$pouzivatel['email']."</td>";
                                        echo "<td>".$pouzivatel['meno']."</td>";
                                        echo "<td>".$pouzivatel['heslo']."</td>";
                                        echo "<td>".$pouzivatel['token']."</td>";
                                        echo "<td>".$pouzivatel['timestamp']."</td>";
                                        echo "<td>
                                                    <i class='".$pouzivatel['idPouzivatel']." fa fa-edit editovat' data-toggle='modal' data-target='#aktualizovat-pouzivatel_admin'></i>
                                                    <i class='".$pouzivatel['idPouzivatel']." fa fa-trash odstranit' data-toggle='modal' data-target='#odstranit-pouzivatel_admin'></i>
                                                  </td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>