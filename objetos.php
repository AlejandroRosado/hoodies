<!DOCTYPE html>
<html>
<head>
    <title>Tienda de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        .product {
            background-color: #fff;
            border: 1px solid #ddd;
            margin: 10px;
            padding: 10px;
            text-align: center;
            width: 200px;
            display: inline-block;
        }

        .product img {
        max-width: 100%;
        height: 200px; /* Define la altura deseada para las imágenes */
        }

        .cart {
            float: right;
        }
    </style>
</head>

<body>
    <h1>PAIR HOODIES</h1>


    <?php
    session_start();

    function addToCart($productName, $productPrice) {
        $_SESSION['cart'][] = array('name' => $productName, 'price' => $productPrice);
        $_SESSION['total'] = isset($_SESSION['total']) ? $_SESSION['total'] + $productPrice : $productPrice;
    }


    function removeFromCart($index) {
        $removedItem = $_SESSION['cart'][$index];
        $removedPrice = $removedItem['price'];
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        $_SESSION['total'] = isset($_SESSION['total']) ? $_SESSION['total'] - $removedPrice : 0;
    }


    if (isset($_GET['add'])) {
        $productName = $_GET['add']['name'];
        $productPrice = floatval($_GET['add']['price']);
        addToCart($productName, $productPrice);
    }


    if (isset($_GET['remove'])) {
        $index = intval($_GET['remove']);
        if (isset($_SESSION['cart'][$index])) {
            removeFromCart($index);
        }
    }
    ?>

    <div class="cart">
        <h2>Carrito de Compras</h2>
        <ul>
            <?php
            if(isset($_SESSION['cart'])) {
                foreach($_SESSION['cart'] as $item) {
                    echo '<li>' . $item['name'] . ' - $' . number_format($item['price'], 2) . ' <a href="?remove=' . array_search($item, $_SESSION['cart']) . '">Quitar</a></li>';
                }
            }
            $total = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
            ?>
            <li>Total: $<?= number_format($total, 2) ?></li>
        </ul>
    </div>
    
    <?php
        // conecto a la bbdd
                $conn = new mysqli("localhost","root","","trabajo");
        // select * from productos
                $sql = "select * from productos";
        // un bucle que por cada producto me muestre este esquma
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                    echo "<img src='";
                    echo $row['imagen'];
                    echo "' alt='Producto ";
                    echo $row['id'];
                    echo "'>";
                echo "<h2>Producto ";
                echo $row['id'];
                echo "</h2>";
                    echo "<p>Precio: $" ;
                    echo $row['precio'];
                    echo "</p>";
                echo "<a href='?add[name]=Producto%20";
                echo $row['id'];
                echo "&add[price]=";
                echo  $row['precio'];
                echo "'>Añadir al Carrito</a>";
                echo "</div>";
            }
           
            $conn->close();
    ?>
</body>
</html>
