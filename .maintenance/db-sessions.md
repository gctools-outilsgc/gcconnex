# Sessions table pruning (GCconnex)
I've had to do this a few times so documenting it seems like a good idea.

## why
Disk space - both for the DB and especially for backups since sessions don't compress all that well

## copy the last week to month of sessions to a new table and swap, should be 0 downtime
`create table sessions_tmp like elggusers_sessions;`

`insert into sessions_tmp select * from elggusers_sessions where ts > 1636038011`

`RENAME TABLE elggusers_sessions TO elggusers_sessions_old, sessions_tmp TO elggusers_sessions;`

## ensure nothing broke and delete the old swapped out table
`DROP TABLE elggusers_sessions_old;`
