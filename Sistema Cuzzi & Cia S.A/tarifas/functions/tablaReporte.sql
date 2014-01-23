CREATE SEQUENCE sq_Reporte
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 99999999
  START 1
  cache 1;
ALTER TABLE sq_Reporte OWNER TO enterprisedb;

--drop table Reportefinal
create table Reportefinal(
idReporte  numeric (9) NOT NULL DEFAULT nextval('sq_Reporte'::regclass),
costo1 numeric(8,2),
costo2 numeric(8,2),
costo3 numeric(8,2),
costo4 numeric(8,2),
costo5 numeric(8,2),
costo6 numeric(8,2),
costo7 numeric(8,2),
costo8 numeric(8,2),
costo9 numeric(8,2),
costo10 numeric(8,2),
costo11 numeric(8,2),
costo12 numeric(8,2),
CONSTRAINT pk_idReporte PRIMARY KEY (idReporte)
)WITH (OIDS=TRUE);
ALTER TABLE categoria OWNER TO enterprisedb;


/*INSERT INTO reportefinal(
            costo1, costo2, costo3, costo4, costo5, costo6, 
            costo7, costo8, costo9, costo10, costo11, costo12)
    VALUES (121112.36, 12.57, 12.24,12, 12, 12, 12, 
            12, 12,12, 12, 12);*/

--select * from reportefinal 


--truncate table reportefinal
--ALTER SEQUENCE sq_reporte RESTART WITH 1