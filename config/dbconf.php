<?php
/*
	$driver 	= PPOConnection::_PDO_MSSQLSRV;
	$server 	= "CAIXASQLP425\CAIXASQLP425";
	$database 	= "SIOPM";
	$port 		= "";
	$user 		= "s554801";
	$password 	= "S10pm_Gef0m";
	$encode 	= PPOEntityManager::ISO_8859_1_ENCODE; 
*/
/*

Ao
Alan - GIFUG/SP
Senhor (a) Desenvolvedor (a),
1.       Informamos que foi liberado acesso ao servidor SQL para uso da aplicação “SIOPM”

Servidor: CAIXASQLP425\CAIXASQLP425
Database: CANAL_UNIDADES

Login 	Senha 	Default Schema 	Ambiente
s552720 hpKa8q  siopm 			Produção
s552721 homPk52 siopmhom 		Homologação
 
2.       O(s) desenvolvedor(es) deve(m) utilizar o mesmo login/senha para se conectar ao ambiente SQL selecionando o modo “SQL Server authentication”.
3.       As tabelas, views, stored procedures e functions dessa aplicação devem ser criadas com o schema “siopm” ou “siopmhom”. Ex: Create Procedure siopm.sp_carga, select * from siopmhom.tabela. 
3.1.    Schema é uma coleção de objetos dentro de um determinado banco de dados que serve para agrupá-los no nível de aplicação.
3.2.    Essa prática foi adotada pela GERFU para obter uma melhor organização e controle na administração do banco de dados.

Atenciosamente,
Fernanda C. Maurício
Consultora Matriz
GN Gestão da Rede FGTS

Valdemar Barbosa
Gerente Executivo
GN Gestão da Rede FGTS

*/

	$driver 	= PPOConnection::_PDO_MSSQLSRV;
	$server 	= "DF7436SR659";
	$database 	= "CANAL_UNIDADES";
	$port 		= "";
	$user 		= "s552720";
	$password 	= "hpKa8q";	

	$encode 	= PPOEntityManager::ISO_8859_1_ENCODE; 

	if (!isset($_SERVER["AUTH_USER"])) $server = "GEEKBOOK\SQLEXPRESS";

?>
