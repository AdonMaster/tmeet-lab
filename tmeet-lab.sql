/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50731
Source Host           : localhost:3306
Source Database       : tmeet-lab

Target Server Type    : MYSQL
Target Server Version : 50731
File Encoding         : 65001

Date: 2021-12-20 13:24:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for arquivos_conta
-- ----------------------------
DROP TABLE IF EXISTS `arquivos_conta`;
CREATE TABLE `arquivos_conta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_arquivo` varchar(255) DEFAULT '',
  `data_insercao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for contas_claro_upload
-- ----------------------------
DROP TABLE IF EXISTS `contas_claro_upload`;
CREATE TABLE `contas_claro_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conta` int(11) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuario_upload` int(11) DEFAULT NULL,
  `data_inicio` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `data_fim` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `nome_arquivo` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for sms_operadoras
-- ----------------------------
DROP TABLE IF EXISTS `sms_operadoras`;
CREATE TABLE `sms_operadoras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `origem` bigint(16) NOT NULL,
  `destino` bigint(16) NOT NULL,
  `valor_operadora` decimal(6,2) DEFAULT NULL,
  `valor_cliente` decimal(6,2) DEFAULT NULL,
  `fatura` int(11) DEFAULT NULL,
  `operadora` int(11) DEFAULT NULL,
  `cli_id` int(11) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `conta_operadora` int(11) DEFAULT NULL,
  `data_sms` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `data_inicio` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `data_fim` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `data_envio` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `conta` bigint(20) DEFAULT NULL,
  `linha_arquivo` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `tipo_servico` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24945 DEFAULT CHARSET=latin1;
