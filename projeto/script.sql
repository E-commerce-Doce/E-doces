-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema ameis
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ameis
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ameis` DEFAULT CHARACTER SET utf8 ;
USE `ameis` ;

-- -----------------------------------------------------
-- Table `ameis`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ameis`.`Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `cpf` VARCHAR(15) NULL,
  `papel` ENUM('CLIENTE', 'CONFEITEIRO', 'ADMINISTRADOR') NOT NULL DEFAULT 'CLIENTE',
  `nomeCompleto` VARCHAR(70) NOT NULL,
  `telefone` VARCHAR(15) NOT NULL,
  `login` VARCHAR(200) NOT NULL,
  `senha` VARCHAR(200) NOT NULL,
  `dataNascimento` DATE NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC) VISIBLE,
  UNIQUE INDEX `login_UNIQUE` (`login` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ameis`.`Confeiteiro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ameis`.`Confeiteiro` (
  `idConfeiteiro` INT NOT NULL AUTO_INCREMENT,
  `nomeLoja` VARCHAR(70) NOT NULL,
  `mei` VARCHAR(15) NOT NULL,
  `qrCode` VARCHAR(255) NOT NULL,
  `logo` VARCHAR(255) NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idConfeiteiro`),
  INDEX `fk_Confeiteiro_Usuario1_idx` (`idUsuario` ASC) VISIBLE,
  UNIQUE INDEX `idUsuario_UNIQUE` (`idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Confeiteiro_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `ameis`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ameis`.`Endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ameis`.`Endereco` (
  `idEndereco` INT NOT NULL AUTO_INCREMENT,
  `cep` VARCHAR(9) NOT NULL,
  `nomeLogradouro` VARCHAR(45) NOT NULL,
  `numero` INT NOT NULL,
  `bairro` VARCHAR(100) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `complemento` VARCHAR(45) NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idEndereco`),
  INDEX `fk_Endereco_Usuario1_idx` (`idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Endereco_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `ameis`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ameis`.`TipoDoce`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ameis`.`TipoDoce` (
  `idTipoDoce` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipoDoce`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ameis`.`Doce`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ameis`.`Doce` (
  `idDoces` INT NOT NULL AUTO_INCREMENT,
  `nomeDoce` VARCHAR(200) NOT NULL,
  `descricao` VARCHAR(200) NOT NULL,
  `caminhoImagem` VARCHAR(255) NOT NULL,
  `valor` FLOAT NOT NULL,
  `ingredientes` VARCHAR(500) NOT NULL,
  `idConfeiteiro` INT NOT NULL,
  `idTipoDoce` INT NOT NULL,
  PRIMARY KEY (`idDoces`),
  INDEX `fk_Doces_Confeiteiro1_idx` (`idConfeiteiro` ASC) VISIBLE,
  INDEX `fk_Doces_TipoDoce1_idx` (`idTipoDoce` ASC) VISIBLE,
  CONSTRAINT `fk_Doces_Confeiteiro1`
    FOREIGN KEY (`idConfeiteiro`)
    REFERENCES `ameis`.`Confeiteiro` (`idConfeiteiro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Doces_TipoDoce1`
    FOREIGN KEY (`idTipoDoce`)
    REFERENCES `ameis`.`TipoDoce` (`idTipoDoce`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ameis`.`Pedido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ameis`.`Pedido` (
  `idPedido` INT NOT NULL AUTO_INCREMENT,
  `idConfeiteiro` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  `formaPagamento` ENUM('PIX', 'DINHEIRO') NOT NULL,
  `status` ENUM('RECEBIDO', 'PREPARANDO', 'PRONTO', 'ENTREGUE', 'CANCELADO') NOT NULL,
  `horario` DATETIME NOT NULL,
  `tipo` ENUM('RETIRADA', 'DELIVERY') NOT NULL,
  `comprovante` VARCHAR(255) NULL,
  `nomeComprovante` VARCHAR(70) NULL,
  `idEndereco` INT ,
  PRIMARY KEY (`idPedido`),
  INDEX `fk_Pedidos_Confeiteiro1_idx` (`idConfeiteiro` ASC) VISIBLE,
  INDEX `fk_Pedidos_Usuario1_idx` (`idUsuario` ASC) VISIBLE,
  INDEX `fk_Pedido_Endereco1_idx` (`idEndereco` ASC) VISIBLE,
  CONSTRAINT `fk_Pedidos_Confeiteiro1`
    FOREIGN KEY (`idConfeiteiro`)
    REFERENCES `ameis`.`Confeiteiro` (`idConfeiteiro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pedidos_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `ameis`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pedido_Endereco1`
    FOREIGN KEY (`idEndereco`)
    REFERENCES `ameis`.`Endereco` (`idEndereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `ameis`.`Avaliacao`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS ameis.Avaliacao (
  idAvaliacao INT NOT NULL AUTO_INCREMENT,
  idPedido INT NOT NULL,
  nota INT NOT NULL CHECK (nota BETWEEN 1 AND 5),
  comentario TEXT NULL,
  idConfeiteiro INT NOT NULL,
  idUsuario INT NOT NULL, 
  PRIMARY KEY (idAvaliacao),
  FOREIGN KEY (idPedido) REFERENCES Pedido (idPedido) ON DELETE CASCADE,
  FOREIGN KEY (idConfeiteiro) REFERENCES Confeiteiro (idConfeiteiro) ON DELETE CASCADE,
  FOREIGN KEY (idUsuario) REFERENCES Usuario (idUsuario) ON DELETE CASCADE,
  INDEX (idPedido),
  INDEX (idConfeiteiro),
  INDEX (idUsuario)
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ameis`.`PedidoDoce`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ameis`.`PedidoDoce` (
  `idPedidoDoce` INT NOT NULL AUTO_INCREMENT,
  `idPedido` INT NOT NULL,
  `idDoce` INT NOT NULL,
  `quantidade` INT NOT NULL,
  `valorUnitario` FLOAT NOT NULL,
  `valorTotal` FLOAT NOT NULL,
  INDEX `fk_Pedidos_has_Doces_Doces1_idx` (`idDoce` ASC) VISIBLE,
  INDEX `fk_Pedidos_has_Doces_Pedidos1_idx` (`idPedido` ASC) VISIBLE,
  PRIMARY KEY (`idPedidoDoce`),
  CONSTRAINT `fk_Pedidos_has_Doces_Pedidos1`
    FOREIGN KEY (`idPedido`)
    REFERENCES `ameis`.`Pedido` (`idPedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pedidos_has_Doces_Doces1`
    FOREIGN KEY (`idDoce`)
    REFERENCES `ameis`.`Doce` (`idDoces`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
