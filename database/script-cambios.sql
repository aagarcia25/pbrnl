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

/************************************************
		MIR
*************************************************/

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
		);


-- agregar al componente el id que estamos generando
ALTER TABLE COMPONENTE1 ADD ComponenteId INT;

ALTER TABLE COMPONENTE1 DROP PRIMARY KEY;
ALTER TABLE COMPONENTE1 ADD Id INT PRIMARY KEY AUTO_INCREMENT;

-- actualizar el componente de la mir
UPDATE COMPONENTE1 c1 
INNER JOIN
	PROGRAMATICO_COMP cc
ON 
	c1.Componente = cc.descripcioncomponente
	AND c1.ClasProgramatica = cc.Consecutivo
SET ComponenteId = cc.Id;

-- se quitan los puntos al final
UPDATE COMPONENTE1 SET Componente=TRIM(TRAILING '.' FROM Componente) WHERE ComponenteId IS NULL;

-- se vuelven a actualizar para coincidir los más que se puedan
UPDATE COMPONENTE1 c1 
INNER JOIN
	PROGRAMATICO_COMP cc
ON 
	c1.Componente = cc.descripcioncomponente
	AND c1.ClasProgramatica = cc.Consecutivo
SET ComponenteId = cc.Id;

-- --------------------- actualización manual
UPDATE COMPONENTE1 SET ComponenteId=401 WHERE Id=2;
UPDATE COMPONENTE1 SET ComponenteId=470 WHERE Id=40;
UPDATE COMPONENTE1 SET ComponenteId=337 WHERE Id=84;
UPDATE COMPONENTE1 SET ComponenteId=339 WHERE Id=86;
UPDATE COMPONENTE1 SET ComponenteId=334 WHERE Id=96;
UPDATE COMPONENTE1 SET ComponenteId=1 WHERE Id=100;
UPDATE COMPONENTE1 SET ComponenteId=8 WHERE Id=107;
UPDATE COMPONENTE1 SET ComponenteId=12 WHERE Id=111;
UPDATE COMPONENTE1 SET ComponenteId=223 WHERE Id=128;
UPDATE COMPONENTE1 SET ComponenteId=351 WHERE Id=151;
UPDATE COMPONENTE1 SET ComponenteId=263 WHERE Id=164;
UPDATE COMPONENTE1 SET ComponenteId=67 WHERE Id=191;
UPDATE COMPONENTE1 SET ComponenteId=280 WHERE Id=197;
UPDATE COMPONENTE1 SET ComponenteId=168 WHERE Id=203;
UPDATE COMPONENTE1 SET ComponenteId=171 WHERE Id=206;
UPDATE COMPONENTE1 SET ComponenteId=173 WHERE Id=208;
UPDATE COMPONENTE1 SET ComponenteId=174 WHERE Id=209;
UPDATE COMPONENTE1 SET ComponenteId=462 WHERE Id=225;
UPDATE COMPONENTE1 SET ComponenteId=465 WHERE Id=228;
UPDATE COMPONENTE1 SET ComponenteId=70 WHERE Id=251;
UPDATE COMPONENTE1 SET ComponenteId=182 WHERE Id=277;
UPDATE COMPONENTE1 SET ComponenteId=183 WHERE Id=278;
UPDATE COMPONENTE1 SET ComponenteId=33 WHERE Id=286;
UPDATE COMPONENTE1 SET ComponenteId=241 WHERE Id=336;
UPDATE COMPONENTE1 SET ComponenteId=245 WHERE Id=340;
UPDATE COMPONENTE1 SET ComponenteId=215 WHERE Id=351;
UPDATE COMPONENTE1 SET ComponenteId=216 WHERE Id=352;
UPDATE COMPONENTE1 SET ComponenteId=317 WHERE Id=376;
UPDATE COMPONENTE1 SET ComponenteId=323 WHERE Id=385;
UPDATE COMPONENTE1 SET ComponenteId=137 WHERE Id=387;
UPDATE COMPONENTE1 SET ComponenteId=138 WHERE Id=388;
UPDATE COMPONENTE1 SET ComponenteId=142 WHERE Id=392;
UPDATE COMPONENTE1 SET ComponenteId=109 WHERE Id=419;
UPDATE COMPONENTE1 SET ComponenteId=112 WHERE Id=422;
UPDATE COMPONENTE1 SET ComponenteId=114 WHERE Id=424;
UPDATE COMPONENTE1 SET ComponenteId=155 WHERE Id=432;
UPDATE COMPONENTE1 SET ComponenteId=156 WHERE Id=448;
-- --------------------- actualización manual

-- agregar a la mir el id del programa presupuestario al que pertenece
ALTER TABLE MIR_CARATULA ADD ProgramaticoId INT;

UPDATE MIR_CARATULA m
	INNER JOIN PROGRAMATICO c
	ON 
	    m.Consecutivo = c.Consecutivo
	AND m.EjercicioFiscal = c.EjercicioFiscal
	AND m.idObjetivo = c.idObjetivoPED
	AND c.EjercicioFiscal = 2023
SET m.ProgramaticoId = c.Id

/********************************************************/
/*** 26/08/2023 ************/
/* Agregar un id único a la carátula para facilitar la asociación con otras tablas */
ALTER TABLE MIR_CARATULA DROP PRIMARY KEY;
ALTER TABLE MIR_CARATULA ADD Id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT;

-- modificar la tabla de actividad para eliminar la dependencia de las llaves primarias compuestas
ALTER TABLE ACTIVIDAD DROP PRIMARY KEY;
ALTER TABLE ACTIVIDAD ADD Id INT PRIMARY KEY AUTO_INCREMENT;

ALTER TABLE ACTIVIDAD ADD ComponenteMirId INT;
UPDATE ACTIVIDAD a SET ComponenteMirId = (SELECT Id FROM COMPONENTE1 mc WHERE mc.ClasProgramatica = a.ClasProgramatica AND mc.idComponente = a.idComponente)

/************ 28-08-2023 *******************/
INSERT INTO mir_caratula VALUES (464,2023,'CARGADO','E','99.01','G',17,17,'02','03','04',NULL,NULL,2021,291,DEFAULT);

/************ 29-08-2023 *******************/
ALTER TABLE COMPONENTE1 ADD EjercicioFiscal INT;
ALTER TABLE ACTIVIDAD ADD EjercicioFiscal INT;
UPDATE COMPONENTE1 SET EjercicioFiscal = 2023;
UPDATE ACTIVIDAD SET EjercicioFiscal = 2023;

-- 30-08-2023
ALTER TABLE FIN1 ADD EjercicioFiscal INT;
ALTER TABLE PROPOSITO ADD EjercicioFiscal INT;

UPDATE FIN1 SET EjercicioFiscal=2023;
UPDATE PROPOSITO SET EjercicioFiscal=2023;

ALTER TABLE FIN1 DROP PRIMARY KEY;
ALTER TABLE FIN1 ADD Id INT PRIMARY KEY AUTO_INCREMENT;

ALTER TABLE PROPOSITO DROP PRIMARY KEY;
ALTER TABLE PROPOSITO ADD Id INT PRIMARY KEY AUTO_INCREMENT;

