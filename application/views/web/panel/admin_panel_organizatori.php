<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Organizátori</h4>
                                <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target='#novy-pouzivatel_admin'><i
                                            class="fa fa-plus-circle"></i><span>Nový organizátor</span></a>
                                <p class="category">Zoznam nepotvrdených organizátorov</p>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Meno</th>
                                <th>Heslo</th>
                                <th>Vytvorený</th>
                                <th>Akceptovať</th>
                                <th>Blokovať</th>
                                <th>Odstrániť</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($nepotvrdene_organizatori)){
                                if(!empty($nepotvrdene_organizatori)){
                                    foreach ($nepotvrdene_organizatori as $organizator) {
                                        echo "<tr>";
                                            echo "<td>".$organizator['idPouzivatel']."</td>";
                                            echo "<td>".$organizator['email']."</td>";
                                            echo "<td>".$organizator['meno']."</td>";
                                            echo "<td>".$organizator['heslo']."</td>";
                                            echo "<td>".$organizator['timestamp']."</td>";
                                            echo "<td><i class='".$organizator['idPouzivatel']." fa fa-check-circle akceptovat' data-toggle='modal' data-target='#akceptovat-pouzivatel_admin'></i></td>";
                                            echo "<td><i class='".$organizator['idPouzivatel']." fa fa-minus-circle blokovat' data-toggle='modal' data-target='#blokovat-pouzivatel_admin'></i></td>";
                                            echo "<td><i class='".$organizator['idPouzivatel']." fa fa-trash odstranit' data-toggle='modal' data-target='#odstranit-pouzivatel_admin'></i></i></td>";
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

            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Organizátori</h4>
                                <p class="category">Zoznam organizátorov aplikácie Udalosti</p>
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
                                <th>Vytvorený</th>
                                <th>Akceptovať</th>
                                <th>Blokovať</th>
                                <th>Editovať</th>
                                <th>Odstrániť</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($zoznam_organizatorov)){
                                if(!empty($zoznam_organizatorov)){
                                    foreach ($zoznam_organizatorov as $organizator) {
                                        echo "<tr>";
                                            echo "<td>".$organizator['idPouzivatel']."</td>";
                                            echo "<td>".$organizator['email']."</td>";
                                            echo "<td>".$organizator['meno']."</td>";
                                            echo "<td>".$organizator['heslo']."</td>";
                                            echo "<td>".$organizator['timestamp']."</td>";
                                            echo "<td><i class='".$organizator['idPouzivatel']." fa fa-check-circle akceptovat' data-toggle='modal' data-target='#akceptovat-pouzivatel_admin'></i></td>";
                                            echo "<td><i class='".$organizator['idPouzivatel']." fa fa-minus-circle blokovat' data-toggle='modal' data-target='#blokovat-pouzivatel_admin'></i></td>";
                                            echo "<td><i class='".$organizator['idPouzivatel']." fa fa-edit editovat' data-toggle='modal' data-target='#aktualizovat-pouzivatel_admin'></i></i></td>";
                                            echo "<td><i class='".$organizator['idPouzivatel']." fa fa-trash odstranit' data-toggle='modal' data-target='#odstranit-pouzivatel_admin'></i></i></td>";
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

            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Organizátori</h4>
                                <p class="category">Zoznam odmietnutých organizátorov</p>
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
                                <th>Vytvorený</th>
                                <th>Akceptovať</th>
                                <th>Odstrániť</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($odmietnute_organizatori)){
                                if(!empty($odmietnute_organizatori)){
                                    foreach ($odmietnute_organizatori as $organizator) {
                                        echo "<tr>";
                                            echo "<td>".$organizator['idPouzivatel']."</td>";
                                            echo "<td>".$organizator['email']."</td>";
                                            echo "<td>".$organizator['meno']."</td>";
                                            echo "<td>".$organizator['heslo']."</td>";
                                            echo "<td>".$organizator['timestamp']."</td>";
                                            echo "<td><i class='".$organizator['idPouzivatel']." fa fa-check-circle akceptovat' data-toggle='modal' data-target='#akceptovat-pouzivatel_admin'></i></td>";
                                            echo "<td><i class='".$organizator['idPouzivatel']." fa fa-trash odstranit' data-toggle='modal' data-target='#odstranit-pouzivatel_admin'></i></i></td>";
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