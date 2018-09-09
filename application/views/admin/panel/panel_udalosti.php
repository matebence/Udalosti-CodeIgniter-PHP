<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Udalosti</h4>
                                <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target='#nova-udalost'><i
                                        class="fa fa-plus-circle"></i><span>Nová udalosť</span></a>
                                <p class="category">Zoznam aktuálnych udalostí</p>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>ID</th>
                            <th>Cenník</th>
                            <th>Obrázok</th>
                            <th>Názov</th>
                            <th>Dátum</th>
                            <th>Čas</th>
                            <th>Miesto</th>
                            <th>Štát</th>
                            <th>Okres</th>
                            <th>Mesto</th>
                            <th>Vytvorený</th>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($vsetky_udalosti)) {
                                if (!empty($vsetky_udalosti)) {
                                    foreach ($vsetky_udalosti as $udalost) {
                                        echo "<tr>";
                                            echo "<td>" . $udalost['idUdalost'] . "</td>";
                                            echo "<td>" . $udalost['idCennik'] . "</td>";
                                            echo "<td>" . $udalost['obrazok'] . "</td>";
                                            echo "<td>" . $udalost['nazov'] . "</td>";
                                            echo "<td>" . $udalost['datum'] . "</td>";
                                            echo "<td>" . $udalost['cas'] . "</td>";
                                            echo "<td>" . $udalost['miesto'] . "</td>";
                                            echo "<td>" . $udalost['stat'] . "</td>";
                                            echo "<td>" . $udalost['okres'] . "</td>";
                                            echo "<td>" . $udalost['mesto'] . "</td>";
                                            echo "<td>" . $udalost['timestamp'] . "</td>";
                                            echo "<td>
                                                    <i class='fa fa-edit' id='editovat'></i>
                                                    <i class='fa fa-trash' id='odstranit'></i>
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