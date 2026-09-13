CREATE TABLE IF NOT EXISTS priv_permisos (
    id_permiso      INTEGER         NOT NULL    AUTO_INCREMENT,
    nombre          VARCHAR(128)    NOT NULL,
    keyword         VARCHAR(32)     NOT NULL,
    create_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_permiso),
    UNIQUE KEY      (keyword)
);

CREATE TABLE IF NOT EXISTS priv_perfiles (
    id_perfil       INTEGER         NOT NULL,
    nombre          VARCHAR(128)    NOT NULL,
    create_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_perfil)
);

CREATE TABLE IF NOT EXISTS priv_perfiles_permisos (
    id_permiso      INTEGER         NOT NULL,
    id_perfil       INTEGER         NOT NULL,
    create_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_permiso, id_perfil),
    FOREIGN KEY     (id_permiso)    REFERENCES priv_permisos(id_permiso)    ON DELETE CASCADE,
    FOREIGN KEY     (id_perfil)     REFERENCES priv_perfiles(id_perfil)
);

CREATE TABLE IF NOT EXISTS priv_roles (
    id_rol          INTEGER         NOT NULL    AUTO_INCREMENT,
    nombre          VARCHAR(128)    NOT NULL,
    create_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_rol)
);

CREATE TABLE IF NOT EXISTS priv_roles_permisos (
    id_permiso      INTEGER         NOT NULL,
    id_rol          INTEGER         NOT NULL,
    create_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_permiso, id_rol),
    FOREIGN KEY     (id_permiso)    REFERENCES priv_permisos(id_permiso)    ON DELETE CASCADE,
    FOREIGN KEY     (id_rol)        REFERENCES priv_roles(id_rol)           ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario      INTEGER         NOT NULL,
    id_perfil       INTEGER         NOT NULL,
    usuario         VARCHAR(255)    NOT NULL,
    nombres         VARCHAR(48)     NOT NULL,
    apellido1       VARCHAR(24)     NOT NULL,
    apellido2       VARCHAR(24)         NULL,
    sexo            TINYINT         NOT NULL    DEFAULT 0   COMMENT 'ISO/IEC5218: 0=NotKnown, 1=Male, 2=Female, 9=NotApplicable',
    tipo_usuario    VARCHAR(32)     NOT NULL,
    create_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_usuario),
    FOREIGN KEY     (id_perfil)     REFERENCES priv_perfiles(id_perfil)
);

CREATE TABLE IF NOT EXISTS priv_usuarios_roles (
    id_usuario      INTEGER         NOT NULL,
    id_rol          INTEGER         NOT NULL,
    create_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_usuario, id_rol),
    FOREIGN KEY     (id_usuario)    REFERENCES usuarios(id_usuario),
    FOREIGN KEY     (id_rol)        REFERENCES priv_roles(id_rol)           ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS priv_usuarios_permisos (
    id_usuario      INTEGER         NOT NULL,
    id_permiso      INTEGER         NOT NULL,
    create_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_usuario, id_permiso),
    FOREIGN KEY     (id_usuario)    REFERENCES usuarios(id_usuario),
    FOREIGN KEY     (id_permiso)    REFERENCES priv_permisos(id_permiso)    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS demo_ejemplos (
    id_ejemplo      INTEGER         NOT NULL    AUTO_INCREMENT,
    nombre          VARCHAR(255)    NOT NULL,
    descripcion     VARCHAR(1024)   NOT NULL,
    delete_time     DATETIME            NULL    DEFAULT NULL,
    create_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    update_time     TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP   ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY     (id_ejemplo)
);

INSERT INTO priv_perfiles (id_perfil, nombre) VALUES
    (1, 'Superusuario'),
    (61, 'CdeC-Desarrollo');

INSERT INTO priv_permisos (id_permiso, nombre, keyword) VALUES
    (1, 'Administrar los privilegios y el control de acceso', 'admin-privilegios.handle'),
    (2, 'Ejemplos de prueba para desarrolladores', 'dev-ejemplos.handle');

INSERT INTO priv_perfiles_permisos(id_permiso, id_perfil) VALUES
    (1, 1), (1, 61),
    (2, 1), (2, 61);