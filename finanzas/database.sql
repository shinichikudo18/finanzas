CREATE DATABASE IF NOT EXISTS katherine_bank CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE katherine_bank;

CREATE TABLE IF NOT EXISTS cuentas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    banco VARCHAR(100) NOT NULL,
    tipo ENUM('bancaria', 'efectivo') DEFAULT 'bancaria',
    saldo DECIMAL(15,2) DEFAULT 0,
    color VARCHAR(20) DEFAULT '#00d4ff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    icono VARCHAR(20) DEFAULT '💰',
    color VARCHAR(20) DEFAULT '#FF6384',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categorias (nombre, icono, color) VALUES 
('Agua', '💧', '#36A2EB'),
('Luz', '⚡', '#FFCE56'),
('Gas', '🔥', '#FF6384'),
('Internet', '📡', '#4BC0C0'),
('Teléfono', '📱', '#9966FF'),
('Comida', '🍔', '#FF9F40'),
('Transporte', '🚗', '#C9CBCF'),
('Entretenimiento', '🎮', '#FF6384'),
('Salud', '🏥', '#4BC0C0'),
('Otro', '📦', '#C9CBCF');

CREATE TABLE IF NOT EXISTS pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_id INT NOT NULL,
    categoria_id INT NOT NULL,
    monto DECIMAL(15,2) NOT NULL,
    descripcion VARCHAR(255),
    fecha DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cuenta_id) REFERENCES cuentas(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);

CREATE TABLE ingresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_id INT NOT NULL,
    monto DECIMAL(15,2) NOT NULL,
    descripcion VARCHAR(255),
    fecha DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cuenta_id) REFERENCES cuentas(id) ON DELETE CASCADE
);