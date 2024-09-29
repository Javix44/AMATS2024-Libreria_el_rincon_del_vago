<!-- menu izquierdo -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="index.html"><img src="template/assets/images/logo.svg" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="index.html"><img src="template/assets/images/logo-mini.svg" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle " src="template/assets/images/faces/face15.jpg" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <!-- Agregue los Datos del Usuario que Inicia Sesión -->
                        <?php
                        $UsuarioController = new UsuarioController();
                        $_SESSION["Nombre"] = $nombreUsuario = $UsuarioController->ObtenerNombre($_SESSION["login"]);
                        $nivelUsuario = $_SESSION["nivel"];
                        ?>
                        <!-- Aquí se muestran los datos del usuario -->
                        <h5 class='mb-0 font-weight-normal'><?= $nombreUsuario ?></h5> <!-- Mostrar el nombre del usuario -->
                        <span>
                            <?= $nivelUsuario; ?> <!-- Mostrar el rol del usuario -->
                        </span>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Menu</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#usuarios" aria-expanded="false" aria-controls="usuarios">
                <span class="menu-icon">
                    <i class="mdi mdi-laptop"></i>
                </span>
                <span class="menu-title">Usuarios</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="usuarios">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="agregarusuario">Agregar</a></li>
                    <li class="nav-item"> <a class="nav-link" href="listausuarios">Ver usuarios</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#proveedores" aria-expanded="false" aria-controls="proveedores">
                <span class="menu-icon">
                    <i class="mdi mdi-laptop"></i>
                </span>
                <span class="menu-title">Proveedores</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="proveedores">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="agregarproveedores">Agregar</a></li>
                    <li class="nav-item"> <a class="nav-link" href="listaproveedores">Ver proveedores</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#categorias" aria-expanded="false" aria-controls="categorias">
                <span class="menu-icon">
                    <i class="mdi mdi-laptop"></i>
                </span>
                <span class="menu-title">Categorias</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="categorias">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="agregarcategorias">Agregar</a></li>
                    <li class="nav-item"> <a class="nav-link" href="listacategorias">Ver Categorias</a></li>
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
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Ver Stock</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="pages/tables/basic-table.html">
                <span class="menu-icon">
                    <i class="mdi mdi-table-large"></i>
                </span>
                <span class="menu-title">Tables</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="pages/charts/chartjs.html">
                <span class="menu-icon">
                    <i class="mdi mdi-chart-bar"></i>
                </span>
                <span class="menu-title">Charts</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="pages/icons/mdi.html">
                <span class="menu-icon">
                    <i class="mdi mdi-contacts"></i>
                </span>
                <span class="menu-title">Icons</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-icon">
                    <i class="mdi mdi-security"></i>
                </span>
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="http://www.bootstrapdash.com/demo/corona-free/jquery/documentation/documentation.html">
                <span class="menu-icon">
                    <i class="mdi mdi-file-document-box"></i>
                </span>
                <span class="menu-title">Documentation</span>
            </a>
        </li>
    </ul>
</nav>