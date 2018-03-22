<?php

const PDO_CONNECTION_DNS = "mysql:host=localhost:3306;dbname=pantofka";
const PDO_CONNECTION_USERNAME = "root";
const PDO_CONNECTION_PASSWORD = "";

$pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );


