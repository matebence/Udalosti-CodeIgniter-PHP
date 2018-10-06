<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Cenník</h4>
                                <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target='#novy-cennik'><i
                                        class="fa fa-plus-circle"></i><span>Nový cenník</span></a>
                                <p class="category">Zoznam cien</p>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Váha</th>
                                    <th>Suma</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($zoznam_cien)){
                                if(!empty($zoznam_cien)){
                                    foreach ($zoznam_cien as $cennik) {
                                        echo "<tr>";
                                        echo "<td>".$cennik['idCennik']."</td>";
                                        echo "<td>".$cennik['vaha']."</td>";
                                        echo "<td>".$cennik['suma']. " €</td>";
                                        echo "<td class='cennik-operacie'>
                                                    <i class='".$cennik['idCennik']." fa fa-edit editovat' data-toggle='modal' data-target='#aktualizovat-cennik'></i>
                                                    <i class='".$cennik['idCennik']." fa fa-trash odstranit' data-toggle='modal' data-target='#odstranit-cennik'></i>
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