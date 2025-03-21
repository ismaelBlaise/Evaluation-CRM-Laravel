CREATE SCHEMA crm2;

CREATE  TABLE crm2.activities ( 
	id                   BIGINT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	log_name             VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	causer_id            BIGINT UNSIGNED      ,
	causer_type          VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	`text`               VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	source_type          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	source_id            BIGINT UNSIGNED      ,
	ip_address           VARCHAR(64)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	properties           JSON       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       ,
	deleted_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE  TABLE crm2.departments ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	name                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	description          TEXT   COLLATE utf8mb3_unicode_ci    ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE  TABLE crm2.documents ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	size                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	path                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	original_filename    VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	mime                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	integration_id       VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	integration_type     VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	source_type          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	source_id            BIGINT UNSIGNED   NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX documents_source_type_source_id_index ON crm2.documents ( source_type, source_id );

CREATE  TABLE crm2.industries ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	name                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   
 ) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE  TABLE crm2.integrations ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	name                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	client_id            INT       ,
	user_id              INT       ,
	client_secret        INT       ,
	api_key              VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	api_type             VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	org_id               VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE  TABLE crm2.migrations ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	migration            VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	batch                INT    NOT NULL   
 ) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE  TABLE crm2.notifications ( 
	id                   CHAR(36)   COLLATE utf8mb3_unicode_ci NOT NULL   PRIMARY KEY,
	`type`               VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	notifiable_type      VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	notifiable_id        BIGINT UNSIGNED   NOT NULL   ,
	data                 TEXT   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	read_at              TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX notifications_notifiable_type_notifiable_id_index ON crm2.notifications ( notifiable_type, notifiable_id );

CREATE  TABLE crm2.password_resets ( 
	email                VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	token                VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	created_at           TIMESTAMP    NOT NULL   
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX password_resets_email_index ON crm2.password_resets ( email );

CREATE INDEX password_resets_token_index ON crm2.password_resets ( token );

CREATE  TABLE crm2.permissions ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	name                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	display_name         VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	description          VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	grouping             VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       ,
	CONSTRAINT permissions_name_unique UNIQUE ( name ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE  TABLE crm2.products ( 
	id                   BIGINT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	name                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	description          TEXT   COLLATE utf8mb3_unicode_ci    ,
	number               VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	default_type         VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	archived             BOOLEAN    NOT NULL   ,
	integration_type     VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	integration_id       BIGINT UNSIGNED      ,
	price                INT    NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX products_integration_type_integration_id_index ON crm2.products ( integration_type, integration_id );

CREATE  TABLE crm2.roles ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	name                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	display_name         VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	description          VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE  TABLE crm2.settings ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	client_number        INT    NOT NULL   ,
	invoice_number       INT    NOT NULL   ,
	country              VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	company              VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	currency             VARCHAR(3)  DEFAULT ('USD') COLLATE utf8mb3_unicode_ci NOT NULL   ,
	vat                  SMALLINT  DEFAULT ('725')  NOT NULL   ,
	max_users            INT    NOT NULL   ,
	language             VARCHAR(2)  DEFAULT ('EN') COLLATE utf8mb3_unicode_ci NOT NULL   ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE  TABLE crm2.statuses ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	title                VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	source_type          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	color                VARCHAR(255)  DEFAULT ('#000000') COLLATE utf8mb3_unicode_ci NOT NULL   ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE  TABLE crm2.subscriptions ( 
	id                   BIGINT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	user_id              BIGINT UNSIGNED   NOT NULL   ,
	name                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	stripe_id            VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	stripe_status        VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	stripe_plan          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	quantity             INT    NOT NULL   ,
	trial_ends_at        TIMESTAMP       ,
	ends_at              TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX subscriptions_user_id_stripe_status_index ON crm2.subscriptions ( user_id, stripe_status );

CREATE  TABLE crm2.users ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	name                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	email                VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	password             VARCHAR(60)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	address              VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	primary_number       VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	secondary_number     VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	image_path           VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	remember_token       VARCHAR(100)   COLLATE utf8mb3_unicode_ci    ,
	language             VARCHAR(2)  DEFAULT ('EN') COLLATE utf8mb3_unicode_ci NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       ,
	CONSTRAINT users_email_unique UNIQUE ( email ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE  TABLE crm2.absences ( 
	id                   BIGINT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	reason               VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	comment              TEXT   COLLATE utf8mb3_unicode_ci    ,
	start_at             TIMESTAMP    NOT NULL   ,
	end_at               TIMESTAMP    NOT NULL   ,
	medical_certificate  BOOLEAN       ,
	user_id              INT UNSIGNED      ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX absences_user_id_foreign ON crm2.absences ( user_id );

CREATE  TABLE crm2.business_hours ( 
	id                   BIGINT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	day                  VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	open_time            TIME       ,
	close_time           TIME       ,
	settings_id          INT UNSIGNED      ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX business_hours_settings_id_foreign ON crm2.business_hours ( settings_id );

CREATE  TABLE crm2.clients ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	address              VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	zipcode              VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	city                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	company_name         VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	vat                  VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	company_type         VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	client_number        BIGINT       ,
	user_id              INT UNSIGNED   NOT NULL   ,
	industry_id          INT UNSIGNED   NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX clients_user_id_foreign ON crm2.clients ( user_id );

CREATE INDEX clients_industry_id_foreign ON crm2.clients ( industry_id );

CREATE  TABLE crm2.comments ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	description          LONGTEXT   COLLATE utf8mb3_unicode_ci    ,
	source_type          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	source_id            BIGINT UNSIGNED   NOT NULL   ,
	user_id              INT UNSIGNED   NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX comments_source_type_source_id_index ON crm2.comments ( source_type, source_id );

CREATE INDEX comments_user_id_foreign ON crm2.comments ( user_id );

CREATE  TABLE crm2.contacts ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	name                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	email                VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	primary_number       VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	secondary_number     VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	client_id            INT UNSIGNED   NOT NULL   ,
	is_primary           BOOLEAN    NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX contacts_client_id_foreign ON crm2.contacts ( client_id );

CREATE  TABLE crm2.department_user ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	department_id        INT UNSIGNED   NOT NULL   ,
	user_id              INT UNSIGNED   NOT NULL   ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX department_user_department_id_foreign ON crm2.department_user ( department_id );

CREATE INDEX department_user_user_id_foreign ON crm2.department_user ( user_id );

CREATE  TABLE crm2.leads ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	title                VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	description          TEXT   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	status_id            INT UNSIGNED   NOT NULL   ,
	user_assigned_id     INT UNSIGNED   NOT NULL   ,
	client_id            INT UNSIGNED   NOT NULL   ,
	user_created_id      INT UNSIGNED   NOT NULL   ,
	qualified            BOOLEAN  DEFAULT ('0')  NOT NULL   ,
	result               VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	deadline             DATETIME    NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX leads_status_id_foreign ON crm2.leads ( status_id );

CREATE INDEX leads_user_assigned_id_foreign ON crm2.leads ( user_assigned_id );

CREATE INDEX leads_client_id_foreign ON crm2.leads ( client_id );

CREATE INDEX leads_user_created_id_foreign ON crm2.leads ( user_created_id );

CREATE INDEX leads_qualified_index ON crm2.leads ( qualified );

CREATE  TABLE crm2.mails ( 
	id                   BIGINT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	subject              VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	body                 VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	template             VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	email                VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	user_id              INT UNSIGNED      ,
	send_at              TIMESTAMP       ,
	sent_at              TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX mails_user_id_foreign ON crm2.mails ( user_id );

CREATE  TABLE crm2.offers ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	sent_at              DATETIME       ,
	source_type          VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	source_id            BIGINT UNSIGNED      ,
	client_id            INT UNSIGNED   NOT NULL   ,
	`status`             VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX offers_source_type_source_id_index ON crm2.offers ( source_type, source_id );

CREATE INDEX offers_client_id_foreign ON crm2.offers ( client_id );

CREATE  TABLE crm2.permission_role ( 
	permission_id        INT UNSIGNED   NOT NULL   ,
	role_id              INT UNSIGNED   NOT NULL   ,
	CONSTRAINT pk_permission_role PRIMARY KEY ( permission_id, role_id )
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX permission_role_role_id_foreign ON crm2.permission_role ( role_id );

CREATE  TABLE crm2.role_user ( 
	user_id              INT UNSIGNED   NOT NULL   ,
	role_id              INT UNSIGNED   NOT NULL   ,
	CONSTRAINT pk_role_user PRIMARY KEY ( user_id, role_id )
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX role_user_role_id_foreign ON crm2.role_user ( role_id );

CREATE  TABLE crm2.appointments ( 
	id                   BIGINT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	title                VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	description          VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	source_type          VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	source_id            BIGINT UNSIGNED      ,
	color                VARCHAR(10)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	user_id              INT UNSIGNED   NOT NULL   ,
	client_id            INT UNSIGNED      ,
	start_at             TIMESTAMP       ,
	end_at               TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       ,
	deleted_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX appointments_source_type_source_id_index ON crm2.appointments ( source_type, source_id );

CREATE INDEX appointments_user_id_foreign ON crm2.appointments ( user_id );

CREATE INDEX appointments_client_id_foreign ON crm2.appointments ( client_id );

CREATE  TABLE crm2.invoices ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	`status`             VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	invoice_number       BIGINT       ,
	sent_at              DATETIME       ,
	due_at               DATETIME       ,
	integration_invoice_id VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	integration_type     VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	source_type          VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	source_id            BIGINT UNSIGNED      ,
	client_id            INT UNSIGNED   NOT NULL   ,
	offer_id             INT UNSIGNED      ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX invoices_client_id_foreign ON crm2.invoices ( client_id );

CREATE INDEX invoices_source_type_source_id_index ON crm2.invoices ( source_type, source_id );

CREATE INDEX invoices_offer_id_foreign ON crm2.invoices ( offer_id );

CREATE  TABLE crm2.payments ( 
	id                   BIGINT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	amount               INT    NOT NULL   ,
	description          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	payment_source       VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	payment_date         DATE    NOT NULL   ,
	integration_payment_id VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	integration_type     VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	invoice_id           INT UNSIGNED   NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX payments_invoice_id_foreign ON crm2.payments ( invoice_id );

CREATE  TABLE crm2.projects ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	title                VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	description          TEXT   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	status_id            INT UNSIGNED   NOT NULL   ,
	user_assigned_id     INT UNSIGNED   NOT NULL   ,
	user_created_id      INT UNSIGNED   NOT NULL   ,
	client_id            INT UNSIGNED   NOT NULL   ,
	invoice_id           INT UNSIGNED      ,
	deadline             DATE    NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX projects_status_id_foreign ON crm2.projects ( status_id );

CREATE INDEX projects_user_assigned_id_foreign ON crm2.projects ( user_assigned_id );

CREATE INDEX projects_user_created_id_foreign ON crm2.projects ( user_created_id );

CREATE INDEX projects_client_id_foreign ON crm2.projects ( client_id );

CREATE INDEX projects_invoice_id_foreign ON crm2.projects ( invoice_id );

CREATE  TABLE crm2.tasks ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	title                VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	description          TEXT   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	status_id            INT UNSIGNED   NOT NULL   ,
	user_assigned_id     INT UNSIGNED   NOT NULL   ,
	user_created_id      INT UNSIGNED   NOT NULL   ,
	client_id            INT UNSIGNED   NOT NULL   ,
	project_id           INT UNSIGNED      ,
	deadline             DATE    NOT NULL   ,
	deleted_at           TIMESTAMP       ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX tasks_status_id_foreign ON crm2.tasks ( status_id );

CREATE INDEX tasks_user_assigned_id_foreign ON crm2.tasks ( user_assigned_id );

CREATE INDEX tasks_user_created_id_foreign ON crm2.tasks ( user_created_id );

CREATE INDEX tasks_client_id_foreign ON crm2.tasks ( client_id );

CREATE INDEX tasks_project_id_foreign ON crm2.tasks ( project_id );

CREATE  TABLE crm2.invoice_lines ( 
	id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	external_id          VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	title                VARCHAR(255)   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	comment              TEXT   COLLATE utf8mb3_unicode_ci NOT NULL   ,
	price                INT    NOT NULL   ,
	invoice_id           INT UNSIGNED      ,
	offer_id             INT UNSIGNED      ,
	`type`               VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	quantity             INT       ,
	product_id           VARCHAR(255)   COLLATE utf8mb3_unicode_ci    ,
	created_at           TIMESTAMP       ,
	updated_at           TIMESTAMP       ,
	deleted_at           TIMESTAMP       
 ) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE INDEX invoice_lines_offer_id_foreign ON crm2.invoice_lines ( offer_id );

CREATE INDEX invoice_lines_invoice_id_foreign ON crm2.invoice_lines ( invoice_id );

ALTER TABLE crm2.absences ADD CONSTRAINT absences_user_id_foreign FOREIGN KEY ( user_id ) REFERENCES crm2.users( id ) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE crm2.appointments ADD CONSTRAINT appointments_client_id_foreign FOREIGN KEY ( client_id ) REFERENCES crm2.clients( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.appointments ADD CONSTRAINT appointments_user_id_foreign FOREIGN KEY ( user_id ) REFERENCES crm2.users( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.business_hours ADD CONSTRAINT business_hours_settings_id_foreign FOREIGN KEY ( settings_id ) REFERENCES crm2.settings( id ) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE crm2.clients ADD CONSTRAINT clients_industry_id_foreign FOREIGN KEY ( industry_id ) REFERENCES crm2.industries( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.clients ADD CONSTRAINT clients_user_id_foreign FOREIGN KEY ( user_id ) REFERENCES crm2.users( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.comments ADD CONSTRAINT comments_user_id_foreign FOREIGN KEY ( user_id ) REFERENCES crm2.users( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.contacts ADD CONSTRAINT contacts_client_id_foreign FOREIGN KEY ( client_id ) REFERENCES crm2.clients( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.department_user ADD CONSTRAINT department_user_department_id_foreign FOREIGN KEY ( department_id ) REFERENCES crm2.departments( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.department_user ADD CONSTRAINT department_user_user_id_foreign FOREIGN KEY ( user_id ) REFERENCES crm2.users( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.invoice_lines ADD CONSTRAINT invoice_lines_invoice_id_foreign FOREIGN KEY ( invoice_id ) REFERENCES crm2.invoices( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.invoice_lines ADD CONSTRAINT invoice_lines_offer_id_foreign FOREIGN KEY ( offer_id ) REFERENCES crm2.offers( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.invoices ADD CONSTRAINT invoices_client_id_foreign FOREIGN KEY ( client_id ) REFERENCES crm2.clients( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.invoices ADD CONSTRAINT invoices_offer_id_foreign FOREIGN KEY ( offer_id ) REFERENCES crm2.offers( id ) ON DELETE SET NULL ON UPDATE NO ACTION;

ALTER TABLE crm2.leads ADD CONSTRAINT leads_client_id_foreign FOREIGN KEY ( client_id ) REFERENCES crm2.clients( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.leads ADD CONSTRAINT leads_status_id_foreign FOREIGN KEY ( status_id ) REFERENCES crm2.statuses( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.leads ADD CONSTRAINT leads_user_assigned_id_foreign FOREIGN KEY ( user_assigned_id ) REFERENCES crm2.users( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.leads ADD CONSTRAINT leads_user_created_id_foreign FOREIGN KEY ( user_created_id ) REFERENCES crm2.users( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.mails ADD CONSTRAINT mails_user_id_foreign FOREIGN KEY ( user_id ) REFERENCES crm2.users( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.offers ADD CONSTRAINT offers_client_id_foreign FOREIGN KEY ( client_id ) REFERENCES crm2.clients( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.payments ADD CONSTRAINT payments_invoice_id_foreign FOREIGN KEY ( invoice_id ) REFERENCES crm2.invoices( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.permission_role ADD CONSTRAINT permission_role_permission_id_foreign FOREIGN KEY ( permission_id ) REFERENCES crm2.permissions( id ) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE crm2.permission_role ADD CONSTRAINT permission_role_role_id_foreign FOREIGN KEY ( role_id ) REFERENCES crm2.roles( id ) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE crm2.projects ADD CONSTRAINT projects_client_id_foreign FOREIGN KEY ( client_id ) REFERENCES crm2.clients( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.projects ADD CONSTRAINT projects_invoice_id_foreign FOREIGN KEY ( invoice_id ) REFERENCES crm2.invoices( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.projects ADD CONSTRAINT projects_status_id_foreign FOREIGN KEY ( status_id ) REFERENCES crm2.statuses( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.projects ADD CONSTRAINT projects_user_assigned_id_foreign FOREIGN KEY ( user_assigned_id ) REFERENCES crm2.users( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.projects ADD CONSTRAINT projects_user_created_id_foreign FOREIGN KEY ( user_created_id ) REFERENCES crm2.users( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.role_user ADD CONSTRAINT role_user_role_id_foreign FOREIGN KEY ( role_id ) REFERENCES crm2.roles( id ) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE crm2.role_user ADD CONSTRAINT role_user_user_id_foreign FOREIGN KEY ( user_id ) REFERENCES crm2.users( id ) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE crm2.tasks ADD CONSTRAINT tasks_client_id_foreign FOREIGN KEY ( client_id ) REFERENCES crm2.clients( id ) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE crm2.tasks ADD CONSTRAINT tasks_project_id_foreign FOREIGN KEY ( project_id ) REFERENCES crm2.projects( id ) ON DELETE SET NULL ON UPDATE NO ACTION;

ALTER TABLE crm2.tasks ADD CONSTRAINT tasks_status_id_foreign FOREIGN KEY ( status_id ) REFERENCES crm2.statuses( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.tasks ADD CONSTRAINT tasks_user_assigned_id_foreign FOREIGN KEY ( user_assigned_id ) REFERENCES crm2.users( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE crm2.tasks ADD CONSTRAINT tasks_user_created_id_foreign FOREIGN KEY ( user_created_id ) REFERENCES crm2.users( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

