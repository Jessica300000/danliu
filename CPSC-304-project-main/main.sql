Drop TABLE Deliver; 
Drop TABLE MOP;
Drop TABLE Assist; 
Drop TABLE VAW;
Drop TABLE Record; 
Drop TABLE CovidTest; 
Drop TABLE M_A; 
Drop TABLE ManagementSystem; 
Drop TABLE L_B;
Drop TABLE TravellingOutsideACountry; 
Drop TABLE TravellingWithinACountry; 
Drop TABLE QQ;  
Drop TABLE H_C; 
Drop TABLE Restaurant;


CREATE TABLE Restaurant (
RName CHAR(20),
RAddress CHAR(20),
PostalCode CHAR(10),
PRIMARY KEY (RName, RAddress)
);


CREATE TABLE H_C (
HName CHAR(20),
HAddress CHAR(20),
RoomNumber INTEGER,
RName CHAR(20),
RAddress CHAR(20),
PRIMARY KEY (HName, HAddress),
FOREIGN KEY (RName, RAddress) REFERENCES Restaurant
ON DELETE CASCADE
--ON UPDATE CASCADE
);

CREATE TABLE QQ (
ID CHAR(20) PRIMARY KEY,
QName CHAR(20),
Phone INTEGER,
VaccinationStatus INTEGER,
Check_inTime CHAR(20),
Check_outTime CHAR(20),
HName CHAR(20),
HAddress CHAR(20),
FOREIGN KEY (HName, HAddress) REFERENCES H_C
ON DELETE CASCADE
--ON UPDATE CASCADE
);


CREATE TABLE TravellingWithinACountry (
ID CHAR(20) PRIMARY KEY,
City CHAR(20),
FOREIGN KEY (ID) REFERENCES QQ
ON DELETE CASCADE
--ON UPDATE CASCADE
);

CREATE TABLE TravellingOutsideACountry (
ID CHAR(20) PRIMARY KEY,
Country CHAR(20),
FOREIGN KEY (ID) REFERENCES QQ
ON DELETE CASCADE
--ON UPDATE CASCADE
);


CREATE TABLE L_B (
LuggageID INTEGER,
ID CHAR(20),
LSize INTEGER,
Disinfected INTEGER,
PRIMARY KEY (LuggageID, ID),
FOREIGN KEY (ID) REFERENCES QQ
ON DELETE CASCADE
--ON UPDATE CASCADE
);

CREATE TABLE ManagementSystem (
StartDate CHAR(20),
EndDate CHAR(20),
TimeLength INTEGER,
RecordID INTEGER,
PRIMARY KEY (RecordID)
);

CREATE TABLE M_A (
 WorkerID INTEGER,
Gender CHAR(10),
Hospital CHAR(20),
RecordID INTEGER,
PRIMARY KEY (WorkerID),
FOREIGN KEY (RecordID) REFERENCES ManagementSystem
ON DELETE CASCADE
--ON UPDATE CASCADE
);

CREATE TABLE CovidTest (
 WorkerID INTEGER,
ID CHAR(20),
PRIMARY KEY (WorkerID, ID),
FOREIGN KEY (WorkerID) REFERENCES M_A
ON DELETE CASCADE,
--ON UPDATE CASCADE
FOREIGN KEY (ID) REFERENCES QQ
ON DELETE CASCADE
--ON UPDATE CASCADE
);


CREATE TABLE Record (
ID CHAR(20),
RecordID INTEGER,
PRIMARY KEY (RecordID, ID),
FOREIGN KEY (ID) REFERENCES QQ
ON DELETE CASCADE,
--ON UPDATE CASCADE
FOREIGN KEY (RecordID) REFERENCES ManagementSystem
ON DELETE CASCADE
--ON UPDATE CASCADE
);


CREATE TABLE VAW (
VolunteerID INTEGER,
Age INTEGER,
VName CHAR(20),
RecordID INTEGER,
HName CHAR(20),
HAddress CHAR(20) NOT NULL,
PRIMARY KEY (VolunteerID),
FOREIGN KEY (RecordID) REFERENCES ManagementSystem
ON DELETE CASCADE,
--ON UPDATE CASCADE
FOREIGN KEY (HName, HAddress) REFERENCES H_C
ON DELETE CASCADE
--ON UPDATE CASCADE
);


