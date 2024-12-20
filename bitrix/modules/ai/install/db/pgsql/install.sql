CREATE TABLE b_ai_queue
(
	ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
	HASH char(32) NOT NULL,
	ENGINE_CLASS varchar(100) NOT NULL,
	ENGINE_CODE varchar(100) DEFAULT null,
	ENGINE_CUSTOM_SETTINGS text DEFAULT null,
	PAYLOAD_CLASS varchar(100) NOT NULL,
	PAYLOAD text NOT NULL,
	CONTEXT text DEFAULT null,
	PARAMETERS text DEFAULT null,
	HISTORY_WRITE char(1) DEFAULT 'N',
	HISTORY_GROUP_ID int,
	CACHE_HASH char(32) DEFAULT NULL,
	DATE_CREATE timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (ID)
);
CREATE INDEX ix_b_ai_queue_date_create ON b_ai_queue (date_create);
CREATE UNIQUE INDEX ux_b_ai_queue_hash ON b_ai_queue (hash);

CREATE TABLE b_ai_history
(
	ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
	CONTEXT_MODULE varchar(100) NOT NULL,
	CONTEXT_ID varchar(100) NOT NULL,
	ENGINE_CLASS varchar(100) NOT NULL,
	ENGINE_CODE varchar(100) DEFAULT null,
	PAYLOAD_CLASS varchar(100) NOT NULL,
	PAYLOAD text NOT NULL,
	PARAMETERS text DEFAULT null,
	GROUP_ID int NOT NULL DEFAULT -1,
	REQUEST_TEXT text DEFAULT null,
	RESULT_TEXT text DEFAULT null,
	CONTEXT text DEFAULT null,
	CACHED boolean default false,
	DATE_CREATE timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CREATED_BY_ID int NOT NULL,
	PRIMARY KEY (ID)
);
CREATE INDEX ix_b_ai_history_created_by_id ON b_ai_history (created_by_id);
CREATE INDEX ix_b_ai_history_context_id ON b_ai_history (context_id);
CREATE INDEX ix_b_ai_history_context_module_user_group ON b_ai_history (context_module, context_id, created_by_id, group_id);

CREATE TABLE b_ai_engine
(
	ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
	APP_CODE varchar(128) DEFAULT null,
	NAME varchar(100) NOT NULL,
	CODE varchar(100) NOT NULL,
	CATEGORY varchar(20) NOT NULL,
	COMPLETIONS_URL varchar(250) NOT NULL,
	SETTINGS text DEFAULT null,
	DATE_CREATE timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (ID)
);
CREATE INDEX ix_b_ai_engine_app_code_code ON b_ai_engine (app_code, code);
CREATE INDEX ix_b_ai_engine_code ON b_ai_engine (code);

CREATE TABLE b_ai_prompt
(
	ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
	APP_CODE varchar(128) DEFAULT null,
	PARENT_ID int DEFAULT null,
	CATEGORY text DEFAULT null,
	CACHE_CATEGORY text DEFAULT null,
	SECTION varchar(20) DEFAULT null,
	SORT int DEFAULT null,
	CODE varchar(100) NOT NULL,
	TYPE varchar(32) default null,
	ICON varchar(50) DEFAULT null,
	HASH char(32) NOT NULL,
	PROMPT text DEFAULT null,
	TRANSLATE text NOT NULL,
	TEXT_TRANSLATES text DEFAULT null,
	SETTINGS text DEFAULT null,
	WORK_WITH_RESULT char(1) NOT NULL DEFAULT 'N',
	IS_NEW smallint default 0,
	IS_SYSTEM char(1) NOT NULL DEFAULT 'N',
	DATE_MODIFY timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (ID)
);
CREATE INDEX ix_b_ai_prompt_app_code ON b_ai_prompt (app_code);
CREATE INDEX ix_b_ai_prompt_code ON b_ai_prompt (code);
CREATE INDEX ix_b_ai_prompt_parent_id ON b_ai_prompt (parent_id);
CREATE INDEX ix_b_ai_prompt_is_system ON b_ai_prompt (is_system);
CREATE INDEX ix_b_ai_prompt_is_new ON b_ai_prompt (IS_NEW);

