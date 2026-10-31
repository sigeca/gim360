use gim360;

CREATE TABLE imagen (
    idimagen INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255),
    idformatoimagen int,
    fechacaptura DATETIME,
    descripcion TEXT,
    palabrasclave TEXT,
    licencia VARCHAR(50),
    fechacreacion TIMESTAMP,
    idordenador INT,
    iddirectorio INT
);
