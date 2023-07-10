-- 09/07/2023: 
-- Se agregó la columna token para manejar la recuparación de contraseñas de una manera más segura
ALTER TABLE USUARIOS ADD TokenRecuperacion VARCHAR(100);