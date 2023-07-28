-- 09/07/2023: 
-- Se agregó la columna token para manejar la recuparación de contraseñas de una manera más segura
ALTER TABLE USUARIOS ADD TokenRecuperacion VARCHAR(100);

-- 11/07/2023: 
ALTER TABLE TIPO_BENEFICIARIO ADD Estatus VARCHAR(1);
UPDATE TIPO_BENEFICIARIO SET Estatus = 'A';

-- 2023-07-25
-- Agregar funcionalidad para los ejercicios fiscales

CREATE TABLE EJERCICIOS_FISCALES (
    Id INT(4) PRIMARY KEY,
    Comentarios VARCHAR(1000),
    Estatus VARCHAR(1)
) engine=innodb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

INSERT INTO EJERCICIOS_FISCALES (Id,Comentarios, Estatus) VALUES (2023, '', 'A');

-- catalogo programatico
ALTER TABLE PROGRAMATICO ADD ejercicioFiscal INT(4);
UPDATE PROGRAMATICO SET ejercicioFiscal=2023;

ALTER TABLE PROGRAMATICO 
	DROP PRIMARY KEY, 
	ADD PRIMARY KEY (idObjetivoPED, idClasificacion, Consecutivo, ejercicioFiscal);

-- catalogo de componentes de los programas presupuestarios
ALTER TABLE PROGRAMATICO_COMP ADD ejercicioFiscal INT(4);
UPDATE PROGRAMATICO_COMP SET ejercicioFiscal=2023;


ALTER TABLE PROGRAMATICO_COMP
	DROP PRIMARY KEY, 
	ADD PRIMARY KEY (idObjetivoPED, idClasificacion, Consecutivo,Componente, idSecretaria, idUA, ejercicioFiscal);
	
-- catalogo de componentes de las actividades institucionales
ALTER TABLE PROGRAMATICO_AI_COMP ADD ejercicioFiscal INT(4);
UPDATE PROGRAMATICO_AI_COMP SET ejercicioFiscal=2023;

ALTER TABLE PROGRAMATICO_AI_COMP
	DROP PRIMARY KEY, 
	ADD PRIMARY KEY (idObjetivoPED, idClasificacion, Consecutivo, Componente, ClaveFuncional, ejercicioFiscal);
	
-- catalogo de componentes de los programas de inversion
ALTER TABLE PROGRAMATICO_PI_COMP ADD ejercicioFiscal INT(4);
UPDATE PROGRAMATICO_PI_COMP SET ejercicioFiscal=2023;

ALTER TABLE PROGRAMATICO_PI_COMP
	DROP PRIMARY KEY, 
	ADD PRIMARY KEY (idObjetivoPED, idClasificacion, Consecutivo, Componente, idSecretaria, idUA, ejercicioFiscal);
