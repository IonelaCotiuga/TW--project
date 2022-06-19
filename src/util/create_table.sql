-- the table in which the users' data will be stored
CREATE TABLE users (
    id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username varchar(50) NOT NULL,
    email varchar(320) NOT NULL,
    password varchar(100) NOT NULL
);

-- the table in which the reset password tokens will be stored
CREATE TABLE pwdreset (
  pwdResetId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  pwdResetEmail text NOT NULL,
  pwdResetSelector text NOT NULL,
  pwdResetToken longtext NOT NULL,
  pwdResetExpires text NOT NULL
);
