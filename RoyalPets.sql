-- =============================================
-- BASE DE DATOS: VETERINARIA ROYAL PETS (CON SEDES)
-- =============================================

DROP DATABASE IF EXISTS RoyalPetsDB;
CREATE DATABASE RoyalPetsDB;
USE RoyalPetsDB;

-- Tabla Sedes
CREATE TABLE Sedes (
    id_sede INT AUTO_INCREMENT PRIMARY KEY,
    nombre_sede VARCHAR(50) NOT NULL,
    distrito VARCHAR(50) NOT NULL,
    direccion VARCHAR(150) NOT NULL,
    telefono VARCHAR(15)
);

-- TABLA DUEÑOS (Clientes)
CREATE TABLE Duenos (
    id_dueno INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL, -- Modificado
    apellidos VARCHAR(100) NOT NULL, -- Agregado
    dni VARCHAR(8) UNIQUE NOT NULL, -- Agregado
    telefono VARCHAR(15) NOT NULL,
    correo VARCHAR(100) UNIQUE,
    direccion VARCHAR(150),
    fecha_registro DATE DEFAULT (CURRENT_DATE)
);

-- TABLA VETERINARIOS 
CREATE TABLE Veterinarios (
    id_veterinario INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    especialidad VARCHAR(50) NOT NULL,
    cmp VARCHAR(20) UNIQUE NOT NULL, -- (Código de Colegiatura)
    telefono VARCHAR(15),
    correo VARCHAR(100) UNIQUE,
    id_sede INT NOT NULL,
    CONSTRAINT fk_veterinario_sede FOREIGN KEY (id_sede) REFERENCES Sedes(id_sede)
);

-- TABLA MASCOTAS 
CREATE TABLE Mascotas (
    id_mascota INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    especie VARCHAR(30) NOT NULL,
    raza VARCHAR(50),
    sexo VARCHAR(10) CHECK (sexo IN ('Macho', 'Hembra')),
    fecha_nacimiento DATE,
    peso DECIMAL(5,2), 
    id_dueno INT NOT NULL,
    CONSTRAINT fk_mascota_dueno FOREIGN KEY (id_dueno) REFERENCES Duenos(id_dueno) ON DELETE CASCADE
);

-- TABLA SERVICIOS
CREATE TABLE Servicios (
    id_servicio INT AUTO_INCREMENT PRIMARY KEY,
    nombre_servicio VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL CHECK (precio >= 0),
    duracion_minutos INT DEFAULT 30
);

-- TABLA CITAS 
CREATE TABLE Citas (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    fecha_hora DATETIME NOT NULL,
    estado VARCHAR(20) DEFAULT 'Pendiente', 
    observaciones TEXT, 
    id_mascota INT NOT NULL,
    id_veterinario INT NOT NULL,
    id_servicio INT NOT NULL,
    id_sede INT NOT NULL,
    CONSTRAINT fk_cita_mascota FOREIGN KEY (id_mascota) REFERENCES Mascotas(id_mascota),
    CONSTRAINT fk_cita_veterinario FOREIGN KEY (id_veterinario) REFERENCES Veterinarios(id_veterinario),
    CONSTRAINT fk_cita_servicio FOREIGN KEY (id_servicio) REFERENCES Servicios(id_servicio),
    CONSTRAINT fk_cita_sede FOREIGN KEY (id_sede) REFERENCES Sedes(id_sede),
    CONSTRAINT chk_estado CHECK (estado IN ('Pendiente', 'Completada', 'Cancelada'))
);

-- TABLA PRODUCTOS 
CREATE TABLE Productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(100) NOT NULL,
    categoria VARCHAR(50),
    precio DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    CONSTRAINT chk_stock CHECK (stock >= 0)
);

-- =============================================
-- AGREGANDO DATOS A LAS TABLAS
-- =============================================
-- Segun la web actual solo se tiene estas sedes

INSERT INTO Sedes (nombre_sede, distrito, direccion, telefono) VALUES
('Los Olivos', 'Los Olivos', 'Av. Las Palmeras 153', '01-5751286'),
('Miraflores', 'Miraflores', 'Av. Pardo 447', '01-4985673'),
('La Molina', 'La Molina', 'Av. La Molina 709', '01-5559012'),
('Chorrillos', 'Chorrillos', 'Av. Guardia Civil 355', '01-3553356');

-- Agregando clientes 

INSERT INTO Duenos (nombres, apellidos, dni, telefono, correo, direccion) VALUES
('Monica', 'Farro', '72348867', '997657320', 'monicaf@gmail.com', 'Av. 28 de Julio 133'),
('Carlos', 'Falcon', '87755327', '911395608', 'carlosfalcon@hotmail.com', 'Calle Alamos 466'),
('Lesly', 'Flores', '11723844', '919800777', 'lflores@gmail.com', 'Av. Escardo 799'),
('Luis', 'Paulino', '48334211', '958444332', 'jorge@gmail.com', 'Jr. Gamarra 101'),
('Carmen', 'Torres', '45867988', '988333252', 'carmencitat@gmail.com', 'Av. Pardo 222'),
('Arturo', 'Parker', '71149679', '907657821', 'arturoparker@gmail.com', 'Av. Colonial 555'),
('Marcela', 'Rojas', '86655120', '900399603', 'mrojas@hotmail.com', 'Calle Juan Pablo 966'),
('Joaquin', 'Casas', '77723866', '921800927', 'jcasasp@gmail.com', 'Av. Pardo 369'),
('Raul', 'Bardales', '45514201', '958123332', 'raulito@gmail.com', 'Jr. Los Alamos 2589'),
('Morgan', 'Noguera', '51868877', '955003251', 'morgan@gmail.com', 'Av. 2 de Mayo 147');

