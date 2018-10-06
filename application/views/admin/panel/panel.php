<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Počet používatelov</span>
                        <span id="pocet-pouzivatelov" class="info-box-number"><?php if (isset($pocet_pouzivatelov)) {
                                echo $pocet_pouzivatelov;
                            } else {
                                echo "Údaj je neprístupný";
                            } ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Počet udalostí</span>
                        <span id="pocet-udalosti" class="info-box-number"><?php if (isset($pocet_udalosti)) {
                                echo $pocet_udalosti;
                            } else {
                                echo "Údaj je neprístupný";
                            } ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-balance-scale"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Počet administrátorov</span>
                        <span id="pocet-administratorov" class="info-box-number"><?php if (isset($pocet_administratorov)) {
                                echo $pocet_administratorov;
                            } else {
                                echo "Údaj je neprístupný";
                            } ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-mobile" style="font-size: 55px"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Aplikáciu momentálne používajú</span>
                        <span id="aktivny-pouzivatelia" class="info-box-number"><?php if (isset($aktivny_pouzivatelia)) {
                                echo $aktivny_pouzivatelia;
                            } else {
                                echo "Údaj je neprístupný";
                            } ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-unlock-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Registrovali dnes</span>
                        <span id="registrovali-dnes" class="info-box-number"><?php if (isset($registrovali_dnes)) {
                                echo $registrovali_dnes;
                            } else {
                                echo "Údaj je neprístupný";
                            } ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">

                    <div class="header">
                        <h4 class="title">Cenník</h4>
                        <p class="category">Podla počtu cenníka</p>
                    </div>
                    <div class="content grafUdalosti">
                        <div id="kolacovyGraf" class="ct-chart ct-perfect-fourth"></div>

                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-history"></i> Aktualizované práve teraz
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card ">
                    <div class="header">
                        <h4 class="title">Záujmy</h4>
                        <p class="category">Podľa záujmu používatelov</p>
                    </div>
                    <div class="content grafUdalosti">
                        <div id="stlpcovyGrafZaujmy" class="ct-chart"></div>

                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-history"></i> Aktualizované práve teraz
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            $mesiac = array(
                "January"   => "Január",
                "February"  => "Február",
                "March"     => "Marec",
                "April"     => "April",
                "May"       => "Máj",
                "June"      => "Jún",
                "July"      => "Júl",
                "August"    => "August",
                "September" => "September",
                "October"   => "Október",
                "November"  => "November",
                "December"  => "December"
            );
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Mesiac - <?php echo $mesiac[date("F")]; ?></h4>
                        <p class="category">Počet udalostí v danom mesiaci</p>
                    </div>
                    <div class="content grafUdalosti">
                        <div id="ciarovyGraf" class="ct-chart"></div>
                        <div class="footer">
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
                        <h4 class="title">Okres</h4>
                        <p class="category">Počet udalostí podľa okresov</p>
                    </div>
                    <div class="content grafUdalosti">
                        <div id="stlpcovyGrafOkres" class="ct-chart"></div>
                        <div class="footer">
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
                        <h4 class="title">Štát</h4>
                        <p class="category">Počet udalostí podľa štátov</p>
                    </div>
                    <div class="content grafUdalosti">
                        <div id="stlpcovyGrafStat" class="ct-chart"></div>

                        <div class="footer">
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