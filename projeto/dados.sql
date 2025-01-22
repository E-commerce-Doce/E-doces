
/*senha root*/
INSERT INTO Usuario (cpf, papel, nomeCompleto, telefone, login, senha, dataNascimento) VALUES
('123.456.789-50', 'ADMINISTRADOR', 'ADM', '(45) 99912-9999', 'ameis.contato@gmail.com', '$2y$10$9H8nNzW7tM7cGhy6r59gYuKuflEGKzKGOMPv86yUhJbySUNnnY42y', '2000-11-30');

INSERT INTO Confeiteiro (nomeLoja, mei, qrCode, idUsuario)
VALUES ('Minha Loja', '12345678901234', 'arquivo_d0fa276e-1d60-0bcf-b70f-80799c5d4b32.png', 2);

UPDATE Usuario 
SET papel = 'CONFEITEIRO'
WHERE idUsuario = 2;

INSERT INTO TipoDoce (descricao) VALUES
('Torta'),('Bolo'), ('Trufa'),('Cookie'),('Brownie'), ('Brigadeiro');