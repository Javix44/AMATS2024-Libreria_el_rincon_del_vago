<style>
    /* Codigo Para evitar que el Nombre se salga del espacio disponible */
    .profile-name h5 {
        white-space: normal;
        word-wrap: break-word;
        overflow-wrap: break-word;
        max-width: 150px;
    }
</style>
<!-- menu izquierdo -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="index"><img src="<?php echo URL ?>resources/img/logo_principal.jpg" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle" src="<?php echo URL ?>resources/img/ic_cajero.png" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <!-- Agregue los Datos del Usuario que Inicia Sesión -->
                        <?php
                        $UsuarioController = new UsuarioController();
                        $_SESSION["Nombre"] = $nombreUsuario = $UsuarioController->ObtenerNombre($_SESSION["login"]);
                        $nivelUsuario = $_SESSION["nivel"];
                        ?>
                        <h5 class='mb-0 font-weight-normal' style="white-space: normal; word-wrap: break-word;"><?= $nombreUsuario ?></h5> <!-- Mostrar el nombre del usuario -->
                        <span>
                            <?= $nivelUsuario; ?> <!-- Mostrar el rol del usuario -->
                        </span>
                    </div>

                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Bienvenido</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-icon">
                    <i class="mdi mdi-cash-register"></i>
                </span>
                <span class="menu-title">Ventas</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="agregarventa">Registrar una Venta</a></li>
                    <li class="nav-item"> <a class="nav-link" href="listaventa">Ventas Realizadas</a></li>

                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#Ingresos" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-icon">
                    <i class="mdi mdi-package-variant-closed"></i>
                </span>
                <span class="menu-title">Ingresos</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="Ingresos">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="ingresoproducto">Registrar Ingresos</a></li>
                    <li class="nav-item"> <a class="nav-link" href="listaingresos">Ver Registro</a></li>
                </ul>
            </div>
        </li>
        <!--Menu de productos-->
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-icon">
                    <i class="mdi mdi-package-variant-closed"></i>
                </span>
                <span class="menu-title">Productos</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic2">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="agregarproducto">Agregar Productos</a></li>
                    <li class="nav-item"> <a class="nav-link" href="stock">Ver Stock</a></li>

                </ul>
            </div>
        </li>

        <!--Menu de Reportes-->
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-icon">
                    <i class="mdi mdi-chart-line"></i>
                </span>
                <span class="menu-title">Reportes</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic3">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="ReporteVe">Reporte de Ventas</a></li>
                    <li class="nav-item"> <a class="nav-link" href="ReportePro">Movimiento de Productos</a></li>

                </ul>
            </div>
        </li>
</nav>