CREATE TABLE b_ai_role
(
	ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
	CODE varchar(100) NOT NULL,
	INDUSTRY_CODE varchar(100) default null,
	NAME_TRANSLATES text null,
	DESCRIPTION_TRANSLATES text null,
	HASH char(32) NOT NULL,
	INSTRUCTION text NOT NULL,
	AVATAR text NOT NULL,
	IS_RECOMMENDED smallint default 0,
	IS_NEW smallint default 0,
	SORT int DEFAULT null,
	DATE_MODIFY timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (ID)
);
CREATE INDEX ix_b_ai_role_code ON b_ai_role (code);
CREATE INDEX ix_b_ai_role_is_new ON b_ai_role (IS_NEW);
CREATE INDEX ix_b_ai_role_is_recommended ON b_ai_role (IS_RECOMMENDED);
CREATE INDEX ix_b_ai_role_sort ON b_ai_role (sort);
CREATE INDEX ix_b_ai_role_industry_code ON b_ai_role (industry_code);

create table if not exists b_ai_role_prompt
(
	ROLE_ID int not null,
	PROMPT_ID int not null,
	DATE_CREATE timestamp not null default current_timestamp,
	PRIMARY KEY (ROLE_ID, PROMPT_ID)
	);

create table if not exists b_ai_role_industry
(
	ID int not null generated always as identity,
	CODE varchar(100) not null,
	HASH char(32) not null,
	NAME_TRANSLATES text not null,
	IS_NEW smallint default 0,
	SORT int DEFAULT null,
	DATE_MODIFY timestamp(0) not null default current_timestamp,
	PRIMARY KEY (ID),
	CONSTRAINT IX_B_INDUSTRY_CODE UNIQUE (CODE)
	);

CREATE INDEX ix_b_ai_industry_code ON b_ai_role_industry (code);
CREATE INDEX ix_b_ai_industry_sort ON b_ai_role_industry (sort);

create table if not exists b_ai_recent_role
(
	ID int not null generated always as identity,
	ROLE_CODE varchar(100) not null,
	USER_ID int not null,
	DATE_CREATE timestamp(0) not null default current_timestamp,
	DATE_TOUCH timestamp(0) not null default current_timestamp,
	PRIMARY KEY (ID),
	CONSTRAINT IX_B_ROLE_USER UNIQUE (USER_ID, ROLE_CODE)
	);

CREATE INDEX IX_B_DATE_TOUCH ON b_ai_recent_role (DATE_TOUCH);

create table if not exists b_ai_role_favorite
(
	ID int not null generated always as identity,
	ROLE_CODE varchar(100) not null,
	USER_ID int not null,
	DATE_CREATE timestamp(0) not null default current_timestamp,
	PRIMARY KEY (ID),
	CONSTRAINT IX_B_FAVORITE_ROLE_USER UNIQUE (USER_ID, ROLE_CODE)
);


CREATE TABLE b_ai_plan
(
	ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
	CODE varchar(100) NOT NULL,
	HASH char(32) NOT NULL,
	MAX_USAGE int NOT NULL,
	DATE_MODIFY timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (ID)
);
CREATE INDEX ix_b_ai_plan_code ON b_ai_plan (code);

CREATE TABLE b_ai_usage
(
	ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
	USER_ID int NOT NULL,
	USAGE_PERIOD varchar(50) NOT NULL,
	USAGE_COUNT INTEGER NOT NULL DEFAULT 1,
	DATE_MODIFY timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (ID)
);
CREATE INDEX ix_b_ai_usage_user_id_usage_period ON b_ai_usage (user_id, usage_period);
CREATE INDEX ix_b_ai_usage_user_id ON b_ai_usage (user_id);

create table if not exists b_ai_section
(
	ID int not null generated always as identity,
	CODE varchar(100) not null,
	HASH char(32) not null,
	TRANSLATE text not null,
	DATE_MODIFY timestamp(0) not null default current_timestamp,
	PRIMARY KEY (ID)
);

CREATE INDEX IX_B_CODE ON b_ai_section (CODE);

create table if not exists b_ai_baas_package
(
	ID int not null generated always as identity,
	DATE_START date not null,
	DATE_EXPIRED date not null,
	PRIMARY KEY (ID)
);
CREATE INDEX ix_b_ai_baas_package_date_expired ON b_ai_baas_package (date_expired);

create table if not exists b_ai_counter
(
	ID int not null generated always as identity,
	NAME VARCHAR(100) not null,
	VALUE varchar(200),
	PRIMARY KEY (ID),
	CONSTRAINT b_ai_option_unique_name UNIQUE (NAME)
);
