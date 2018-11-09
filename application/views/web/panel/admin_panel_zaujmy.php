<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Záujmy</h4>
                                <p class="category">Zoznam záujmy používatelov</p>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="zaujmy-miesta">Udalost</th>
                                    <th class="zaujmy-miesta">Miesto</th>
                                    <th class="zaujmy-miesta">Dátum</th>
                                    <th class="zaujmy-miesta">Počet používatelov</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($zaujmy)){
                                if(!empty($zaujmy)){
                                    foreach ($zaujmy as $zaujem) {
                                        echo "<tr class='zaujmy-miesta'>";
                                        echo "<td>".$zaujem['nazov']."</td>";
                                        echo "<td>".$zaujem['mesto']."</td>";
                                        echo "<td>".$zaujem['datum']."</td>";
                                        echo "<td>".$zaujem['pocet']."</td>";
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