CREATE TABLE Assist (
 VolunteerID INTEGER,
ID CHAR(20),
PRIMARY KEY (VolunteerID, ID),
FOREIGN KEY (VolunteerID) REFERENCES VAW
ON DELETE CASCADE,
--ON UPDATE CASCADE
FOREIGN KEY (ID) REFERENCES QQ
ON DELETE CASCADE
--ON UPDATE CASCADE
);

CREATE TABLE MOP (
MealID INTEGER,
Price INTEGER,
Mealtime CHAR(10),
ID CHAR(20),
RName CHAR(20),
RAddress CHAR(20),
PRIMARY KEY (MealID),
FOREIGN KEY (ID) REFERENCES QQ
ON DELETE CASCADE,
--ON UPDATE CASCADE
FOREIGN KEY (RName, RAddress) REFERENCES Restaurant
ON DELETE CASCADE
--ON UPDATE CASCADE
);


CREATE TABLE Deliver (
 VolunteerID INTEGER,
MealID INTEGER,
PRIMARY KEY (VolunteerID, MealID),
FOREIGN KEY (VolunteerID) REFERENCES VAW
ON DELETE CASCADE,
--ON UPDATE CASCADE
FOREIGN KEY (MealID) REFERENCES MOP
ON DELETE CASCADE
--ON UPDATE CASCADE
);

INSERT
INTO Restaurant (RName, RAddress, PostalCode)
VALUES ('SuperDilicious', '135 Williams Rd', 'V7C5S8');

INSERT
INTO Restaurant (RName, RAddress, PostalCode)
VALUES('37 Pho', '268 16 Ave', 'V6Y4H6');

INSERT
INTO Restaurant (RName, RAddress, PostalCode)
VALUES('HaiDiLao', '238 Broadway St', 'V5H3C9');

INSERT
INTO Restaurant (RName, RAddress, PostalCode)
VALUES('NiceBurger', '10018 Gilbert Rd', 'V7S6X3');

INSERT
INTO Restaurant (RName, RAddress, PostalCode)
VALUES('Ginger', '4666 Ferguson Rd', 'V4M8T2');


INSERT
INTO H_C (HName, HAddress, RoomNumber, RName, RAddress)
VALUES ('As Home', '1345 Williams Rd', 200, 'SuperDilicious', '135 Williams Rd');

INSERT
INTO H_C (HName, HAddress, RoomNumber, RName, RAddress)
VALUES('7 Days', '268 14 Ave', 150, '37 Pho', '268 16 Ave');

INSERT
INTO H_C (HName, HAddress, RoomNumber, RName, RAddress)
VALUES('Holiday Inn', '134 Broadway St', 220, '37 Pho', '268 16 Ave');

INSERT
INTO H_C (HName, HAddress, RoomNumber, RName, RAddress)
VALUES('Super 8', '10118 Gilbert Rd', 180, 'NiceBurger', '10018 Gilbert Rd');

INSERT
INTO H_C (HName, HAddress, RoomNumber, RName, RAddress)
VALUES('Sheraton', '4606 Ferguson Rd', 300, 'Ginger', '4666 Ferguson Rd');

INSERT
INTO ManagementSystem (StartDate, EndDate, TimeLength , RecordID)
VALUES ('2021-10-10', '2021-10-24', 14, 100001);

INSERT
INTO ManagementSystem (StartDate, EndDate, TimeLength , RecordID)
VALUES ('2021-11-8', '2021-11-15', 7, 100002);

INSERT
INTO ManagementSystem (StartDate, EndDate, TimeLength , RecordID)
VALUES ('2021-11-10', '2021-11-17', 7, 100003);

INSERT
INTO ManagementSystem (StartDate, EndDate, TimeLength , RecordID)
VALUES ('2021-12-9', '2021-12-16', 7, 100004);

INSERT
INTO ManagementSystem (StartDate, EndDate, TimeLength , RecordID)
VALUES ('2021-12-10', '2021-12-17', 7, 100005);

INSERT
INTO ManagementSystem (StartDate, EndDate, TimeLength , RecordID)
VALUES ('2021-10-10', '2021-10-24', 14, 100006);

INSERT
INTO ManagementSystem (StartDate, EndDate, TimeLength , RecordID)
VALUES ('2021-11-8', '2021-11-15', 7, 100007);

INSERT
INTO ManagementSystem (StartDate, EndDate, TimeLength , RecordID)
VALUES ('2021-11-10', '2021-11-17',7, 100008);

