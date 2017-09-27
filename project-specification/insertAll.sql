insert into types
	values('Overwatch');
insert into types
	values('Counter-Strike');
insert into types
	values('GTA 5');
insert into types
	values('DOTA 2');
insert into types
	values('Outdoors');
insert into types
	values('Singing');
insert into types
	values('Fitness');
insert into types
	values('Talking Shows');
insert into types
	values('Comedy');

insert into games
	values('Counter-Strike', 'PC');
insert into games
	values('Overwatch', 'PC');
insert into games
	values('GTA 5', 'PS4');
insert into games
	values('GTA 5', 'Xbox One');
insert into games
	values('DOTA 2', 'PC');

insert into shows
	values('Outdoors');
insert into shows
	values('Singing');
insert into shows
	values('Fitness');
insert into shows
	values('Talking Shows');
insert into shows
	values('Comedy');

insert into users
	values('Caiyi','male');
insert into users
	values('Ventus','male');
insert into users
	values('Ziyu','male');
insert into users
	values('Taeyeon','female');
insert into users
	values('IU','female');
insert into users
	values('g1','female');
insert into users
	values('g2','female');
insert into users
	values('g3','female');
insert into users
	values('g4','female');
insert into users
	values('g5','female');

insert into guests
	values('g1');
insert into guests
	values('g2');
insert into guests
	values('g3');
insert into guests
	values('g4');
insert into guests
	values('g5');

insert into registered_users
	values('Caiyi','pswrd',1,to_date('2016/10/18 07:30:00', 'yyyy/mm/dd hh24:mi:ss'));
insert into registered_users
	values('Ventus','pswrd',1,to_date('2016/10/18 07:30:00', 'yyyy/mm/dd hh24:mi:ss'));
insert into registered_users
	values('Ziyu','pswrd',1,to_date('2016/10/18 07:30:00', 'yyyy/mm/dd hh24:mi:ss'));
insert into registered_users
	values('Taeyeon','pswrd',1,to_date('2016/10/18 07:30:00', 'yyyy/mm/dd hh24:mi:ss'));
insert into registered_users
	values('IU','pswrd',1,to_date('2016/10/18 07:30:00', 'yyyy/mm/dd hh24:mi:ss'));

insert into moderators
	values('Caiyi');
insert into moderators
	values('Ventus');
insert into moderators
	values('Ziyu');
insert into moderators
	values('Taeyeon');
insert into moderators
	values('IU');

insert into streamers
	values('Caiyi');
insert into streamers
	values('Ventus');
insert into streamers
	values('Ziyu');
insert into streamers
	values('Taeyeon');
insert into streamers
	values('IU');

insert into watches
	values('Caiyi', 'Caiyi', 1);
insert into watches
	values('Caiyi', 'Ventus', 1);
insert into watches
	values('Caiyi', 'Ziyu', 1);
insert into watches
	values('Caiyi', 'Taeyeon', 1);
insert into watches
	values('Caiyi', 'IU', 1);

insert into follows
	values('Caiyi', 'Ventus');
insert into follows
	values('Caiyi', 'Ziyu');
insert into follows
	values('Caiyi', 'Taeyeon');
insert into follows
	values('Caiyi', 'IU');
insert into follows
	values('Ziyu', 'Ventus');

insert into mutes
	values('Caiyi', 'Caiyi', to_date('2016/10/18 09:30:00', 'yyyy/mm/dd hh24:mi:ss'), 24);
insert into mutes
	values('Ventus', 'Caiyi', to_date('2016/10/18 09:30:00', 'yyyy/mm/dd hh24:mi:ss'), 24);
insert into mutes
	values('Ziyu', 'Caiyi', to_date('2016/10/18 09:30:00', 'yyyy/mm/dd hh24:mi:ss'), 24);
insert into mutes
	values('Taeyeon', 'Caiyi', to_date('2016/10/18 09:30:00', 'yyyy/mm/dd hh24:mi:ss'), 24);
insert into mutes
	values('IU', 'Caiyi', to_date('2016/10/18 09:30:00', 'yyyy/mm/dd hh24:mi:ss'), 24);

insert into grants_privilege
	values('Caiyi', 'Ventus');
insert into grants_privilege
	values('Ventus', 'Ziyu');
insert into grants_privilege
	values('Ziyu', 'Taeyeon');
insert into grants_privilege
	values('Taeyeon', 'IU');
insert into grants_privilege
	values('IU', 'Caiyi');

insert into donates
	values('Caiyi', 'IU', 1, 6666);
insert into donates
	values('Caiyi', 'IU', 2, 6666);
insert into donates
	values('Caiyi', 'IU', 3, 6666);
insert into donates
	values('Caiyi', 'IU', 4, 6666);
insert into donates
	values('Caiyi', 'IU', 5, 6666);

insert into channels
	values('Caiyi', 1, 1, 'banned', 'Chinese','hello world','Let us play Overwatch', 'Overwatch');
insert into channels
	values('Ventus', 1, 1, 'offline', 'Chinese','hello world','Let us play Counter-Strike', 'Counter-Strike');
insert into channels
	values('Ziyu', 1, 1, 'offline', 'English','hello world','Let us play DOTA', 'DOTA 2');
insert into channels
	values('Taeyeon', 1, 1, 'online', 'Korean','hello world','Why', 'Singing');
insert into channels
	values('IU', 1, 1, 'online', 'Korean','hello world','23', 'Outdoors');

insert into chat_messages
	values('Caiyi', 'Caiyi', 1, to_date('2016/10/18 08:30:00', 'yyyy/mm/dd hh24:mi:ss'), 'Hello world!');
insert into chat_messages
	values('Caiyi', 'Ventus', 1, to_date('2016/10/18 08:31:00', 'yyyy/mm/dd hh24:mi:ss'), 'Hello world!');
insert into chat_messages
	values('Caiyi', 'Ziyu', 1, to_date('2016/10/18 08:32:00', 'yyyy/mm/dd hh24:mi:ss'), 'Hello world!');
insert into chat_messages
	values('Caiyi', 'Taeyeon', 1, to_date('2016/10/18 08:33:00', 'yyyy/mm/dd hh24:mi:ss'), 'Hello world!');
insert into chat_messages
	values('Caiyi', 'IU', 1, to_date('2016/10/18 08:34:00', 'yyyy/mm/dd hh24:mi:ss'), 'Hello world!');