 <div class="row">
     <div class="col-md-12 grid-margin stretch-card">
         <div class="card">
             <div class="card-body">
                 <h4 class="card-title">Registrar Venta</h4>
                 <p class="card-description">Ingrese la información de la venta</p>
                 <!-- Aquí está el formulario para registrar una venta -->
                 <form class="forms-sample" method="post">
                     <!-- Select para elegir el producto -->
                     <div class="form-group">
                         <label for="selectProducto">Elija el producto</label>
                         <select name="IdProducto" class="form-control" id="selectProducto" required>
                             <option value="">Seleccione un producto</option>
                             <option value="1">Producto 1</option>
                             <option value="2">Producto 2</option>
                             <option value="3">Producto 3</option>
                             <!-- Añadir más productos según tu base de datos -->
                         </select>
                     </div>
                     <!-- Campo para ingresar la cantidad -->
                     <div class="form-group">
                         <label for="inputCantidad">Cantidad</label>
                         <input name="Cantidad" type="number" class="form-control" id="inputCantidad" placeholder="Ingrese la cantidad" required>
                     </div>
                     <!-- Campo para capturar la fecha de registro -->
                     <div class="form-group">
                         <label for="inputFechaRegistro">Fecha de Registro</label>
                         <input name="FechaRegistro" type="date" class="form-control" id="inputFechaRegistro" required>
                     </div>
                     <!-- Botón para enviar el formulario -->
                     <button name="registrarVenta" type="submit" class="btn btn-primary mr-2">Registrar Venta</button>
                     <button type="reset" class="btn btn-dark">Cancelar</button>
                 </form>
             </div>
         </div>
     </div>
 </div>