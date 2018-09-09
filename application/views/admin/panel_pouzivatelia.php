<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Používatelia</h4>
                        <p class="category">Zoznam všetkých použivatelov</p>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Meno</th>
                            <th>Heslo</th>
                            <th>Token</th>
                            <th>Vytvorený</th>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($vsetky_pouzivatelia)){
                                if(!empty($vsetky_pouzivatelia)){
                                    foreach ($vsetky_pouzivatelia as $pouzivatel) {
                                        echo "<tr>";
                                        echo "<td>".$pouzivatel['idPouzivatel']."</td>";
                                        echo "<td>".$pouzivatel['email']."</td>";
                                        echo "<td>".$pouzivatel['meno']."</td>";
                                        echo "<td>".$pouzivatel['heslo']."</td>";
                                        echo "<td>".$pouzivatel['token']."</td>";
                                        echo "<td>".$pouzivatel['timestamp']."</td>";
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