/*==============================================================*/
/* DBMS name:      Sybase SQL Anywhere 12                       */
/* Created on:     5/5/2022 3:33:03 PM                          */
/*==============================================================*/


if exists(select 1 from sys.sysforeignkey where role='FK_ATTENDAN_MENGHADIR_PARTICIP') then
    alter table ATTENDANCE
       delete foreign key FK_ATTENDAN_MENGHADIR_PARTICIP
end if;

if exists(select 1 from sys.sysforeignkey where role='FK_ATTENDAN_MENGHADIR_MEETING') then
    alter table ATTENDANCE
       delete foreign key FK_ATTENDAN_MENGHADIR_MEETING
end if;

if exists(select 1 from sys.sysforeignkey where role='FK_CLASS_MEMILIKI_USER') then
    alter table CLASS
       delete foreign key FK_CLASS_MEMILIKI_USER
end if;

if exists(select 1 from sys.sysforeignkey where role='FK_MEETING_MENYELENG_CLASS') then
    alter table MEETING
       delete foreign key FK_MEETING_MENYELENG_CLASS
end if;

if exists(select 1 from sys.sysforeignkey where role='FK_PARTICIP_MEMPUNYAI_CLASS') then
    alter table PARTICIPANT
       delete foreign key FK_PARTICIP_MEMPUNYAI_CLASS
end if;

drop index if exists ATTENDANCE.MENGHADIRI2_FK;

drop index if exists ATTENDANCE.MENGHADIRI1_FK;

drop index if exists ATTENDANCE.MENGHADIRI_PK;

drop table if exists ATTENDANCE;

drop index if exists CLASS.MEMILIKI_FK;

drop index if exists CLASS.CLASS_PK;

drop table if exists CLASS;

drop index if exists MEETING.MENYELENGGARAKAN_FK;

drop index if exists MEETING.MEETING_PK;

drop table if exists MEETING;

drop index if exists PARTICIPANT.MEMPUNYAI_FK;

drop index if exists PARTICIPANT.PARTICIPANT_PK;

drop table if exists PARTICIPANT;

drop index if exists "USER".USER_PK;

drop table if exists "USER";

/*==============================================================*/
/* Table: ATTENDANCE                                            */
/*==============================================================*/
create table ATTENDANCE 
(
   PTC_ID               varchar(10)                    not null,
   MEETING_ID           varchar(30)                    not null,
   JOIN_TIME            timestamp                      null,
   LEAVE_TIME           timestamp                      null,
   ATD_ID               varchar(30)                    not null,
   "DATE"               date                           null,
   DURATION             numeric(10,5)                  null,
   constraint PK_ATTENDANCE primary key clustered (PTC_ID, MEETING_ID, ATD_ID)
);

/*==============================================================*/
/* Index: MENGHADIRI_PK                                         */
/*==============================================================*/
create unique clustered index MENGHADIRI_PK on ATTENDANCE (
PTC_ID ASC,
MEETING_ID ASC,
ATD_ID ASC
);

/*==============================================================*/
/* Index: MENGHADIRI1_FK                                        */
/*==============================================================*/
create index MENGHADIRI1_FK on ATTENDANCE (
PTC_ID ASC
);

/*==============================================================*/
/* Index: MENGHADIRI2_FK                                        */
/*==============================================================*/
create index MENGHADIRI2_FK on ATTENDANCE (
MEETING_ID ASC
);

/*==============================================================*/
/* Table: CLASS                                                 */
/*==============================================================*/
create table CLASS 
(
   CLASS_ID             varchar(10)                    not null,
   USER_ID              varchar(10)                    null,
   TITLE_CLASS          varchar(255)                   not null,
   DETAIL_CLASS         varchar(255)                   null,
   ROOM                 varchar(255)                   null,
   NUM_MEETINGS         integer                        not null,
   constraint PK_CLASS primary key (CLASS_ID)
);

/*==============================================================*/
/* Index: CLASS_PK                                              */
/*==============================================================*/
create unique index CLASS_PK on CLASS (
CLASS_ID ASC
);

/*==============================================================*/
/* Index: MEMILIKI_FK                                           */
/*==============================================================*/
create index MEMILIKI_FK on CLASS (
USER_ID ASC
);

/*==============================================================*/
/* Table: MEETING                                               */
/*==============================================================*/
create table MEETING 
(
   MEETING_ID           varchar(30)                    not null,
   CLASS_ID             varchar(10)                    null,
   "DATE"               date                           null,
   START_TIME           timestamp                      null,
   END_TIME             timestamp                      null,
   DURATION             numeric(10,5)                  null,
   MEETING_ORDER        varchar(10)                    null,
   UUID                 varchar(30)                    null,
   constraint PK_MEETING primary key (MEETING_ID)
);

/*==============================================================*/
/* Index: MEETING_PK                                            */
/*==============================================================*/
create unique index MEETING_PK on MEETING (
MEETING_ID ASC
);

/*==============================================================*/
/* Index: MENYELENGGARAKAN_FK                                   */
/*==============================================================*/
create index MENYELENGGARAKAN_FK on MEETING (
CLASS_ID ASC
);

/*==============================================================*/
/* Table: PARTICIPANT                                           */
/*==============================================================*/
create table PARTICIPANT 
(
   PTC_ID               varchar(10)                    not null,
   CLASS_ID             varchar(10)                    null,
   PTC_EMAIL            varchar(255)                   not null,
   PTC_NAME             varchar(255)                   not null,
   constraint PK_PARTICIPANT primary key (PTC_ID)
);

/*==============================================================*/
/* Index: PARTICIPANT_PK                                        */
/*==============================================================*/
create unique index PARTICIPANT_PK on PARTICIPANT (
PTC_ID ASC
);

/*==============================================================*/
/* Index: MEMPUNYAI_FK                                          */
/*==============================================================*/
create index MEMPUNYAI_FK on PARTICIPANT (
CLASS_ID ASC
);

/*==============================================================*/
/* Table: "USER"                                                */
/*==============================================================*/
create table "USER" 
(
   USER_ID              varchar(10)                    not null,
   EMAIL                varchar(255)                   not null,
   PASSWORD             varchar(255)                   not null,
   FIRST_NAME           varchar(255)                   null,
   LAST_NAME            varchar(255)                   null,
   ACCESS_TOKEN         varchar(255)                   null,
   constraint PK_USER primary key (USER_ID)
);

/*==============================================================*/
/* Index: USER_PK                                               */
/*==============================================================*/
create unique index USER_PK on "USER" (
USER_ID ASC
);

alter table ATTENDANCE
   add constraint FK_ATTENDAN_MENGHADIR_PARTICIP foreign key (PTC_ID)
      references PARTICIPANT (PTC_ID)
      on update restrict
      on delete restrict;

alter table ATTENDANCE
   add constraint FK_ATTENDAN_MENGHADIR_MEETING foreign key (MEETING_ID)
      references MEETING (MEETING_ID)
      on update restrict
      on delete restrict;

alter table CLASS
   add constraint FK_CLASS_MEMILIKI_USER foreign key (USER_ID)
      references "USER" (USER_ID)
      on update restrict
      on delete restrict;

alter table MEETING
   add constraint FK_MEETING_MENYELENG_CLASS foreign key (CLASS_ID)
      references CLASS (CLASS_ID)
      on update restrict
      on delete restrict;

alter table PARTICIPANT
   add constraint FK_PARTICIP_MEMPUNYAI_CLASS foreign key (CLASS_ID)
      references CLASS (CLASS_ID)
      on update restrict
      on delete restrict;

