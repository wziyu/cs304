CREATE TABLE Types (
name char(30) NOT NULL,
CONSTRAINT Types_pk PRIMARY KEY(name)
);


CREATE TABLE Games (
name char(30),
platform char(30),
CONSTRAINT Games_pk PRIMARY KEY(name,platform),
CONSTRAINT fkGame_Types FOREIGN KEY (name) REFERENCES Types(name) 
);

CREATE TABLE Shows (
name char(30) NOT NULL,
CONSTRAINT Shows_pk PRIMARY KEY(name),
CONSTRAINT fkShow_Types FOREIGN KEY(name) REFERENCES Types(name));


CREATE TABLE Users(
username char(30) NOT NULL,
gender char(10),
CONSTRAINT Users_pk PRIMARY KEY(username));

CREATE TABLE Guests(
username char(30) NOT NULL,
CONSTRAINT Guests_pk PRIMARY KEY(username),
CONSTRAINT fkGuests_Users
FOREIGN KEY(username)
	REFERENCES Users(username)
	ON DELETE CASCADE
);

CREATE TABLE Registered_Users(
username char(30) NOT NULL,
password char(20)  NOT NULL,
numOfFollowers Integer,
regDate Date,
CONSTRAINT Registered_Users_pk PRIMARY KEY(username),
CONSTRAINT fkRegistered_Users_Users
FOREIGN KEY(username)
	REFERENCES Users(username)
	ON DELETE CASCADE
);

CREATE TABLE Moderators(
username char(30) NOT NULL,
CONSTRAINT Moderators_pk PRIMARY KEY(username),
CONSTRAINT fkModerators_Registered_Users
FOREIGN KEY(username)
	REFERENCES Registered_Users(username)
	ON DELETE CASCADE
);

CREATE TABLE Streamers(
username char(30) NOT NULL,
CONSTRAINT Streamers_pk PRIMARY KEY(username),
CONSTRAINT fkStreamers_Registered_Users
FOREIGN KEY(username)
	REFERENCES Registered_Users(username)
	ON DELETE CASCADE
);

CREATE TABLE Follows (
   follower_name char(30) NOT NULL,
   followee_name char(30) NOT NULL,
CONSTRAINT Follows_pk PRIMARY KEY(follower_name, followee_name),
CONSTRAINT fkFollows_follower
Foreign key(follower_name)
	REFERENCES Registered_Users(username)
	ON DELETE CASCADE,
CONSTRAINT fkFollows_followee
Foreign key(followee_name)
	REFERENCES Registered_Users(username)
ON DELETE CASCADE);

CREATE TABLE Mutes (
   Moderator_username char(30) NOT NULL,
   RegisteredUser_username char(30)  NOT NULL,
   startTime Date  NOT NULL,
duration Integer,
CONSTRAINT Mutes_pk PRIMARY KEY(Moderator_username, RegisteredUser_username, startTime),
CONSTRAINT fkMutes_Moderators
Foreign key(Moderator_username)
	REFERENCES Moderators(username),
CONSTRAINT fkMutes_Registered_Users
Foreign key(RegisteredUser_username)
	REFERENCES Registered_Users(username)
ON DELETE CASCADE);

CREATE TABLE Grants_Privilege (
   Streamer_username char(30),
   Moderator_username char(30),
CONSTRAINT Grants_Privilege_pk PRIMARY KEY(Streamer_username, Moderator_username),
CONSTRAINT fkGrants_Privilege_Streamers
Foreign key(Streamer_username)
	REFERENCES Streamers(username)
	ON DELETE CASCADE,
CONSTRAINT fkGrants_Privilege_Moderators
Foreign key(Moderator_username)
	REFERENCES Moderators(username)
	ON DELETE CASCADE);

CREATE TABLE Donates (
RegisteredUser_username char(30) NOT NULL,
Streamer_username char(30)  NOT NULL,
transactionNo Integer NOT NULL,
amount Integer NOT NULL,
CONSTRAINT Donates_pk PRIMARY KEY(RegisteredUser_username, Streamer_username, transactionNo),
CONSTRAINT fkDonates_Registered_Users
Foreign key(RegisteredUser_username)
	REFERENCES Registered_Users(username),
CONSTRAINT fkDonates_Streamers
Foreign key(Streamer_username)
	REFERENCES Streamers(username)
);

CREATE TABLE Channels (
Streamer_name char(30) NOT NULL,
ID Integer NOT NULL,
numOfViewers Integer,
status char(10),
language char(30),
description char(200),
title char(100)   NOT NULL,
type_name char(30) NOT NULL,
CONSTRAINT Channels_pk PRIMARY KEY(Streamer_name, ID),
CONSTRAINT Channels_unique UNIQUE(Streamer_name),
CONSTRAINT fkChannel_Streamers
FOREIGN KEY(streamer_name)
	REFERENCES Streamers(username)
	ON DELETE CASCADE,
CONSTRAINT fkChannel_Types
FOREIGN KEY(type_name)
	REFERENCES Types(name)
	ON DELETE SET NULL
);

CREATE TABLE Watches (
	User_username char(30)  NOT NULL,
	Streamer_username char(30)  NOT NULL,
	ID Integer  NOT NULL,
CONSTRAINT Watches_pk PRIMARY KEY(User_username,Streamer_username,ID),
CONSTRAINT fkWatches_Registered_Users
Foreign key(User_username)
	REFERENCES Users(username),
CONSTRAINT fkWatches_Channels
Foreign key(streamer_username,ID)
	REFERENCES Channels(streamer_name,ID)
ON DELETE CASCADE);

CREATE TABLE Chat_Messages (
sendername char(30) NOT NULL,
streamer_username char(30) NOT NULL,
ChannelID Integer,
time Date NOT NULL,
content char(400),
CONSTRAINT Chat_Messages_pk PRIMARY KEY(sendername,time),
CONSTRAINT fkChat_Msg_RUsers
FOREIGN KEY(sendername)
	REFERENCES Registered_Users(username),
CONSTRAINT fkChat_Msg_Channels
Foreign key(streamer_username,ChannelID)
	REFERENCES Channels(Streamer_name,ID)
);