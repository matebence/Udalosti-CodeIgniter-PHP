<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Administrátori</h4>
                                <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target='#novy-pouzivatel'><i
                                        class="fa fa-plus-circle"></i><span>Nový administrátor</span></a>
                                <p class="category">Zoznam správcov aplikácie Udalosti</p>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Meno</th>
                            <th>Heslo</th>
                            <th>Vytvorený</th>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($zoznam_administratorov)){
                                if(!empty($zoznam_administratorov)){
                                    foreach ($zoznam_administratorov as $admin) {
                                        echo "<tr>";
                                        echo "<td>".$admin['idPouzivatel']."</td>";
                                        echo "<td>".$admin['email']."</td>";
                                        echo "<td>".$admin['meno']."</td>";
                                        echo "<td>".$admin['heslo']."</td>";
                                        echo "<td>".$admin['timestamp']."</td>";
                                        echo "<td>
                                                    <i class='fa fa-edit editovat' id='".$admin['idPouzivatel']."' data-toggle='modal' data-target='#aktualizovat-admina'></i>
                                                    <i class='fa fa-trash odstranit' id='".$admin['idPouzivatel']."' data-toggle='modal' data-target='#odstranit-admina'></i>
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