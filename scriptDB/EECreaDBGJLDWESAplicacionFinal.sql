/**
 * Author:  gonzalo.junlor
 * Created: 04/02/2026
 * Script de creación de base de datos
 */

create table if not exists DBGJLDWESAplicacionFinal.T02_Departamento(
    T02_CodDepartamento varchar(3) primary key,
    T02_DescDepartamento varchar(255),
    T02_FechaCreacionDepartamento datetime not null,
    T02_VolumenDeNegocio float null,
    T02_FechaBajaDepartamento datetime null
)engine=innodb;

create table if not exists DBGJLDWESAplicacionFinal.T01_Usuario(
    T01_CodUsuario varchar(10) not null primary key,
    T01_Password varchar(64) not null,
    T01_DescUsuario varchar(255) not null,
    T01_NumConexiones int not null default 0,
    T01_FechaHoraUltimaConexion datetime default null,
    T01_Perfil varchar (100) not null default 'usuario',
    T01_ImagenUsuario BLOB default null
)engine=innodb;

alter table DBGJLDWESAplicacionFinal.T02_Departamento 
add column T02_Usuario varchar(10), 
add column T02_Timestamp datetime;

create table if not exists DBGJLDWESAplicacionFinal.T03_Trazabilidad(
    T03_Usuario varchar(10),
    T03_Timestamp datetime,
    T03_Operacion varchar(100),
    T03_NombreTabla varchar(100),
    T03_MasInformacion varchar(255)
)engine=innodb;
