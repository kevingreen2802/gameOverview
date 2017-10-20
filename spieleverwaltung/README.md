# Spieleverwaltung

Mein erstes Projekt als Azubi bei der DZH.

Dieses Projekt dient der Verwaltung von Videospielen.

Vor dem ersten Ausführen muss das Script **[spieleverwaltung.sql](spieleverwaltung.sql)** ausgeführt werden.

###Filtern von Einträgen

Es kann nach bestimmten Einträgen gefiltert werden. Dieses wir mit Hilfe von verschiedenen Operatoren mit voranstehendem **"?"** an die URL angehängt.
Nach folgenden Kriterien kann gesucht werden:


| Operator    	|           Funktion          	|
|-------------	|:---------------------------:	|
| ?name=[**Spielename**]      	| Sucht nach  **Spielenamen** 	|
| ?developer=[**Entwickler**] 	|  Sucht nach  **Entwickler** 	|
| ?device=[**Gerät**]    	|    Sucht nach  **Gerät**    	|
| ?company=[**Hersteller**]  	|  Sucht nach **Hersteller**  	|
| ?medium=[**Mediumtyp**]    	|    Sucht nach **Mediumtyp**   |

Zusätzlich wurde eine Suchfunktion implementiert, welche die Suche erleichtert. Es ist auch möglich, nach mehreren Parametern zu filtern.
