<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Miesta</h4>
                                <p class="category">Zoznam miest udalostí</p>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="zaujmy-miesta">Štát</th>
                                    <th class="zaujmy-miesta">Okres</th>
                                    <th class="zaujmy-miesta">Mesto</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($miesta)){
                                if(!empty($miesta)){
                                    foreach ($miesta as $miesto) {
                                        echo "<tr class='zaujmy-miesta'>";
                                            echo "<td>".$miesto['stat']."</td>";
                                            echo "<td>".$miesto['okres']."</td>";
                                            echo "<td>".$miesto['mesto']."</td>";
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