        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Počet používatelov</span>
                                <span id="pocet-pouzivatelov" class="info-box-number"><?php if(isset($pocet_pouzivatelov)){echo $pocet_pouzivatelov;}else{ echo "Údaj je neprístupný";}?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-calendar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Počet udalostí</span>
                                <span id="pocet-udalosti" class="info-box-number"><?php if(isset($pocet_udalosti)){echo $pocet_udalosti;}else{ echo "Údaj je neprístupný";}?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-unlock-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Registrovali dnes</span>
                                <span id="registrovali-dnes" class="info-box-number"><?php if(isset($registrovali_dnes)){echo $registrovali_dnes;}else{ echo "Údaj je neprístupný";}?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">

                            <div class="header">
                                <h4 class="title">Cenník</h4>
                                <p class="category">Počet udalostí podľa cenníka</p>
                            </div>
                            <div class="content grafUdalosti">
                                <div id="kolacovyGraf" class="ct-chart ct-perfect-fourth"></div>

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Váha 1
                                        <i class="fa fa-circle text-danger"></i> Váha 2
                                        <i class="fa fa-circle text-warning"></i> Váha 3
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Aktualizované práve teraz
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Udalosti</h4>
                                <p class="category">Počet udalostí v danom mesiaci</p>
                            </div>
                            <div class="content grafUdalosti">
                                <div id="ciarovyGraf" class="ct-chart"></div>
                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Udalosti
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Aktualizované práve teraz
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">Udalosti</h4>
                                <p class="category">Podľa Okresu</p>
                            </div>
                            <div class="content grafUdalosti">
                                <div id="stlpcovyGrafOkres" class="ct-chart"></div>
                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Udalosti
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Aktualizované práve teraz
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">Udalosti</h4>
                                <p class="category">Podľa Štátov</p>
                            </div>
                            <div class="content grafUdalosti">
                                <div id="stlpcovyGrafStat" class="ct-chart"></div>

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Udalosti
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Aktualizované práve teraz
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url() . "assets/js/"; ?>graf.js"></script>