INSERT
INTO ManagementSystem (StartDate, EndDate, TimeLength , RecordID)
VALUES ('2021-12-9', '2021-12-16', 7, 100009);

INSERT
INTO ManagementSystem (StartDate, EndDate, TimeLength , RecordID)
VALUES ('2021-12-10', '2021-12-17', 7, 100010);


INSERT
INTO QQ (ID, QName, Phone, VaccinationStatus, Check_inTime, Check_outTime, HName, HAddress)
VALUES ('E3579124', 'Robert Wang', 17788987114, 3, '2021-10-10', '2021-10-24', 'As Home', '1345 Williams Rd');

INSERT
INTO QQ (ID, QName, Phone, VaccinationStatus, Check_inTime, Check_outTime, HName, HAddress)
VALUES('G9123574', 'Juvenal Rais', 16046867812, 2, '2021-11-8', '2021-11-15', '7 Days', '268 14 Ave');

INSERT
INTO QQ (ID, QName, Phone, VaccinationStatus,Check_inTime , Check_outTime, Haddress, HName)
VALUES('L3546594', 'Itai Tomic', 12359741455, 2, '2021-11-10', '2021-11-17', '134 Broadway St', 'Holiday Inn');

INSERT
INTO QQ (ID, QName, Phone, VaccinationStatus,Check_inTime , Check_outTime, Haddress, HName)
VALUES('342687952', 'Augustina Gupta', 17787555169, 3, '2021-12-9', '2021-12-16','10118 Gilbert Rd', 'Super 8');

INSERT
INTO QQ (ID, QName, Phone, VaccinationStatus,Check_inTime , Check_outTime, Haddress, HName)
VALUES('798563128', 'Rozalija Banner', 16048187970, 1, '2021-12-10', '2021-12-17', '1345 Williams Rd', 'As Home');

INSERT
INTO QQ (ID, QName, Phone, VaccinationStatus,Check_inTime , Check_outTime, Haddress, HName)
VALUES('EG5134124', 'Gracey Mcneill', 19887117784, 3, '2021-10-10', '2021-10-24', '1345 Williams Rd', 'As Home');

INSERT
INTO QQ (ID, QName, Phone, VaccinationStatus,Check_inTime , Check_outTime, Haddress, HName)
VALUES('LX91489574', 'Kiara Hastings', 16867604812, 2, '2021-11-8', '2021-11-15', '268 14 Ave', '7 Days');

INSERT
INTO QQ (ID, QName, Phone, VaccinationStatus,Check_inTime , Check_outTime, Haddress, HName)
VALUES('789142857', 'Kaydan Lam', 12351455974, 2, '2021-11-10', '2021-11-17', '134 Broadway St', 'Holiday Inn');

INSERT
INTO QQ (ID, QName, Phone, VaccinationStatus,Check_inTime , Check_outTime, Haddress, HName)
VALUES('742578891', 'Aled Reilly', 17787732519, 3, '2021-12-9', '2021-12-16', '10118 Gilbert Rd', 'Super 8');

INSERT
INTO QQ (ID, QName, Phone, VaccinationStatus,Check_inTime , Check_outTime, Haddress, HName)
VALUES('127985638', 'Alaw Sampson', 16049741970, 2, '2021-12-10', '2021-12-17', '4606 Ferguson Rd', 'Sheraton');

INSERT
INTO TravellingWithinACountry (ID, City)
VALUES ('342687952', 'Kelowna');

INSERT
INTO TravellingWithinACountry (ID, City)
VALUES('798563128', 'London');

INSERT
INTO TravellingWithinACountry (ID, City)
VALUES('789142857', 'Vancouver');

INSERT
INTO TravellingWithinACountry (ID, City)
VALUES('742578891', 'Toronto');

INSERT
INTO TravellingWithinACountry (ID, City)
VALUES('127985638', 'Calgary');

INSERT
INTO TravellingOutsideACountry (ID, Country)
VALUES ('EG5134124', 'Japan');

INSERT
INTO TravellingOutsideACountry (ID, Country)
VALUES ('LX91489574', 'Russa');

INSERT
INTO TravellingOutsideACountry (ID, Country)
VALUES ('E3579124', 'China');

INSERT
INTO TravellingOutsideACountry (ID, Country)
VALUES ('G9123574', 'UK');

INSERT
INTO TravellingOutsideACountry (ID, Country)
VALUES ('L3546594', 'USA');

