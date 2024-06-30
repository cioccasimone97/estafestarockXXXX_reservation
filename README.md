# estafestarockXXXX_reservation

DB table:
CREATE TABLE `reservation` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `NOMINATIVO` varchar(255) NOT NULL,
 `TELEFONO` varchar(20) NOT NULL,
 `DATA` date NOT NULL,
 `ORA` time NOT NULL,
 `PERSONE` int(11) NOT NULL,
 `NOTE` text DEFAULT NULL,
 `RAND_UID` varchar(36) DEFAULT NULL,
 `IP_REQUEST` varchar(50) DEFAULT NULL,
 `FLGCONF` varchar(1) DEFAULT 'N' COMMENT 'flag confermato',
 `FLGANN` varchar(1) DEFAULT 'N' COMMENT 'flag annullato',
 `UPDTMS` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
 PRIMARY KEY (`ID`)
) 