CREATE DATABASE IF NOT EXISTS ess_colima
CHARACTER SET utf8mb4
COLLATE utf8mb4_spanish_ci;

USE ess_colima;
SET NAMES 'utf8mb4';

-- =========================================================================
-- CONTROLES DE SEGURIDAD, ROLES Y PERMISOS
-- =========================================================================

CREATE TABLE IF NOT EXISTS priv_permisos (
    id_permiso      INTEGER         NOT NULL    AUTO_INCREMENT,
    nombre          VARCHAR(128)    NOT NULL,
    keyword         VARCHAR(32)     NOT NULL,
    create_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_permiso),
    UNIQUE KEY       (keyword)
);

CREATE TABLE IF NOT EXISTS priv_perfiles (
    id_perfil        INTEGER         NOT NULL    AUTO_INCREMENT,
    nombre          VARCHAR(128)    NOT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_perfil)
);

CREATE TABLE IF NOT EXISTS priv_perfiles_permisos (
    id_permiso      INTEGER         NOT NULL,
    id_perfil        INTEGER         NOT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_permiso, id_perfil),
    FOREIGN KEY      (id_permiso)                REFERENCES priv_permisos(id_permiso)    ON DELETE CASCADE,
    FOREIGN KEY      (id_perfil)                 REFERENCES priv_perfiles(id_perfil)
);

CREATE TABLE IF NOT EXISTS priv_roles (
    id_rol           INTEGER         NOT NULL    AUTO_INCREMENT,
    nombre          VARCHAR(128)    NOT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_rol)
);

CREATE TABLE IF NOT EXISTS priv_roles_permisos (
    id_permiso      INTEGER         NOT NULL,
    id_rol           INTEGER         NOT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_permiso, id_rol),
    FOREIGN KEY      (id_permiso)                REFERENCES priv_permisos(id_permiso)    ON DELETE CASCADE,
    FOREIGN KEY      (id_rol)                    REFERENCES priv_roles(id_rol)           ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario       INTEGER         NOT NULL    AUTO_INCREMENT,
    id_perfil        INTEGER         NOT NULL,
    usuario          VARCHAR(255)    NOT NULL,
    nombres          VARCHAR(50)     NOT NULL,
    apellido1        VARCHAR(24)     NOT NULL,
    apellido2        VARCHAR(24)         NULL    DEFAULT NULL,
    contrasena       VARCHAR(255)    NOT NULL,
    estatus          TINYINT(1)      NOT NULL    DEFAULT '1' COMMENT '0 = inactivo, 1 = activo',
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_usuario),
    FOREIGN KEY      (id_perfil)                 REFERENCES priv_perfiles(id_perfil)
);

CREATE TABLE IF NOT EXISTS priv_usuarios_roles (
    id_usuario       INTEGER         NOT NULL,
    id_rol           INTEGER         NOT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_usuario, id_rol),
    FOREIGN KEY      (id_usuario)                REFERENCES usuarios(id_usuario),
    FOREIGN KEY      (id_rol)                    REFERENCES priv_roles(id_rol)           ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS priv_usuarios_permisos (
    id_usuario       INTEGER         NOT NULL,
    id_permiso      INTEGER         NOT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_usuario, id_permiso),
    FOREIGN KEY      (id_usuario)                REFERENCES usuarios(id_usuario),
    FOREIGN KEY      (id_permiso)                REFERENCES priv_permisos(id_permiso)    ON DELETE CASCADE
);

INSERT INTO priv_perfiles (id_perfil, nombre) VALUES
    (1, 'Superusuario'),
    (61, 'Desarrollador');

INSERT INTO priv_permisos (id_permiso, nombre, keyword) VALUES
    (1, 'Administrar los privilegios y el control de acceso', 'admin-privilegios.handle'),
    (2, 'Ejemplos de prueba para desarrolladores', 'dev-ejemplos.handle');

INSERT INTO priv_perfiles_permisos(id_permiso, id_perfil) VALUES
    (1, 1), (1, 61),
    (2, 1), (2, 61);

-- =========================================================================
-- PRODUCTOS Y ALMACÉN
-- =========================================================================

CREATE TABLE IF NOT EXISTS unidades_medida (
    id_unidad        INTEGER         NOT NULL   AUTO_INCREMENT,
    nombre           VARCHAR(255)    NOT NULL,
    abreviatura      VARCHAR(10)     NOT NULL    COMMENT 'KG, PZ, MTS, LTS',
    estatus          TINYINT(1)      NOT NULL    DEFAULT '1' COMMENT '0 = inactivo, 1 = activo',
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_unidad)
);

