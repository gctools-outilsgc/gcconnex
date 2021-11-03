# Old site notification cleanup (GCconnex)
With the way notifications currently work, every user stores a copy of every notification about anything they subscribe to which can cause them to eventually become by far the largest chunk of the database.
I've had to do this once or twice so documenting it seems like a good idea.
There doesn't seem to be much difference between these queries and equivalent ones using joins, but these are hopefully easier to read.

## Create new tables
`create table elggentities_tmp like elggentities;`

`create table elggmetadata_tmp like elggmetadata;`

`create table elggobjects_entity_tmp like elggobjects_entity;`

## copy over the entities that will be kept
### anything that's not an internal message (subtype 4 in gcconnex denotes messages)
`insert into elggentities_tmp select * from elggentities where subtype <> 4;`
### messages that are not notifications 
`insert into elggentities_tmp select * from elggentities where subtype = 4 and guid in (select entity_guid from elggmetadata where name_id = 1287 and value_id in ( select id from elggmetastrings where string in (select guid from elggusers_entity) ) and entity_guid IN (select guid from elggentities where subtype = 4) );`
### recent notifications (more recent than provided timestamp)
`insert into elggentities_tmp select * from elggentities where subtype = 4 and time_created > 1626791818 and guid not in (select guid from elggentities_tmp);`

## copy over the metadata of the entities to be kept
`insert into elggmetadata_tmp select * from elggmetadata where entity_guid in (select guid from elggentities_tmp);`

## copy over the objects entries of the entities be kept
`insert into elggobjects_entity_tmp select * from elggobjects_entity where guid in (select guid from elggentities_tmp);`

## swap in the new tables for the old ones
`RENAME TABLE elggentities TO elggentities_old, elggentities_tmp TO elggentities;`

`RENAME TABLE elggmetadata TO elggmetadata_old, elggmetadata_tmp TO elggmetadata;`

`RENAME TABLE elggobjects_entity TO elggobjects_entity_old, elggobjects_entity_tmp TO elggobjects_entity;`

## with this you can verify that everything still works and nothing unexpected was lost with an easy roll-back and backup available

## when no longer needed as an extra easy to access backup the old data can be removed from the db
`DROP TABLE elggentities_old;`

`DROP TABLE elggmetadata_old;`

`DROP TABLE elggobjects_entity_old;`
