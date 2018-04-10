<?php
require_once "./controller/../model/productDao.php";
require_once "./controller/../model/userDao.php";


$error = "";
// ==================================================== Displaying products ====================================================================
try {
    //Returns product_id, product_name, product_color, product_price, product_img_name,sale_info_state, style, subcategory, material, sale_price
    $products = getProducts();

} catch (PDOException $e) {
    echo "pdo exception: " . $e->getMessage();
}

// All data needed for displaying the search view
if (isset($_GET["page"]) || isset($_GET["products"])) {
    $search_must_be_shown = false;
    if (isset($_GET["page"])) {
        if ($_GET["page"] == "search_result" || $_GET["page"] == "search") {
            $search_must_be_shown = true;
        }
    }
    if (isset($_GET["products"])) {
        $search_must_be_shown = true;
    }

    if ($search_must_be_shown == true) {
        try {
            $all_colors = getAllColors();
        } catch (PDOException $e) {
            $all_colors = $e->getMessage();
        }

        try {
            $all_materials = getAllMaterials();
        } catch (PDOException $e) {
            $all_materials = $e->getMessage();
        }

        try {
            $all_collections = getAllCollections();
        } catch (PDOException $e) {
            $all_collections = $e->getMessage();
        }

        try {
            $all_styles = getAllStyles();
        } catch (PDOException $e) {
            $all_styles = $e->getMessage();
        }

        try {
            $all_subcategories = getAllSubcategories();
        } catch (PDOException $e) {
            $all_subcategories = $e->getMessage();
        }

        try {
            if (isset($_GET["page"])) {
                $all_sizes = getAllSizes("men", "women", "boys", "girls");
            } else {
                if ($_GET["products"] == "men") {
                    $all_sizes = getAllSizes("men", null, null, null);
                } elseif ($_GET["products"] == "women") {
                    $all_sizes = getAllSizes(null, "women", null, null);
                } elseif ($_GET["products"] == "boys") {
                    $all_sizes = getAllSizes(null, null, "boys", null);
                } elseif ($_GET["products"] == "girls") {
                    $all_sizes = getAllSizes(null, null, null, "girls");
                } else {
                    $all_sizes = getAllSizes("men", "women", "boys", "girls");
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $sup_price = 0;

        try { //max price
            $inf_price = getInfPrice();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

//  ==== Filter =====
try {
    if (isset($_POST["advanced_search"])) {
        $products = array();
        $product_color = array();
        if (isset($_POST["colors"])) {
            $product_color = ($_POST["colors"]);
        } else {
            foreach ($all_colors as $single_color) {
                foreach ($single_color as $item) {
                    $val = $single_color["product_color"];
                    $product_color[$val] = $single_color["product_color"];
                }
            }
        }

        $material = array();
        if (isset($_POST["materials"])) {
            $material = ($_POST["materials"]);
        } else {
            foreach ($all_materials as $single_material) {
                foreach ($single_material as $item) {
                    $val = $single_material["material"];
                    $material[$val] = $val;
                }
            }
        }

        $subcategory = array();
        if (isset($_POST["subcategory"])) {
            $subcategory = ($_POST["subcategory"]);
        } else {
            foreach ($all_subcategories as $single_subcategory) {
                foreach ($single_subcategory as $item) {
                    $val = $single_subcategory["subcategory"];
                    $subcategory[$val] = $val;
                }
            }
        }

        $styles = array();
        if (isset($_POST["style"])) {
            $styles = ($_POST["style"]);
        } else {
            foreach ($all_styles as $single_style) {
                foreach ($single_style as $item) {
                    $val = $single_style["style"];
                    $styles[$val] = $val;
                }
            }
        }


        $collections = array();
        if (isset($_POST["sale_info_state"])) {
            $collections = ($_POST["sale_info_state"]);
        } else {
            foreach ($all_collections as $single_collection) {
                foreach ($single_collection as $item) {
                    $val = $single_collection["sale_info_state"];
                    $collections[$val] = $val;
                }
            }
        }


        $sizes = array();
        if (isset($_POST["sizes"])) {
            $sizes = $_POST["sizes"];
        } else {
            foreach ($all_sizes as $single_size) {
                foreach ($single_size as $item) {
                    $val = $single_size["size_number"];
                    $sizes[$val] = $val;
                }
            }
        }
        if (isset($_POST["users_inf_price"])) {
            $users_inf_price = $_POST["users_inf_price"];
            if (empty($users_inf_price) || $users_inf_price < 0 || $users_inf_price > $inf_price || !is_numeric($users_inf_price)) {
                $users_inf_price = $inf_price;
            }
        } else {
            $users_inf_price = $inf_price; // inf_price is the largest price in db
        }

        if (isset($_POST["users_sup_price"])) {
            $users_sup_price = $_POST["users_sup_price"];
            if (empty($users_sup_price) || $users_sup_price < 0 || $users_sup_price > $inf_price || !is_numeric($users_sup_price)) {
                $users_sup_price = $sup_price;
            }
            if ($users_sup_price > $users_inf_price) {
                $temp = $users_sup_price;
                $users_sup_price = $users_inf_price;
                $users_inf_price = $temp;

            }
        } else {
            $users_sup_price = $sup_price; // inf_price is the largest price in db
        }
        $products = getSearchResults($product_color, $material, $subcategory, $styles, $collections, $sizes, $users_sup_price, $users_inf_price);

        if (empty($products)) {
            setcookie("nested_error", "Nothing was found");
            header("Location:index.php?page=search_result");
            die();
        }

    }
} catch (PDOException $e) {
    echo $e->getMessage();
}


//  ==== Keyword =====

try {
    if (isset($_POST["search_bar_button"])) {
        $input = htmlentities($_POST["search_bar_input"]);
        $products = array();
        if (strlen($input) > 30) {
            setcookie("error", "Input too long!");
            header("Location:index.php?page=search_result");
            die();
        }

        $input = explode(" ", $input);
        $search_by_name_str = getResultsByKeywords($input, "product_name");
        $search_by_collection_str = getResultsByKeywords($input, "sale_info_state");
        $search_by_material_str = getResultsByKeywords($input, "material");
        $search_by_style_str = getResultsByKeywords($input, "style");
        $search_by_subcategory_str = getResultsByKeywords($input, "subcategory");
        $products = $search_by_name_str +
            $search_by_style_str +
            $search_by_collection_str +
            $search_by_material_str +
            $search_by_subcategory_str;


        if (empty($products)) {
            setcookie("nested_error", "Nothing was found");
            header("Location:index.php?page=search_result");
            die();
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    if (isset($_POST["add_product"])) {
        $product_name = htmlentities($_POST["product_name"]);
        $product_color = htmlentities($_POST["product_color"]);
        $material = htmlentities($_POST["material"]);
        $style = htmlentities($_POST["style"]);
        $subcategory = $_COOKIE["add_to_subcategory"];
        $product_price = htmlentities($_POST["product_price"]);
        $sale_info_state = htmlentities($_POST["sale_info_state"]);
        $product_img_name = "no_image.jpg";
        $sizes = [];
        $min_size = 0;
        $max_size = 0;
        if ($subcategory === "girls" || $subcategory === "boys") {
            $min_size = 25;
            $max_size = 34;
        } elseif ($subcategory === "women") {
            $min_size = 35;
            $max_size = 42;
        } elseif ($subcategory === "men") {
            $min_size = 40;
            $max_size = 48;
        }
        for ($i = $min_size; $i <= $max_size; $i++) {
            $size = [];
            $size["size_number"] = $i;
            $size["size_quantity"] = htmlentities($_POST["$i"]);
            $sizes[] = $size;

        }

        $tmp_name = $_FILES["product_img_name"]["tmp_name"];
        $orig_name = $_FILES["product_img_name"]["name"];

        if (is_uploaded_file($tmp_name)) {
            $product_img_name = "$product_name-" . date("Ymdhisa") . ".png";
            $picture_url = "assets/products_imgs/$product_img_name";
            if (move_uploaded_file($tmp_name, $picture_url)) {

            } else {
                // error The picture not moved
            }
        } else {
            // error The picture is not uploaded
            $error .= "Picture not uploaded! ";

        }
        if (empty($error)) {
            // Checking if the product already exist
            if (!productExists($product_name, $product_color, $material, $style, $subcategory)) {
                saveProduct($product_name, $sizes, $product_color, $material, $style, $subcategory, $product_price, $sale_info_state, $product_img_name);
                setcookie("product_added_successfully", "Product added successfully");
                header("Location:index.php?page=display_subcategory_page&products=$subcategory");
                die();
            } else {
                $error .= "Product already exists! ";

            }

        }

        setcookie("product_name", $product_name);
        setcookie("product_color", $product_color);
        setcookie("material", $material);
        setcookie("style", $style);
        setcookie("subcategory", $subcategory);
        setcookie("product_price", $product_price);
        setcookie("sale_info_state", $sale_info_state);
//            setcookie("size_number" ,$size_number );
//            setcookie("size_quantity" ,$size_quantity );
        header("Location:index.php?page=add_product");
        die();
    }

} catch (PDOException $e) {
    echo "pdo exception: " . $e->getMessage();

};

if (isset($_POST["edit_product"])) {
    $_SESSION["edit_product"] = [];
    foreach ($products as $product) {
        if ($product["product_id"] == $_POST["product_id"]) {
            $_SESSION["edit_product"] = $product;
            break;
        }
    }
    header("location:index.php?page=edit_product");
}

try {
    if (isset($_POST["change_product"])) {
        $product_id = $_SESSION["edit_product"]["product_id"];
        $product_name = htmlentities($_POST["product_name"]);
        $product_color = htmlentities($_POST["product_color"]);
        $material = htmlentities($_POST["material"]);
        $style = htmlentities($_POST["style"]);
        $subcategory = htmlentities($_POST["subcategory"]);
        $product_price = htmlentities($_POST["product_price"]);
        $sale_info_state = htmlentities($_POST["sale_info_state"]);
        $sale_price = htmlentities($_POST["sale_price"]);
        $product_img_name = htmlentities($_POST["product_img_name"]);
        $sizes = [];
        $product = [];
        $new_size = false;
        if ($_POST["new_size"] > 20 && $_POST["new_size"] < 50 && $_POST["new_quantity"] > 0) {
            $new_size = [];
            $new_size["size_number"] = htmlentities($_POST["new_size"]);
            $new_size["size_quantity"] = htmlentities($_POST["new_quantity"]);
        }

        $sizes = $_SESSION["edit_product"]["sizes"];
        foreach ($sizes as &$size) {
            $size_number = $size["size_number"];
            $size["size_quantity"] = $_POST["$size_number"];

            if ($new_size != false) {
                if ($new_size["size_number"] == $size_number) {
                    $new_size = false;

                }
            }
        }


        if (isset($_FILES["product_img_name"])) {
            $tmp_name = $_FILES["product_img_name"]["tmp_name"];
            $orig_name = $_FILES["product_img_name"]["name"];

            if (is_uploaded_file($tmp_name)) {
                $product_img_name = "$product_name-" . date("Ymdhisa") . ".png";
                $picture_url = "assets/products_imgs/$product_img_name";
                if (move_uploaded_file($tmp_name, $picture_url)) {

                } else {
                    // error The picture not moved
                }
            } else {
                // error The picture is not uploaded
            }
        }
        unset($_SESSION["edit_product"]);
        changeProduct($product_id, $product_name, $product_color, $material, $style, $subcategory, $product_price, $sale_info_state, $product_img_name, $sale_price, $sizes, $new_size);
        unset($_SESSION["edit_product"]);
        header("location: index.php?page=display_subcategory_page&products=$subcategory");
    }

} catch (PDOException $e) {
    echo "pdo exception: " . $e->getMessage();
};

if (isset($_SESSION["cart"])) {
    $cart_items = &$_SESSION["cart"];
} else {
    $cart_items = array();
}


if (isset($_SESSION["cart"])) {
    $cart_items = &$_SESSION["cart"];
} else {
    $cart_items = array();
}
if (isset($_GET["remove_cart"])) {
    $item_no = htmlentities($_GET["remove_cart"]);
    unset($cart_items[$item_no]);
    unset($_SESSION["cart"][$item_no]);
}
if (isset($_SESSION["favorites"])) {
    $favorites_items = &$_SESSION["favorites"];
} else {
    $favorites_items = array();
}

try {
    if (isset($_GET["move_to_cart"])) {
        $product_id = htmlentities($_GET["product_id"]);
        $id_exists = false;

            foreach ($cart_items as $item) {
                foreach ($item as $key => $value) {
                    if ($key == "product_id" && $value == $product_id) {
                        $id_exists = true;
                        break;
                    }
                }
            }

        if ($id_exists == false) {

            if ($_GET["size"] != "") {

                $product_size = htmlentities($_GET["size"]);
                $product_to_cart = [];
                $product_to_cart = getProductData($product_id);
                $product_to_cart["size"] = $product_size;
                $_SESSION["cart"][] = $product_to_cart;
                $item_no = htmlentities($_GET["move_to_cart"]);
            }
        }
    }
} catch (PDOException $e) {
    echo "pdo exception: " . $e->getMessage();
}


if (isset($_GET["remove_favorites"])) {
    $item_no = htmlentities($_GET["remove_favorites"]);
    unset($favorites_items[$item_no]);
    unset($_SESSION["favorites"][$item_no]);
}

try {

    if (isset($_POST["add_to_cart"])) {
        //Terry
        $product_id = htmlentities($_POST["product_id"]);
        $id_exists = false;
        foreach ($cart_items as $item) {
                foreach ($item as $key => $value) {
                    if ($key == "product_id" && $value == $product_id) {
                        $id_exists = true;
                        break;
                    }
                }
        }
        if ($id_exists == false) {
            // Terry
            if (isset($_POST["size"])) {
                $product_size = htmlentities($_POST["size"]);
                $product_to_cart = [];
                $product_to_cart = getProductData($product_id);
                $product_to_cart["size"] = $product_size;
                $_SESSION["cart"][] = $product_to_cart;
            }
        }
    }

} catch (PDOException $e) {
    echo "pdo exception: " . $e->getMessage();
}

try {
    $product_size = "";
    if (isset($_POST["add_to_favorites"])) {
        $product_id = htmlentities($_POST["product_id"]);
        $id_exists = false;
        foreach ($favorites_items as $item) {
            foreach ($item as $key => $value) {
                if ($key == "product_id" && $value == $product_id) {
                    $id_exists = true;
                    break;
                }
            }
        }
        if ($id_exists == false) {
            // Terry
            if (isset($_POST["size"])) {
                $product_size = htmlentities($_POST["size"]);
            }
            $product_to_fav = [];
            $product_to_fav = getProductData($product_id);
            $product_to_fav["size"] = $product_size;
            $_SESSION["favorites"][] = $product_to_fav;
        }
    }

} catch (PDOException $e) {
    echo "pdo exception: " . $e->getMessage();
}

try {
    if (isset($_POST["buy_cart"])) {
        $items_to_buy = array();
        foreach ($_SESSION["cart"] as $item) {
            $items_to_buy[] = ["product_id" => $item["product_id"], "product_size" => $item["size"]];
        }
        if (isset($_SESSION["logged_user"])) {
            $user_id = $user_info["user_id"];
            setOrder($items_to_buy, $user_id);
            $_SESSION["cart"] = array();
            $_SESSION["cart_total_price"] = 0;
            header("Location: index.php?page=history");
            die();
        }

    }

} catch (PDOException $e) {
    echo "pdo exception: " . $e->getMessage();

}


try {
    if (isset($_POST["delete_product"])) {
        $product_id = htmlentities($_POST["product_id"]);
        removeProduct($product_id);
        $current_page = $_SERVER['REQUEST_URI'];
        setcookie("message", "Product was removed successfully! ");
        header("Location:" . $current_page);
        die();
    }

} catch (PDOException $e) {
    echo "pdo exception: " . $e->getMessage();

}


try {
    if (isset($_GET["products"]) === "out_of_stock") {
        $products = array();
        $products = getProductsOutOfStock();
    }
} catch (PDOException $e) {
    $e->getMessage();
}