CREATE TABLE IF NOT EXISTS tipos_productos (
    id_tipo          INTEGER         NOT NULL AUTO_INCREMENT,
    nombre           VARCHAR(100)    NOT NULL,
    estatus          TINYINT(1)      NOT NULL    DEFAULT '1' COMMENT '0 = inactivo, 1 = activo',
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_tipo)
);

CREATE TABLE IF NOT EXISTS productos (
    id_producto      INTEGER         NOT NULL   AUTO_INCREMENT,
    id_tipo          INTEGER         NOT NULL,
    id_unidad        INTEGER         NOT NULL,
    nombre           VARCHAR(100)    NOT NULL,
    ficha_tecnica    VARCHAR(100)    NOT NULL,
    lote             VARCHAR(100)    NOT NULL,
    num_parte        VARCHAR(100)        NULL    DEFAULT NULL,
    descripcion      VARCHAR(100)        NULL    DEFAULT NULL,
    stock            INTEGER         NOT NULL    DEFAULT '0',
    costo            DECIMAL(10,2)   NOT NULL    DEFAULT '0.00',
    tiempos_entrega  DATETIME        NOT NULL,
    estatus          TINYINT(1)      NOT NULL    DEFAULT '1' COMMENT '0 = inactivo, 1 = activo',
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_producto),
    FOREIGN KEY      (id_tipo)                   REFERENCES tipos_productos(id_tipo),
    FOREIGN KEY      (id_unidad)                 REFERENCES unidades_medida(id_unidad),
    UNIQUE KEY       (num_parte)
);

CREATE TABLE IF NOT EXISTS archivos (
    id_archivo       INTEGER         NOT NULL    AUTO_INCREMENT,
    client_name      VARCHAR(255)    NOT NULL,
    server_name      VARCHAR(255)    NOT NULL,
    mime_type        VARCHAR(64)     NOT NULL    DEFAULT 'application/img',
    file_size        INTEGER         NOT NULL    DEFAULT 0,
    delete_time      TIMESTAMP           NULL    DEFAULT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_archivo)
);

CREATE TABLE IF NOT EXISTS productos_archivos (
    id_archivo       INTEGER         NOT NULL,
    id_producto      INTEGER         NOT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY      (id_producto, id_archivo),
    FOREIGN KEY      (id_archivo)                REFERENCES archivos(id_archivo),
    FOREIGN KEY      (id_producto)               REFERENCES productos(id_producto)
);

-- =========================================================================
-- PROVEEDORES
-- =========================================================================

CREATE TABLE IF NOT EXISTS tipos_proveedores (
    id_tipo          INTEGER         NOT NULL   AUTO_INCREMENT,
    nombre           VARCHAR(255)    NOT NULL,
    descripcion      VARCHAR(255)        NULL    DEFAULT NULL,
    estatus          TINYINT(1)      NOT NULL    DEFAULT '1' COMMENT '0 = inactivo, 1 = activo',
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_tipo)
);

CREATE TABLE IF NOT EXISTS proveedores (
    id_proveedor     INTEGER         NOT NULL   AUTO_INCREMENT,
    nombre           VARCHAR(255)    NOT NULL,
    telefono         VARCHAR(100)    NOT NULL,
    correo           VARCHAR(100)    NOT NULL,
    rfc              VARCHAR(50)     NOT NULL,
    descripcion      VARCHAR(255)        NULL    DEFAULT NULL,
    estatus          TINYINT(1)      NOT NULL    DEFAULT '1' COMMENT '0 = inactivo, 1 = activo',
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_proveedor)
);

CREATE TABLE IF NOT EXISTS proveedores_productos (
    id_proveedor INTEGER NOT NULL,
    id_producto  INTEGER NOT NULL,
    create_time  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_time  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_proveedor, id_producto),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor) ON DELETE CASCADE,
    FOREIGN KEY (id_producto)  REFERENCES productos(id_producto)   ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS proveedores_usuarios (
    id_proveedor INTEGER NOT NULL,
    id_usuario   INTEGER NOT NULL,
    create_time  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_time  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_proveedor, id_usuario),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario)   REFERENCES usuarios(id_usuario)      ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS proveedores_tipos (
    id_proveedor     INTEGER         NOT NULL,
    id_tipo          INTEGER         NOT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_tipo, id_proveedor),
    FOREIGN KEY     (id_proveedor)              REFERENCES proveedores(id_proveedor) ON DELETE CASCADE,
    FOREIGN KEY     (id_tipo)                   REFERENCES tipos_proveedores(id_tipo) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS proveedores_ubicaciones (
    id_ubicacion     INTEGER         NOT NULL   AUTO_INCREMENT,
    id_proveedor     INTEGER         NOT NULL,
    ubicacion        VARCHAR(250)    NOT NULL,
    estatus          TINYINT(1)      NOT NULL    DEFAULT '1' COMMENT '0 = inactivo, 1 = activo',
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_ubicacion),
    FOREIGN KEY     (id_proveedor)              REFERENCES proveedores(id_proveedor) ON DELETE CASCADE
);

