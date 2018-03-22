CREATE TABLE pantofka.`products` (
product_id INT NOT NULL AUTO_INCREMENT,
product_name VARCHAR(45) NOT NULL,
product_size INT NOT NULL,
product_color VARCHAR(45) NOT NULL,
product_style VARCHAR(45) NOT NULL,
subcategory VARCHAR(45) NOT NULL,
product_price VARCHAR(45) NOT NULL,
product_quantity INT NOT NULL,
new_product TINYINT NOT NULL,
on_promotion TINYINT NOT NULL,
price_on_promotion INT NULL,
PRIMARY KEY (product_id));

CREATE TABLE pantofka.`orders` (
  order_id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  date DATE NOT NULL,
  PRIMARY KEY (order_id));