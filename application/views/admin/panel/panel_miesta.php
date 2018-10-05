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
                            <th>Štát</th>
                            <th>Okres</th>
                            <th>Miesto</th>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($zaujmy)){
                                if(!empty($zaujmy)){
                                    foreach ($zaujmy as $zaujem) {
                                        echo "<tr>";
                                        echo "<td>".$zaujem['stat']."</td>";
                                        echo "<td>".$zaujem['okres']."</td>";
                                        echo "<td>".$zaujem['miesto']."</td>";
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