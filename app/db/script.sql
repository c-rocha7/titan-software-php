CREATE TABLE tbl_usuario (
	id_usuario BIGINT AUTO_INCREMENT PRIMARY KEY,
	login VARCHAR(50),
	senha VARCHAR(32),
	ativo BOOLEAN DEFAULT 1
);

CREATE TABLE tbl_empresa (
	id_empresa BIGINT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(40),
	ativo BOOLEAN DEFAULT 1
);

CREATE TABLE tbl_funcionario (
	id_funcionario BIGINT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(50),
	cpf VARCHAR(11),
	rg VARCHAR(20),
	email VARCHAR(30),
	id_empresa BIGINT,
	data_cadastro DATE,
	salario DOUBLE(10,2),
	bonificacao DOUBLE(10,2),
	ativo BOOLEAN DEFAULT 1
);

INSERT INTO tbl_usuario (login, senha) VALUES 
	('teste@gmail.com', md5('1234'));

INSERT INTO tbl_empresa (id_empresa, nome, ativo) VALUES 
	(1, 'Tech Solutions', 1),
	(2, 'Global Services', 1),
	(3, 'Inova Tecnologia', 1),
	(4, 'SoftWareHouse', 0),
	(5, 'Business Corp', 0);

INSERT INTO tbl_funcionario (id_funcionario, nome, cpf, rg, email, id_empresa, data_cadastro, salario, bonificacao, ativo) VALUES 
	(1, 'João Silva', '98880095080', '209766761', 'joao.silva@email.com', 1, '2019-01-15', 3500.00, 700.00, 1),
	(2, 'Maria Oliveira', '998880095080', '209766761', 'maria.oliveira@email.com', 2, '2023-06-10', 4000.00, 0.00, 1),
	(3, 'Carlos Souza', '98880095080', '209766761', 'carlos.souza@email.com', 3, '2020-08-20', 3000.00, 300.00, 0),
	(4, 'Ana Costa', '98880095080', '209766761', 'ana.costa@email.com', 1, '2018-03-05', 4200.00, 840.00, 1),
	(5, 'Pedro Santos', '98880095080', '209766761', 'pedro.santos@email.com', 2, '2024-01-01', 5000.00, 0.00, 0),
	(6, 'Fernanda Lima', '98880095080', '209766761', 'fernanda.lima@email.com', 3, '2021-11-12', 3700.00, 370.00, 1),
	(7, 'Rafael Martins', '98880095080', '209766761', 'rafael.martins@email.com', 1, '2017-09-30', 3200.00, 640.00, 1),
	(8, 'Beatriz Almeida', '98880095080', '209766761', 'beatriz.almeida@email.com', 2, '2022-05-25', 4800.00, 480.00, 1),
	(9, 'Gabriel Rocha', '98880095080', '209766761', 'gabriel.rocha@email.com', 3, '2025-01-10', 4500.00, 0.00, 1),
	(10, 'Larissa Ferreira', '98880095080', '209766761', 'larissa.ferreira@email.com', 1, '2020-02-20', 5200.00, 520.00, 0);