-- Agregando veterinarios

INSERT INTO Veterinarios (nombres, apellidos, especialidad, cmp, telefono, correo, id_sede) VALUES
('Roberto', 'Ramos', 'Medicina General', 'CMP 12348', '910111022', 'rramos@royalpets.com', 1),
('Andy', 'Vidal', 'Cirugía General', 'CMP 60810', '902333464', 'avidal@royalpets.com', 2),
('Diego', 'Carey', 'Dermatología', 'CMP 29610', '900535662', 'dcarey@royalpets.com', 3),
('Pedro', 'Arana', 'Traumatologia', 'CMP 12758', '910231022', 'parana@royalpets.com', 1),
('Kiran', 'Lopez', 'Cirugía General', 'CMP 66810', '902223464', 'klopez@royalpets.com', 2),
('Jordan', 'Mendoza', 'Cardiologia', 'CMP 22210', '910585652', 'jmendoza@royalpets.com', 3),
('Fernando', 'Aguirre', 'Geriatria', 'CMP 70820', '902443464', 'faguirre@royalpets.com', 2),
('Alvaro', 'Ramos', 'Dermatología', 'CMP 29410', '900535771', 'aramos@royalpets.com', 3),
('Kumar', 'Lamar', 'Cirugia', 'CMP 14458', '910235822', 'klamar@royalpets.com', 1),
('Mariana', 'Perez', 'Cirugía General', 'CMP 88810', '902228964', 'mperez@royalpets.com', 2),
('Marcos', 'Mendez', 'Cardiologia', 'CMP 20210', '910585652', 'mmendez@royalpets.com', 3);

-- Agregando Mascotas

INSERT INTO Mascotas (nombre, especie, raza, sexo, fecha_nacimiento, peso, id_dueno) VALUES
('Yaco', 'Perro', 'Snhauzer', 'Macho', '2020-02-11', 10.50, 1),
('Michifu', 'Gato', 'Siames', 'Hembra', '2020-03-15', 4.90, 2),
('Cambo', 'Perro', 'Cocker', 'Hembra', '2018-01-18', 28.00, 3),
('Luna', 'Perro', 'Golden Retriever', 'Hembra', '2021-09-23', 20.00, 1),
('Tayra', 'Gato', 'Atrigrada', 'Hembra', '2023-01-01', 3.87, 4),
('Oso', 'Perro', 'Bulldog', 'Macho', '2019-10-30', 19.00, 5),
('Sandor', 'Perro', 'Criollo', 'Macho', '2017-01-20', 25.00, 3),
('Tayini', 'Perro', 'Pitbull', 'Hembra', '2023-05-23', 12.00, 1),
('Blanca', 'Gato', 'Siames', 'Hembra', '2026-02-01', 3.57, 4),
('Loki', 'Perro', 'Pastor Aleman', 'Macho', '2019-10-24', 25.00, 5);

-- Agregando Servicios

INSERT INTO Servicios (nombre_servicio, descripcion, precio, duracion_minutos) VALUES
('Consulta General', 'Revisión completa de salud', 60.00, 30),
('Vacunación', 'Aplicación de vacunas esenciales', 30.00, 15),
('Baño y Corte', 'Servicio de estética canina', 45.00, 60),
('Cirugía Menor', 'Esterilización o procedimientos pequeños', 150.00, 90),
('Desparasitación', 'Tratamiento antiparasitario', 25.00, 15),
('Profilaxis', 'Limpieza de Dientes', 300.00, 90),
('Baño Medicado', 'Baño para problemas dermatologicos', 45.00, 15);

-- Agregando reserva de citas

INSERT INTO Citas (fecha_hora, estado, observaciones, id_mascota, id_veterinario, id_servicio, id_sede) VALUES
('2026-11-04 10:00:00', 'Pendiente', 'El perro tiene tos fuerte', 1, 1, 1, 1),
('2026-11-05 11:00:00', 'Completada', 'Vacuna aplicada sin problemas', 2, 2, 2, 2),
('2026-11-06 09:00:00', 'Pendiente', 'Chequeo de rutina', 3, 1, 1, 1),
('2026-11-06 15:00:00', 'Cancelada', 'El dueño no pudo asistir', 4, 3, 5, 3),
('2026-11-07 10:30:00', 'Pendiente', 'Corte de pelo', 5, 1, 3, 1),
('2026-11-08 08:00:00', 'Completada', 'Esterilización exitosa', 6, 2, 4, 2),
('2026-11-08 12:00:00', 'Pendiente', 'Refuerzo de vacuna', 1, 3, 2, 3),
('2026-11-09 15:00:00', 'Pendiente', 'Primera consulta y vacuna', 2, 1, 1, 4);

-- Agregando los productos

INSERT INTO Productos (nombre_producto, categoria, precio, stock) VALUES
('Alimento Premium Perro', 'Alimentos', 90.00, 50),
('Alimento Gato Adulto', 'Alimentos', 70.00, 30),
('Shampoo Antipulgas', 'Higiene', 25.00, 20),
('Toy Hueso', 'Accesorios', 10.00, 100),
('Collar Ajustable', 'Accesorios', 25.00, 40),
('Pelota', 'Accesorios', 10.00, 100),
('Bebedero', 'Accesorios', 30.00, 40);

