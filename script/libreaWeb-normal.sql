-- Crear la base de datos
CREATE DATABASE LibreriaWeb;

-- Usar la base de datos
USE LibreriaWeb;

-- Tabla Usuario
CREATE TABLE Usuario (
    IdUsuario INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    NombreUsu VARCHAR(50) NOT NULL UNIQUE,
    Clave VARCHAR(100) NOT NULL,
    Correo VARCHAR(100) NOT NULL,
    EsAdmin BOOLEAN NOT NULL DEFAULT FALSE,
    Estado BOOLEAN NOT NULL DEFAULT TRUE
);

-- Tabla Categoria
CREATE TABLE Categoria (
    IdCategoria INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT NOT NULL,
    Estado BOOLEAN NOT NULL DEFAULT TRUE
);

-- Tabla Proveedor
CREATE TABLE Proveedor (
    IdProveedor INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Correo VARCHAR(100) NOT NULL,
    Telefono VARCHAR(15) NOT NULL
);

-- Tabla Producto
CREATE TABLE Producto (
    IdProducto INT AUTO_INCREMENT PRIMARY KEY,
    Codigo VARCHAR(50) NOT NULL UNIQUE,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT NOT NULL,
    IdCategoria INT NOT NULL,
    Stock INT NOT NULL,
    Umbral INT NOT NULL,
    PrecioCompra DECIMAL(10, 2) NOT NULL,
    PrecioVenta DECIMAL(10, 2) NOT NULL,
    Estado BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (IdCategoria) REFERENCES Categoria(IdCategoria)
);

-- Tabla Compra
CREATE TABLE Compra (
    IdCompra INT AUTO_INCREMENT PRIMARY KEY,
    IdUsuario INT NOT NULL,
    IdProveedor INT NOT NULL,
    IdProducto INT NOT NULL,
    FechaRegistro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Cantidad INT NOT NULL,
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario),
    FOREIGN KEY (IdProveedor) REFERENCES Proveedor(IdProveedor),
    FOREIGN KEY (IdProducto) REFERENCES Producto(IdProducto)
);

-- Tabla Venta
CREATE TABLE Venta (
    IdVenta INT AUTO_INCREMENT PRIMARY KEY,
    IdProducto INT NOT NULL,
    IdUsuario INT NOT NULL,
    Cantidad INT NOT NULL,
    FechaRegistro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (IdProducto) REFERENCES Producto(IdProducto),
)