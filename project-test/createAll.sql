CREATE TABLE Users(
username char(30),
gender char(10),
regDate Date,
password char(10) NOT NULL,
CONSTRAINT Users_pk PRIMARY KEY(username));

CREATE TABLE Channels (
Streamer_username char(30) NOT NULL,
id Integer,
status char(10),
language char(30),
description char(200),
title char(100)   NOT NULL,
CONSTRAINT Channels_pk PRIMARY KEY(ID),
CONSTRAINT Channels_unique UNIQUE(streamer_username),
CONSTRAINT fkChannel_Streamers
FOREIGN KEY(streamer_username)
	REFERENCES Users(username)
	ON DELETE CASCADE
);

CREATE TABLE Game_Channels (
id Integer,
gname char(30),
platform char(30),
CONSTRAINT Game_Channels_pk PRIMARY KEY(id),
CONSTRAINT fkGame_Channels_Channels FOREIGN KEY (id) REFERENCES Channels(id) ON DELETE CASCADE
);

CREATE TABLE Show_Channels (
id Integer,
type char(30),
CONSTRAINT Show_Channels_pk PRIMARY KEY(id),
CONSTRAINT fkShow_Channels_Channels FOREIGN KEY (id) REFERENCES Channels(id) ON DELETE CASCADE
);

CREATE TABLE Follows (
   follower_username char(30),
   followee_username char(30),
CONSTRAINT Follows_pk PRIMARY KEY(follower_username, followee_username),
CONSTRAINT fkFollows_follower
Foreign key(follower_username)
	REFERENCES Users(username)
	ON DELETE CASCADE,
CONSTRAINT fkFollows_followee
Foreign key(followee_username)
	REFERENCES Users(username)
ON DELETE CASCADE);

CREATE TABLE Grants_Privilege (
   Streamer_username char(30),
   Moderator_username char(30),
CONSTRAINT Grants_Privilege_pk PRIMARY KEY(Streamer_username, Moderator_username),
CONSTRAINT fkGrants_Privilege_Streamers
Foreign key(Streamer_username)
	REFERENCES Users(username)
	ON DELETE CASCADE,
CONSTRAINT fkGrants_Privilege_Moderators
Foreign key(Moderator_username)
	REFERENCES Users(username)
	ON DELETE CASCADE);

CREATE TABLE Donations (
transactionNo Integer,
donater_username char(30) NOT NULL,
donatee_username char(30)  NOT NULL,
amount Integer NOT NULL,
CONSTRAINT Donations_pk PRIMARY KEY(transactionNo),
CONSTRAINT fkDonations_donater
Foreign key(donater_username)
	REFERENCES Users(username)
	ON DELETE CASCADE,
CONSTRAINT fkDonations_donatee
Foreign key(donatee_username)
	REFERENCES Users(username)
	ON DELETE CASCADE
);

CREATE TABLE Watches (
	watcher_username char(30),
	ID Integer,
CONSTRAINT Watches_pk PRIMARY KEY(watcher_username,ID),
CONSTRAINT fkWatches_Users
Foreign key(watcher_username)
	REFERENCES Users(username)
	ON DELETE CASCADE,
CONSTRAINT fkWatches_Channels
Foreign key(ID)
	REFERENCES Channels(ID)
ON DELETE CASCADE);

CREATE TABLE Chat_Messages (
sender_username char(30) NOT NULL,
ChannelID Integer NOT NULL,
chatId Integer,
time Date NOT NULL,
content char(400) NOT NULL,
CONSTRAINT Chat_Messages_pk PRIMARY KEY(chatId),
CONSTRAINT fkChat_Msg_Users
FOREIGN KEY(sender_username)
	REFERENCES Users(username)
	ON DELETE CASCADE,
CONSTRAINT fkChat_Msg_Channels
Foreign key(ChannelID)
	REFERENCES Channels(ID)
ON DELETE CASCADE
);

CREATE TABLE Mutes (
   Moderator_username char(30),
   streamer_username char(30),
   mutee_username char(30),
   endTime Date NOT NULL,
CONSTRAINT Mutes_pk PRIMARY KEY(streamer_username, mutee_username),
CONSTRAINT fkMutes_Grants
Foreign key(streamer_username,Moderator_username)
	REFERENCES Grants_Privilege(streamer_username,Moderator_username)
ON DELETE CASCADE,
CONSTRAINT fkMutes_Users
FOREIGN KEY (mutee_username)
	REFERENCES Users(username)
ON DELETE CASCADE);