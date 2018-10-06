<body>
<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="<?php echo base_url() . "node_modules/unofficial-light-bootstrap-dashboard/"; ?>assets/img/sidebar-5.jpg">
        <div class="sidebar-wrapper">
            <div class="logo">
                <img id="obrazok" src="<?php echo base_url() . "assets/img/"; ?>udalosti_logo.png" alt="Udalosti logo" title="Udalosti logo">
                <a href="<?php echo site_url("panel"); ?>" class="simple-text">
                    Udalosti
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="<?php echo site_url("panel"); ?>">
                        <i class="pe-7s-graph"></i>
                        <p>Panel</p>
                    </a>
                    <hr>
                </li>
                <li>
                    <a href="<?php echo site_url("panel/udalosti"); ?>">
                        <i class="pe-7s-star"></i>
                        <p>Udalosti</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url("panel/pouzivatelia"); ?>">
                        <i class="pe-7s-user"></i>
                        <p>Používatelia</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url("panel/cennik"); ?>">
                        <i class="pe-7s-cash"></i>
                        <p>Cenník</p>
                    </a>
                    <hr>
                </li>
                <li>
                    <a href="<?php echo site_url("panel/zaujmy"); ?>">
                        <i class="pe-7s-like"></i>
                        <p>Záujmy používatelov</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url("panel/miesta"); ?>">
                        <i class="pe-7s-map-marker"></i>
                        <p>Miesta</p>
                    </a>
                    <hr>
                </li>
                <li>
                    <a href="<?php echo site_url("panel/lokalizacia"); ?>">
                        <i class="pe-7s-map-2"></i>
                        <p>Lokalizácia</p>
                    </a>
                    <hr>
                </li>
                <li>
                    <a href="<?php echo site_url("panel/administratori"); ?>">
                        <i class="pe-7s-key"></i>
                        <p>Administrátori</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url("panel"); ?>">Adminer</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#" id="nova_udalost" data-toggle='modal' data-target='#nova-udalost'>
                                <p>Pridať novú udalosť</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url("prihlasenie/pristup"); ?>">
                                <p>Odhlásiť sa</p>
                            </a>
                        </li>
                        <li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>