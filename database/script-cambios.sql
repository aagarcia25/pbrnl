-- 09/07/2023: 
-- Se agregó la columna token para manejar la recuparación de contraseñas de una manera más segura
ALTER TABLE USUARIOS ADD TokenRecuperacion VARCHAR(100);

-- 11/07/2023: 
ALTER TABLE TIPO_BENEFICIARIO ADD Estatus VARCHAR(1);
UPDATE TIPO_BENEFICIARIO SET Estatus = 'A';



CREATE TABLE EJERCICIOS_FISCALES (
    Id INT(4) PRIMARY KEY,
    Comentarios VARCHAR(1000),
    Estatus VARCHAR(1)
)ENGINE=INNODB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

INSERT INTO EJERCICIOS_FISCALES (Id,Comentarios, Estatus) VALUES (2023, '', 'A');

