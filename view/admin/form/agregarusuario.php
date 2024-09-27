<div class="page-header">
    <h3 class="page-title"> Usuarios </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Formulario</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar Usuario</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Agregar usuarios</h4>
                <p class="card-description"> Ingrese la informacion </p>
                <form class="forms-sample">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Nombre completo</label>
                        <input type="text" class="form-control" placeholder="nombre completo" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Nombre de Usuario</label>
                        <input type="text" class="form-control" placeholder="nombre de usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="selectCargo">Cargo</label>
                        <select class="form-control" id="selectCargo" required>
                            <option value="">Seleccione un cargo</option>
                            <option value="">Administrador</option>
                            <option value="">Cajero</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Contrañase</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputConfirmPassword1">Confirme Contrañase</label>
                        <input type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Agregar</button>
                    <button class="btn btn-dark">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>