/*Create table*/

CREATE TABLE `pantofka`.`users` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_email` VARCHAR(50) NOT NULL,
  `user_password` VARCHAR(100) NOT NULL,
  `user_fname` VARCHAR(50) NOT NULL,
  `user_lname` VARCHAR(50) NOT NULL,
  `user_gender` VARCHAR(1) NOT NULL,
  `user_is_admin` VARCHAR(5) NULL COMMENT 'Null if user is NOT admin ',
  PRIMARY KEY (`user_id`))
COMMENT = '`users`.`user_id`, `users`.`user_email`, `users`.`user_password`, `users`.`user_fname`, `users`.`user_lname`, `users`.`user_gender`, `users`.`user_is_admin`';

/*Add admin*/

INSERT INTO users 
(user_email, user_password, user_fname, user_lname ,user_gender , user_is_admin)
VALUES ('admin@admin.admin', sha1('admin'), 'Admin', 'Admin' , 'f' , true);

SELECT * FROM pantofka.users;

