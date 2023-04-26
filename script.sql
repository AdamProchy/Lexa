CREATE TABLE credentials(
    ID int primary key identity(1,1),
    username nvarchar(50) not null,
    password nvarchar(50) not null
);

INSERT INTO credentials (username,password)
VALUES ('admin','admin');