INSERT
INTO L_B (LuggageID, ID, LSize, Disinfected)
VALUES (101, 'E3579124', 2, 1);

INSERT
INTO L_B (LuggageID, ID, LSize, Disinfected)
VALUES (102, 'G9123574', 1, 1);

INSERT
INTO L_B (LuggageID, ID, LSize, Disinfected)
VALUES (103, 'L3546594', 3, 1);

INSERT
INTO L_B (LuggageID, ID, LSize, Disinfected)
VALUES (104, '342687952', 2, 0);

INSERT
INTO L_B (LuggageID, ID, LSize, Disinfected)
VALUES (105, '798563128', 3, 1);

INSERT
INTO L_B (LuggageID, ID, LSize, Disinfected)
VALUES (106, 'EG5134124', 3, 0);

INSERT
INTO L_B (LuggageID, ID, LSize, Disinfected)
VALUES (107, 'LX91489574', 2, 1);

INSERT
INTO L_B (LuggageID, ID, LSize, Disinfected)
VALUES (108, '789142857', 1, 0);

INSERT
INTO L_B (LuggageID, ID, LSize, Disinfected)
VALUES (109, '742578891', 1, 1);

INSERT
INTO L_B (LuggageID, ID, LSize, Disinfected)
VALUES (110, '127985638', 2, 1);

INSERT
INTO M_A (WorkerID, Gender, Hospital, RecordID)
VALUES (25389, 'M', 'VGH', 100001);

INSERT
INTO M_A (WorkerID, Gender, Hospital, RecordID)
VALUES (35389, 'M', 'VGH', 100002);

INSERT
INTO M_A (WorkerID, Gender, Hospital, RecordID)
VALUES (46877, 'F', 'SPH', 100003);

INSERT
INTO M_A (WorkerID, Gender, Hospital, RecordID)
VALUES (26877, 'F', 'SPH', 100004);

INSERT
INTO M_A (WorkerID, Gender, Hospital, RecordID)
VALUES (35125, 'F', 'VGH', 100005);

INSERT
INTO M_A (WorkerID, Gender, Hospital, RecordID)
VALUES (53897, 'F', 'RH', 100006);

INSERT
INTO M_A (WorkerID, Gender, Hospital, RecordID)
VALUES (53801, 'F', 'RH', 100008);

INSERT
INTO M_A (WorkerID, Gender, Hospital, RecordID)
VALUES (33897, 'F', 'RH', 100009);

INSERT
INTO M_A (WorkerID, Gender, Hospital, RecordID)
VALUES (14091, 'M', 'SPH', 100010);

INSERT
INTO M_A (WorkerID, Gender, Hospital, RecordID)
VALUES (14080, 'M', 'SPH', 100007);

INSERT
INTO CovidTest (WorkerID, ID)
VALUES (25389, 'E3579124');

INSERT
INTO CovidTest (WorkerID, ID)
VALUES (25389, 'G9123574');

INSERT
INTO CovidTest (WorkerID, ID)
VALUES (26877, 'L3546594');

INSERT
INTO CovidTest (WorkerID, ID)
VALUES (26877, '342687952');

INSERT
INTO CovidTest (WorkerID, ID)
VALUES (35125, '798563128');

INSERT
INTO CovidTest (WorkerID, ID)
VALUES (53897, 'EG5134124');

INSERT
INTO CovidTest (WorkerID, ID)
VALUES (14080, 'LX91489574');

INSERT
INTO CovidTest (WorkerID, ID)
VALUES (53897, '789142857');

INSERT
INTO CovidTest (WorkerID, ID)
VALUES (53897, '742578891');

INSERT
INTO CovidTest (WorkerID, ID)
VALUES (14080, '127985638');


INSERT
INTO Record (ID, RecordID)
VALUES ('E3579124', 100001);

INSERT
INTO Record (ID, RecordID)
VALUES ('G9123574', 100002);

INSERT
INTO Record (ID, RecordID)
VALUES ('L3546594', 100003);

INSERT
INTO Record (ID, RecordID)
VALUES ('342687952', 100004);

INSERT
INTO Record (ID, RecordID)
VALUES ('798563128', 100005);

INSERT
INTO Record (ID, RecordID)
VALUES ('EG5134124', 100006);

INSERT
INTO Record (ID, RecordID)
VALUES ('LX91489574', 100007);

INSERT
INTO Record (ID, RecordID)
VALUES ('789142857', 100008);

INSERT
INTO Record (ID, RecordID)
VALUES ('742578891', 100009);

