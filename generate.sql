insert into users(username, gender, regdate, password)
   select 'User ' || to_char(rownum), 
      case mod(round(dbms_random.value()*10),2) when 1 then 'Female'
      else 'Male'
      end, 
      TRUNC (SYSDATE - ROWNUM) dt,
      '123'
   from dual
   connect by level <= 100;

insert into users(username, gender, regdate, password)
   select 'Moderator ' || to_char(rownum), 
      case mod(round(dbms_random.value()*10),2) when 1 then 'Female'
      else 'Male'
      end, 
      TRUNC (SYSDATE - ROWNUM) dt,
      '123'
   from dual
   connect by level <= 50;

insert into users(username, gender, regdate, password)
   select 'Streamer ' || to_char(rownum), 
      case mod(round(dbms_random.value()*10),2) when 1 then 'Female'
      else 'Male'
      end, 
      TRUNC (SYSDATE - ROWNUM) dt,
      '123'
   from dual
   connect by level <= 50;

insert into channels(streamer_username, id, status, language, description, title)
   select 'Streamer ' || to_char(rownum), rownum, 
      case mod(round(dbms_random.value()*10),3)
      when 1 then 'online'
      when 0 then 'offline'
      else 'banned'
      end,
      case mod(round(dbms_random.value()*10),3)
      when 1 then 'English'
      when 0 then 'Chinese'
      else 'Korean'
      end, 'Hello World!', 'Let us play the game!'
   from dual
   connect by level <= 50;

insert into game_channels(id, gname, platform)
   select rownum,
      case mod(round(dbms_random.value()*10),3)
      when 1 then 'Overwatch'
      when 0 then 'Heroes of the Storm'
      else 'Dota 2'
      end,
      case mod(round(dbms_random.value()*10),3)
      when 1 then 'PC'
      when 0 then 'Xbox'
      else 'PS4'
      end
   from dual connect by level <= 40;

insert into show_channels(id, type)
   select rownum+40,
      case mod(round(dbms_random.value()*10),3)
      when 1 then 'Outdoors'
      when 0 then 'Talk Show'
      else 'Creative'
      end
   from dual connect by level <= 10;

insert into follows(follower_username, followee_username)
   select 'User ' || to_char(rownum), 'Streamer ' || to_char(mod(round(dbms_random.value()*100),50)+1)
   from dual connect by level <= 100;

insert into grants_privilege(streamer_username, moderator_username)
   select 'Streamer ' || to_char(rownum), 'Moderator ' || to_char(rownum)
   from dual connect by level <= 50;

insert into donations(donater_username, donatee_username, transactionNo, amount)
   select 'User ' || to_char(mod(round(dbms_random.value()*100),100)+1), 'Streamer ' || to_char(mod(round(dbms_random.value()*100),50)+1), rownum, round(dbms_random.value()*100)
   from dual connect by level <= 500;

insert into watches(watcher_username, id)
   select 'User ' || to_char(rownum), mod(round(dbms_random.value()*100),50)+1 
   from dual connect by level <= 100;