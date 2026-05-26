CREATE DATABASE IF NOT EXISTS pilkington_vistoria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pilkington_vistoria;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    login VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    perfil_acesso ENUM('Administrador', 'Gerente', 'Supervisor', 'Técnico') NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_alteracao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS itens_reparo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_reparo ENUM('Reparo de rachaduras', 'Troca completa') NOT NULL,
    classificacao_vidro ENUM('Para-brisa', 'Porta Dianteira Esquerda', 'Porta Dianteira Direita', 'Porta Traseira Esquerda', 'Porta Traseira Direita', 'Vigia', 'Lanternas', 'Faróis', 'Espelhos', 'Outros') NOT NULL,
    especificacao_outros VARCHAR(255),
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_alteracao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(20) NOT NULL,
    chassi VARCHAR(50),
    fabricante VARCHAR(100),
    modelo VARCHAR(100),
    ano_fabricacao INT,
    tipo_veiculo ENUM('Carro', 'Caminhão', 'Mini Van', 'Micro-ônibus', 'Outros') DEFAULT 'Carro',
    nome_proprietario VARCHAR(255),
    telefone_proprietario VARCHAR(50),
    item_reparo_id INT,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_alteracao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (item_reparo_id) REFERENCES itens_reparo(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS vistorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    veiculo_id INT NOT NULL,
    tecnico_id INT NOT NULL,
    data_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_fim DATETIME,
    status ENUM('Em Andamento', 'Concluído', 'Cancelado') DEFAULT 'Em Andamento',
    dados_reparo TEXT,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    assinatura_digital LONGTEXT,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_alteracao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (veiculo_id) REFERENCES veiculos(id),
    FOREIGN KEY (tecnico_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS fotos_vistoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vistoria_id INT NOT NULL,
    tipo_foto ENUM('Pre-Reparo', 'Pos-Reparo', 'Item-Antes', 'Item-Depois') NOT NULL,
    caminho_arquivo VARCHAR(255) NOT NULL,
    data_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vistoria_id) REFERENCES vistorias(id) ON DELETE CASCADE
);

-- Inserir usuário administrador padrão (senha: admin123)
INSERT INTO usuarios (nome_completo, email, login, senha_hash, perfil_acesso) 
VALUES ('Administrador Pilkington', 'admin@pilkington.com', 'admin', '$2y$12$MqAgQtgUTWDpEMLyx2XC.uTV9oEFyD64K.ZMgkm.j4vknDEW9ENXC', 'Administrador')
ON DUPLICATE KEY UPDATE login=login;
