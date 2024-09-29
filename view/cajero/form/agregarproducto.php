<div class="page-header">
    <h3 class="page-title"> Productos </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="listacategorias">Ver Stock</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administrar Productos</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Registrar Producto</h4>
                <p class="card-description">Ingrese la información del producto</p>
                <!-- Aquí está el formulario para registrar un producto -->
                <form class="forms-sample" method="post">
                    <!-- Campo para ingresar el código -->
                    <div class="form-group">
                        <label for="inputCodigo">Código</label>
                        <input name="codigo" type="text" class="form-control" id="inputCodigo" placeholder="Ingrese el código del producto" required>
                    </div>
                    <!-- Campo para ingresar el nombre -->
                    <div class="form-group">
                        <label for="inputNombre">Nombre</label>
                        <input name="nombre" type="text" class="form-control" id="inputNombre" placeholder="Ingrese el nombre del producto" required>
                    </div>
                    <!-- Campo para ingresar la descripción -->
                    <div class="form-group">
                        <label for="inputDescripcion">Descripción</label>
                        <textarea name="descripcion" class="form-control" id="inputDescripcion" rows="3" placeholder="Ingrese la descripción del producto" required></textarea>
                    </div>
                    <!-- Select para elegir la categoría -->
                    <div class="form-group">
                        <label for="selectCategoria">Seleccione la categoría</label>
                        <select name="categoria" class="form-control" id="selectCategoria" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="1">Categoría 1</option>
                            <option value="2">Categoría 2</option>
                            <option value="3">Categoría 3</option>
                            <!-- Añadir más categorías según tu base de datos -->
                        </select>
                    </div>
                    <!-- Campo para ingresar el stock -->
                    <!-- <div class="form-group">
                        <label for="inputStock">Stock</label>
                        <input name="stock" type="number" class="form-control" id="inputStock" placeholder="Ingrese el stock disponible" required>
                    </div> -->
                    <!-- Campo para ingresar el umbral -->
                    <div class="form-group">
                        <label for="inputUmbral">Umbral</label>
                        <input name="umbral" type="number" class="form-control" id="inputUmbral" placeholder="Ingrese el umbral mínimo" required>
                    </div>
                    <!-- Campo para ingresar el precio de compra -->
                    <div class="form-group">
                        <label for="inputPrecioCompra">Precio de Compra</label>
                        <input name="precioCompra" type="number" step="0.01" class="form-control" id="inputPrecioCompra" placeholder="Ingrese el precio de compra" required>
                    </div>
                    <!-- Campo para ingresar el precio de venta -->
                    <div class="form-group">
                        <label for="inputPrecioVenta">Precio de Venta</label>
                        <input name="precioVenta" type="number" step="0.01" class="form-control" id="inputPrecioVenta" placeholder="Ingrese el precio de venta" required>
                    </div>
                    <!-- Select para seleccionar el estado (activo o inactivo) -->
                    <!-- <div class="form-group">
                        <label for="selectEstado">Estado</label>
                        <select name="estado" class="form-control" id="selectEstado" required>
                            <option value="">Seleccione el estado</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div> -->
                    <!-- Botones para agregar o cancelar -->
                    <button name="registrarProducto" type="submit" class="btn btn-primary mr-2">Registrar Producto</button>
                    <button type="reset" class="btn btn-dark">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>