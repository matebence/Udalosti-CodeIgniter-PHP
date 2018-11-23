<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Používatelia</h4>
                                <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target='#novy-pouzivatel'><i
                                        class="fa fa-plus-circle"></i><span>Nový používatel</span></a>
                                <p class="category">Zoznam akceptovaných použivateľov</p>
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
                                    <th>Stav</th>
                                    <th>Token</th>
                                    <th>Vytvorený</th>
                                    <th>Blokovať</th>
                                    <th>Editovať</th>
                                    <th>Odstrániť</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($zoznam_akceptovanych_pouzivatelov)){
                                if(!empty($zoznam_akceptovanych_pouzivatelov)){
                                    foreach ($zoznam_akceptovanych_pouzivatelov as $pouzivatel) {
                                        echo "<tr>";
                                            echo "<td>".$pouzivatel['idPouzivatel']."</td>";
                                            echo "<td>".$pouzivatel['email']."</td>";
                                            echo "<td>".$pouzivatel['meno']."</td>";
                                            echo "<td>".$pouzivatel['heslo']."</td>";
                                            echo "<td>".$pouzivatel['stav']."</td>";
                                            echo "<td>".$pouzivatel['token']."</td>";
                                            echo "<td>".$pouzivatel['timestamp']."</td>";
                                            echo "<td><i class='".$pouzivatel['idPouzivatel']." fa fa-minus-circle blokovat' data-toggle='modal' data-target='#blokovat-pouzivatel'></i></td>";
                                            echo "<td><i class='".$pouzivatel['idPouzivatel']." fa fa-edit editovat' data-toggle='modal' data-target='#aktualizovat-pouzivatel'></i></td>";
                                            echo "<td><i class='".$pouzivatel['idPouzivatel']." fa fa-trash odstranit' data-toggle='modal' data-target='#odstranit-pouzivatel'></i></td>";
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

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Používatelia</h4>
                                <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target='#novy-pouzivatel'><i
                                            class="fa fa-plus-circle"></i><span>Nový používatel</span></a>
                                <p class="category">Zoznam blokovaných použivateľov</p>
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
                                <th>Stav</th>
                                <th>Token</th>
                                <th>Vytvorený</th>
                                <th>Akceptovať</th>
                                <th>Odstrániť</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($zoznam_blokovanych_pouzivatelov)){
                                if(!empty($zoznam_blokovanych_pouzivatelov)){
                                    foreach ($zoznam_blokovanych_pouzivatelov as $pouzivatel) {
                                        echo "<tr>";
                                        echo "<td>".$pouzivatel['idPouzivatel']."</td>";
                                        echo "<td>".$pouzivatel['email']."</td>";
                                        echo "<td>".$pouzivatel['meno']."</td>";
                                        echo "<td>".$pouzivatel['heslo']."</td>";
                                        echo "<td>".$pouzivatel['stav']."</td>";
                                        echo "<td>".$pouzivatel['token']."</td>";
                                        echo "<td>".$pouzivatel['timestamp']."</td>";
                                        echo "<td><i class='".$pouzivatel['idPouzivatel']." fa fa-check-circle akceptovat' data-toggle='modal' data-target='#akceptovat-pouzivatel'></i></td>";
                                        echo "<td><i class='".$pouzivatel['idPouzivatel']." fa fa-trash odstranit' data-toggle='modal' data-target='#odstranit-pouzivatel'></i></td>";
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