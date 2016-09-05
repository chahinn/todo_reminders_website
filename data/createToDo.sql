DROP TABLE IF EXISTS SUBSCRIPTION;
DROP TABLE IF EXISTS TODOITEMS;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS LIST;

CREATE TABLE USER(
	UserID int not null auto_increment,
	FirstName varchar(15) not null,
	LastName varchar(15) not null,
	UserName varchar(15) not null,
	Password varchar(50) not null,
	PhoneNumber varchar(11) not null,
	PRIMARY KEY(UserID),
) engine = InnoDB;

CREATE TABLE LIST(
	ListID int not null auto_increment,
	ListName varchar(15) not null,
	CreationDate datetime not null,
	PRIMARY KEY(ListID)
) engine = InnoDB;

CREATE TABLE SUBSCRIPTION(
	DumbKey int not null auto_increment,
	ListID int not null,
	UserID int not null,
	FOREIGN KEY (ListID) references LIST(ListID),
	FOREIGN KEY (UserID) references USER(UserID)
) engine = InnoDB;

CREATE TABLE TODOITEMS(
	DumbKey int not null auto_increment,
	ListID int not null,
	Subject varchar(15) not null,
	Description varchar(200),
	ReminderDate datetime,
	CreationDate datetime not null,
	FOREIGN KEY (ListID) references LIST(ListID),
	CHECK (ReminderDate >= CreationDate) OR (ReminderDate is NULL)
) engine = InnoDB;