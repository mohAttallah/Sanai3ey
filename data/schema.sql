
DROP DATABASE SANAI3Y;
CREATE DATABASE  SANAI3Y;
USE SANAI3Y;

CREATE TABLE Admin (
ID_Admin  int NOT NULL UNIQUE,
 PRIMARY KEY (ID_Admin ) 
);

CREATE TABLE Customer (
ID_Customer int NOT NULL UNIQUE,
 PRIMARY KEY (ID_Customer) 
);

CREATE TABLE Technical (
ID_Technical int  NOT NULL UNIQUE,
Category_name varchar(30),
Project_Done varchar(30),
Bio varchar(255),
PRIMARY KEY(ID_Technical)
);

CREATE TABLE User (
ID_User int NOT NULL AUTO_INCREMENT UNIQUE,
ID_account int NOT NULL,
First_Name varchar(20),
Last_Name varchar(20),
Gender ENUM('m','f'),
Photo BLOB,
Date_Join  Date,          
Email varchar(255) ,
Phone_Number varchar(25),
District varchar(255) ,
City_Name varchar(255),
ID_Customer int NOT NULL,
ID_Admin  int NOT NULL,
ID_Technical int NOT NULL,
PRIMARY KEY (ID_User),
FOREIGN KEY (ID_Customer) REFERENCES Customer(ID_Customer),
FOREIGN KEY (ID_Admin) REFERENCES Admin(ID_Admin),
FOREIGN KEY (ID_Technical) REFERENCES Technical (ID_Technical)
);

CREATE TABLE Report(
ID_Report int NOT NULL,
PRIMARY KEY (ID_Report)
);

CREATE TABLE Account(
ID_Account int NOT NULL,
Password varchar(255) ,
Status varchar(255),
Account_Type varchar(255),
PRIMARY KEY (ID_Account) 
);

CREATE TABLE Follow (
ID_Follow    int  NOT NULL UNIQUE,
ID_Technical int,
ID_Customer int,
PRIMARY KEY(ID_Follow),
FOREIGN KEY (ID_Customer) REFERENCES Customer (ID_Customer),
FOREIGN KEY (ID_Technical) REFERENCES Technical (ID_Technical)
);

CREATE TABLE Message(
ID_Message int  NOT NULL UNIQUE,
Status varchar(30),
Date_Sent datetime,
Message_Text varchar(350),
Date_Receive datetime,
ID_Technical int NOT NULL,
ID_Customer int NOT NULL,
PRIMARY KEY(ID_Message),
FOREIGN KEY (ID_Customer) REFERENCES Customer(ID_Customer),
FOREIGN KEY (ID_Technical) REFERENCES Technical (ID_Technical)
);

CREATE TABLE Request(
ID_Request int NOT NULL,
Request_Content varchar(250),
Request_Date Date,
State varchar(250),
Max_price double,
Category_Name varchar(150),
ID_Technical int NOT NULL,
ID_Customer int NOT NULL,
PRIMARY KEY(ID_Request),
FOREIGN KEY (ID_Customer) REFERENCES Customer (ID_Customer),
FOREIGN KEY (ID_Technical) REFERENCES Technical (ID_Technical)
);

CREATE TABLE Service(
ID_Service int NOT NULL,
Description varchar(250),
Service_Date Date,
price double,
Category_Name varchar(150),
ID_Technical int NOT NULL,
PRIMARY KEY(ID_Service),
FOREIGN KEY (ID_Technical) REFERENCES Technical (ID_Technical)
);

CREATE TABLE Order_Service(
ID_Order int NOT NULL,
State varchar(250),
description varchar(250),
Rate float,
Creation_Date date,   
ID_Service int NOT NULL,
ID_Customer int NOT NULL,
PRIMARY KEY(ID_Order),
FOREIGN KEY (ID_Customer) REFERENCES Customer(ID_Customer),
FOREIGN KEY (ID_Service) REFERENCES Service (ID_Service)
);


CREATE TABLE Issue(
Description varchar(350),
Date_Report date,
ID_Technical int NOT NULL,
ID_Customer int NOT NULL,
ID_Service int NOT NULL,
ID_Report int NOT NULL,
ID_User int NOT NULL,
FOREIGN KEY (ID_User) REFERENCES User (ID_User),
FOREIGN KEY (ID_Report) REFERENCES Report (ID_Report),
FOREIGN KEY (ID_Service) REFERENCES Service (ID_Service),
FOREIGN KEY (ID_Customer) REFERENCES Customer(ID_Customer),
FOREIGN KEY (ID_Technical) REFERENCES Technical (ID_Technical)
);

CREATE TABLE Likes(
Time_Stamp Timestamp,
ID_Technical int NOT NULL,
ID_Request int NOT NULL,
FOREIGN KEY (ID_Request) REFERENCES Request (ID_Request),
FOREIGN KEY (ID_Technical) REFERENCES Technical (ID_Technical)
);

CREATE TABLE Attach(
Time_Stamp Timestamp,
ID_Customer int NOT NULL,
ID_Request int NOT NULL,
FOREIGN KEY (ID_Request) REFERENCES Request (ID_Request),
FOREIGN KEY (ID_Customer) REFERENCES Customer (ID_Customer)
);

CREATE TABLE Accepet(
Description varchar(350),
Cost int,
Rate float,
ID_Technical int NOT NULL,
ID_Request int NOT NULL,
FOREIGN KEY (ID_Request) REFERENCES Request (ID_Request),
FOREIGN KEY (ID_Technical) REFERENCES Technical (ID_Technical)
);


CREATE TABLE  Previous_Work(
ID_Previous_Work int NOT NULL,
Description varchar(350),
ID_Technical int NOT NULL,
PRIMARY KEY(ID_Previous_Work),
FOREIGN KEY (ID_Technical) REFERENCES Technical (ID_Technical)
);

CREATE TABLE Profile_Photo(   
ID_Photo  int ,
File_Name varchar(150),
ID_Previous_Work int NOT NULL,
FOREIGN KEY (ID_Previous_Work) REFERENCES  Previous_Work (ID_Previous_Work),
PRIMARY KEY(ID_Photo)
);

CREATE TABLE Service_Photo(
ID_Photo  int,
File_Name varchar(150),
ID_Service int NOT NULL,
PRIMARY KEY(ID_Photo),
FOREIGN KEY (ID_Service) REFERENCES Service (ID_Service)
);

CREATE TABLE Request_Photo(
ID_Photo  int,
File_Name varchar(150),
ID_Request int NOT NULL,
PRIMARY KEY(ID_Photo),
FOREIGN KEY (ID_Request) REFERENCES Request (ID_Request)
);


