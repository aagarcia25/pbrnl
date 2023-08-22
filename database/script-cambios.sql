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

-- 

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

-- 11/08/2023: UPDATE REPO PRIVADO
-- 11/08/2023: NUEVO UPDATE, DESDE OTRA COMPUTADORA


-- CORREGIR LAS CLAVES PARA ENLAZAR LOS COMPONENTES CON LAS MIR

ALTER TABLE PROGRAMATICO DROP PRIMARY KEY;
ALTER TABLE PROGRAMATICO ADD Id INT PRIMARY KEY AUTO_INCREMENT;

ALTER TABLE PROGRAMATICO_COMP DROP PRIMARY KEY;
ALTER TABLE PROGRAMATICO_COMP ADD Id INT PRIMARY KEY AUTO_INCREMENT;

ALTER TABLE PROGRAMATICO_COMP ADD ProgramaticoId INT;	-- referencia al programa presupuestario

UPDATE PROGRAMATICO_COMP c SET ProgramaticoId = 
	(SELECT Id FROM PROGRAMATICO AS p 
		WHERE p.idObjetivoPED = c.idObjetivoPED
		AND p.idClasificacion = c.idClasificacion
		AND p.Consecutivo = c.Consecutivo
		AND p.idSecretaria = c.idSecretaria
		AND p.ejercicioFiscal = c.ejercicioFiscal
		)


-- agregar al componente el id que estamos generando
ALTER TABLE COMPONENTE1 ADD ComponenteId INT;

-- actualizar el componente de la mir
UPDATE COMPONENTE1 c1 
INNER JOIN
	PROGRAMATICO_COMP cc
ON 
	c1.Componente = cc.descripcioncomponente
	AND c1.ClasProgramatica = cc.Consecutivo
SET ComponenteId = cc.Id;

-- agregar a la mir el id del programa presupuestario
ALTER TABLE MIR_CARATULA ADD ProgramaticoId INT;

UPDATE MIR_CARATULA m
	INNER JOIN PROGRAMATICO c
	ON 
	    m.Consecutivo = c.Consecutivo
	AND m.EjercicioFiscal = c.EjercicioFiscal
	AND m.idObjetivo = c.idObjetivoPED
	AND c.EjercicioFiscal = 2023
SET m.ProgramaticoId = c.Id

-- -------------------------------------------
ALTER TABLE COMPONENTE1 DROP PRIMARY KEY;
ALTER TABLE COMPONENTE1 ADD Id INT PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE COMPONENTE1 DROP COLUMN Componente;
