<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title" style="display: inline;">Udalosti</h4>
                                <a href="#" class="btn btn-success pull-right" data-toggle="modal"><i
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
                                                <i class='fa fa-trash' id='odstranit' data-toggle='modal' data-target='#odstranenie-udalosti'></i></td>";
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
<!---->
<!--<div class="modal fade" id="odstranenie-udalosti" data-backdrop="false"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">-->
<!--    <div class="modal-dialog modal-dialog-centered" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title" id="exampleModalLongTitle">Odstránenie</h5>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                Naozaj chcete odstrániť udalosť ?-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-primary" data-dismiss="modal">Zrušiť</button>-->
<!--                <button type="button" class="btn btn-danger">Áno, odstrániť</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->

<div class="modal fade" id="odstranenie-udalosti" data-backdrop="false"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Odstránenie</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <form>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Company (disabled)</label>
                                                <input type="text" class="form-control" disabled placeholder="Company" value="Creative Code Inc.">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" placeholder="Username" value="michael23">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" placeholder="Company" value="Mike">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" placeholder="Last Name" value="Andrew">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" placeholder="Home Address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" placeholder="City" value="Mike">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" class="form-control" placeholder="Country" value="Andrew">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="number" class="form-control" placeholder="ZIP Code">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About Me</label>
                                                <textarea rows="5" class="form-control" placeholder="Here can be your description" value="Mike">Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Zrušiť</button>
                <button type="button" class="btn btn-danger">Áno, odstrániť</button>
            </div>
        </div>
    </div>
</div>