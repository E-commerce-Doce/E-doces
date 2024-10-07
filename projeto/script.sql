-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Usuario` (
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
-- Table `Confeiteiro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Confeiteiro` (
  `idConfeiteiro` INT NOT NULL AUTO_INCREMENT,
  `nomeLoja` VARCHAR(70) NOT NULL,
  `mei` VARCHAR(15) NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idConfeiteiro`),
  INDEX `fk_Confeiteiro_Usuario1_idx` (`idUsuario` ASC) VISIBLE,
  UNIQUE INDEX `idUsuario_UNIQUE` (`idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Confeiteiro_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Endereco` (
  `idEndereco` INT NOT NULL AUTO_INCREMENT,
  `cep` VARCHAR(8) NOT NULL,
  `nomeLogradouro` VARCHAR(45) NOT NULL,
  `numero` INT NOT NULL,
  `bairro` VARCHAR(100) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `complemeto` VARCHAR(45) NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idEndereco`),
  INDEX `fk_Endereco_Usuario1_idx` (`idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Endereco_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TipoDoce`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TipoDoce` (
  `idTipoDoce` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipoDoce`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Doce`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Doce` (
  `idDoces` INT NOT NULL AUTO_INCREMENT,
  `nomeDoce` VARCHAR(200) NOT NULL,
  `descricao` VARCHAR(200) NOT NULL,
  `caminhoImagem` VARCHAR(255) NOT NULL,
  `valor` FLOAT NOT NULL,
  `ingredientes` VARCHAR(45) NOT NULL,
  `idConfeiteiro` INT NOT NULL,
  `idTipoDoce` INT NOT NULL,
  PRIMARY KEY (`idDoces`),
  INDEX `fk_Doces_Confeiteiro1_idx` (`idConfeiteiro` ASC) VISIBLE,
  INDEX `fk_Doces_TipoDoce1_idx` (`idTipoDoce` ASC) VISIBLE,
  CONSTRAINT `fk_Doces_Confeiteiro1`
    FOREIGN KEY (`idConfeiteiro`)
    REFERENCES `Confeiteiro` (`idConfeiteiro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Doces_TipoDoce1`
    FOREIGN KEY (`idTipoDoce`)
    REFERENCES `TipoDoce` (`idTipoDoce`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Pedido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Pedido` (
  `idPedidos` INT NOT NULL AUTO_INCREMENT,
  `idConfeiteiro` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  `formaPagamento` ENUM('PIX', 'DINHEIRO') NOT NULL,
  `avaliacao` VARCHAR(200) NULL,
  `status` ENUM('RECEBIDO', 'PREPARANDO', 'ENVIADO', 'ENTREGUE', 'CANCELADO') NOT NULL,
  `data` DATETIME NOT NULL,
  `idEndereco` INT NOT NULL,
  PRIMARY KEY (`idPedidos`),
  INDEX `fk_Pedidos_Confeiteiro1_idx` (`idConfeiteiro` ASC) VISIBLE,
  INDEX `fk_Pedidos_Usuario1_idx` (`idUsuario` ASC) VISIBLE,
  INDEX `fk_Pedido_Endereco1_idx` (`idEndereco` ASC) VISIBLE,
  CONSTRAINT `fk_Pedidos_Confeiteiro1`
    FOREIGN KEY (`idConfeiteiro`)
    REFERENCES `Confeiteiro` (`idConfeiteiro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pedidos_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pedido_Endereco1`
    FOREIGN KEY (`idEndereco`)
    REFERENCES `Endereco` (`idEndereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PedidosDoce`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PedidosDoce` (
  `pedidoDoceId` INT NOT NULL AUTO_INCREMENT,
  `idPedido` INT NOT NULL,
  `idDoce` INT NOT NULL,
  `quantidade` INT NOT NULL,
  `valorUnitario` FLOAT NOT NULL,
  `valorTotal` FLOAT NOT NULL,
  INDEX `fk_Pedidos_has_Doces_Doces1_idx` (`idDoce` ASC) VISIBLE,
  INDEX `fk_Pedidos_has_Doces_Pedidos1_idx` (`idPedido` ASC) VISIBLE,
  PRIMARY KEY (`pedidoDoceId`),
  CONSTRAINT `fk_Pedidos_has_Doces_Pedidos1`
    FOREIGN KEY (`idPedido`)
    REFERENCES `Pedido` (`idPedidos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pedidos_has_Doces_Doces1`
    FOREIGN KEY (`idDoce`)
    REFERENCES `Doce` (`idDoces`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Entrega`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Entrega` (
  `idEntrega` INT NOT NULL AUTO_INCREMENT,
  `horario` DATETIME NOT NULL,
  `tipo` ENUM('RETIRADA', 'DELIVERY') NOT NULL,
  `confirmacao` ENUM('SIM', 'NÃO') NOT NULL,
  `idEndereco` INT NOT NULL,
  `idPedidos` INT NOT NULL,
  PRIMARY KEY (`idEntrega`),
  INDEX `fk_Entrega_Endereco1_idx` (`idEndereco` ASC) VISIBLE,
  INDEX `fk_Entrega_Pedido1_idx` (`idPedidos` ASC) VISIBLE,
  CONSTRAINT `fk_Entrega_Endereco1`
    FOREIGN KEY (`idEndereco`)
    REFERENCES `Endereco` (`idEndereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Entrega_Pedido1`
    FOREIGN KEY (`idPedidos`)
    REFERENCES `Pedido` (`idPedidos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