-- =========================================================================
-- siguiente version 
-- =========================================================================

/* CREATE TABLE IF NOT EXISTS lineas_credito (
    id_linea        INTEGER       NOT NULL AUTO_INCREMENT,
    id_usuario      INTEGER       NOT NULL,
    limite          DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    dia_corte       TINYINT       NOT NULL COMMENT '1-31, día del mes de corte',
    dia_pago        TINYINT       NOT NULL COMMENT 'días después del corte para pagar',
    estatus         TINYINT(1)    NOT NULL DEFAULT '1',
    create_time     TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_linea),
    FOREIGN KEY     (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE IF NOT EXISTS cortes_credito (
    id_corte        INTEGER       NOT NULL AUTO_INCREMENT,
    id_linea        INTEGER       NOT NULL,
    fecha_corte     DATE          NOT NULL,
    fecha_limite    DATE          NOT NULL COMMENT 'fecha máxima de pago',
    saldo_anterior  DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    cargos          DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    abonos          DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    saldo_total     DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    estatus         TINYINT(1)    NOT NULL DEFAULT '0' COMMENT '0=pendiente, 1=pagado, 2=vencido',
    create_time     TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_corte),
    FOREIGN KEY     (id_linea) REFERENCES lineas_credito(id_linea)
); */

-- =========================================================================
-- OPERACIONES, PEDIDOS Y CRÉDITOS (LO QUE HACÍA FALTA)
-- =========================================================================

CREATE TABLE IF NOT EXISTS tipos_pago (
    id_tipo_pago     INTEGER         NOT NULL    AUTO_INCREMENT,
    nombre           VARCHAR(100)    NOT NULL    COMMENT 'Efectivo, Crédito Social, Trueque, Transferencia',
    estatus          TINYINT(1)      NOT NULL    DEFAULT '1' COMMENT '0 = inactivo, 1 = activo',
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_tipo_pago)
);

CREATE TABLE IF NOT EXISTS pedidos (
    id_pedido        INTEGER         NOT NULL    AUTO_INCREMENT,
    id_tipo_pago     INTEGER         NOT NULL,
    fecha_pedido     DATETIME        NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    total            DECIMAL(10,2)   NOT NULL    DEFAULT '0.00',
    estatus          TINYINT(1)      NOT NULL    DEFAULT '0' COMMENT '0 = en proceso, 1 = completado, 2 = cancelado',
    comentarios      VARCHAR(255)        NULL    DEFAULT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_pedido),
    FOREIGN KEY     (id_tipo_pago)              REFERENCES tipos_pago(id_tipo_pago)
);

CREATE TABLE IF NOT EXISTS pedido_detalles (
    id_detalle       INTEGER         NOT NULL    AUTO_INCREMENT,
    id_usuario       INTEGER         NOT NULL    COMMENT 'Usuario/Empleado que registra el pedido',
    id_pedido        INTEGER         NOT NULL,
    id_producto      INTEGER         NOT NULL,
    cantidad         INTEGER         NOT NULL    DEFAULT '1',
    precio_historico DECIMAL(10,2)   NOT NULL    COMMENT 'Precio al que se vendió en su momento',
    contenido        TEXT            NOT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_detalle),
    FOREIGN KEY     (id_pedido)                 REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY     (id_usuario)                REFERENCES usuarios(id_usuario),
    FOREIGN KEY     (id_producto)               REFERENCES productos(id_producto)
);

/* CREATE TABLE IF NOT EXISTS creditos_sociales (
    id_credito       INTEGER         NOT NULL    AUTO_INCREMENT,
    id_pedido        INTEGER             NULL    DEFAULT NULL COMMENT 'Opcional, por si viene de un pedido',
    id_usuario       INTEGER         NOT NULL    COMMENT 'Usuario dueño de la línea de crédito',
    monto            DECIMAL(10,2)   NOT NULL,
    tipo_movimiento  TINYINT(1)      NOT NULL    COMMENT '0 = cargo (gasto), 1 = abono (ingreso/recarga)',
    descripcion      VARCHAR(255)        NULL    DEFAULT NULL,
    create_time      TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_credito),
    FOREIGN KEY     (id_pedido)                 REFERENCES pedidos(id_pedido) ON DELETE SET NULL,
    FOREIGN KEY     (id_usuario)                REFERENCES usuarios(id_usuario)
); */

