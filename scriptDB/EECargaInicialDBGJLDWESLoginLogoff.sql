/**
 * Author:  gonzalo.junlor
 * Created: 16 nov. 2025
 * Script de carga incial de base de datos
 */

use DBGJLDWESLoginLogoff;

insert into T02_Departamento values
        ('INF','Departamento de informatica.',now(),1235.5,null),
        ('AUT','Departamento de automocion.',now(),5235.8,null),
        ('ELE','Departamento de electricidad.',now(),2275.1,null),
        ('MAT','Departamento de matematicas.',now(),735.2,null),
        ('ING','Departamento de ingles.',now(),235.9,now())
;

INSERT INTO T01_Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario)
                VALUES
        ('vero',SHA2('veropaso',256),'Véro Grué'),
        ('heraclio',SHA2('heracliopaso',256),'Heraclio Borbujo'),
        ('alvaroA',SHA2('alvaroApaso',256),'Alvaro Allen'),
        ('alejandro',SHA2('alejandropaso',256),'Alejandro De La Huerga'),
        ('alvaroG',SHA2('alvaroGpaso',256),'Alvaro García'),
        ('gonzalo',SHA2('gonzalopaso',256),'Gonzalo Junquera'),
        ('cristian',SHA2('cristianpaso',256),'Cristian Mateos'),
        ('alberto',SHA2('albertopaso',256),'Alberto Méndez'),
        ('enrique',SHA2('enriquepaso',256),'Enrique Nieto'),
        ('james',SHA2('jamespaso',256),'James Edward Nuñez'),
        ('oscar',SHA2('oscarpaso',256),'Oscar Pozuelo'),
        ('jesus',SHA2('jesuspaso',256),'Enrique Nieto'),
        ('amor',SHA2('amorpaso',256),'Amor Rodriguez'),
        ('albertoB',SHA2('albertoBpaso',256),'Alberto Bahillo')
;