INSERT
INTO Record (ID, RecordID)
VALUES ('127985638', 100010);

INSERT
INTO VAW (VolunteerID, Age, VName, RecordID, HName, HAddress)
VALUES (101, 22, 'Rob', 100001, 'As Home', '1345 Williams Rd');

INSERT
INTO VAW (VolunteerID, Age, VName, RecordID, HName, HAddress)
VALUES (102, 25, 'Bill', 100002, '7 Days', '268 14 Ave');

INSERT
INTO VAW (VolunteerID, Age, VName, RecordID, HName, HAddress)
VALUES (103, 20, 'Kevin', 100003, 'Holiday Inn', '134 Broadway St');

INSERT
INTO VAW (VolunteerID, Age, VName, RecordID, HName, HAddress)
VALUES (104, 30, 'Leo', 100009, 'Super 8', '10118 Gilbert Rd');

INSERT
INTO VAW (VolunteerID, Age, VName, RecordID, HName, HAddress)
VALUES (106, 26, 'Annie', 100004, 'Super 8', '10118 Gilbert Rd');

INSERT
INTO VAW (VolunteerID, Age, VName, RecordID, HName, HAddress)
VALUES (105, 28, 'Sarah', 100010, 'Sheraton', '4606 Ferguson Rd');

INSERT
INTO Assist (VolunteerID , ID)
VALUES (101, 'E3579124');

INSERT
INTO Assist (VolunteerID , ID)
VALUES (101, '798563128');

INSERT
INTO Assist (VolunteerID , ID)
VALUES (102, 'G9123574');

INSERT
INTO Assist (VolunteerID , ID)
VALUES(103, 'L3546594');

INSERT
INTO Assist (VolunteerID , ID)
VALUES (105, '127985638');

INSERT
INTO Assist (VolunteerID , ID)
VALUES (106, '342687952');

INSERT
INTO Assist (VolunteerID , ID)
VALUES (104, '742578891');

INSERT
INTO MOP (MealID, Price, Mealtime, ID, RName, RAddress)
VALUES (1001, 10, 0, 'E3579124', 'SuperDilicious', '135 Williams Rd');

INSERT
INTO MOP (MealID, Price, Mealtime, ID, RName, RAddress)
VALUES (1006, 25, 0, 'G9123574', 'SuperDilicious', '135 Williams Rd');

INSERT
INTO MOP (MealID, Price, Mealtime, ID, RName, RAddress)
VALUES (1010, 20, 0, '127985638', 'Ginger', '4666 Ferguson Rd');

INSERT
INTO MOP (MealID, Price, Mealtime, ID, RName, RAddress)
VALUES (1002, 30, 1, 'G9123574', '37 Pho', '268 16 Ave');

INSERT
INTO MOP (MealID, Price, Mealtime, ID, RName, RAddress)
VALUES (1003, 35, 1, 'L3546594', '37 Pho', '268 16 Ave');

INSERT
INTO MOP (MealID, Price, Mealtime, ID, RName, RAddress)
VALUES (1009, 25, 1, 'E3579124', 'SuperDilicious', '135 Williams Rd');

INSERT
INTO MOP (MealID, Price, Mealtime, ID, RName, RAddress)
VALUES (1007, 40, 2, 'G9123574', 'NiceBurger', '10018 Gilbert Rd');

INSERT
INTO MOP (MealID, Price, Mealtime, ID, RName, RAddress)
VALUES (1004, 45, 2, '342687952', 'NiceBurger', '10018 Gilbert Rd');

INSERT
INTO MOP (MealID, Price, Mealtime, ID, RName, RAddress)
VALUES (1005, 55, 2, '127985638', 'Ginger', '4666 Ferguson Rd');

INSERT
INTO MOP (MealID, Price, Mealtime, ID, RName, RAddress)
VALUES (1008, 30, 2, 'E3579124', 'Ginger', '4666 Ferguson Rd');

INSERT
INTO Deliver (VolunteerID , MealID)
VALUES (101, 1001);

INSERT
INTO Deliver (VolunteerID , MealID)
VALUES (102, 1002);

INSERT
INTO Deliver (VolunteerID , MealID)
VALUES (103, 1003);

INSERT
INTO Deliver (VolunteerID , MealID)
VALUES (106, 1004);

INSERT
INTO Deliver (VolunteerID , MealID)
VALUES (105,1005);

COMMIT WORK;
