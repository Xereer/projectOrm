<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Product List</h1>
<ul>
    <pre id="lego"></pre>
    <script>
        <?php
        use Controller\ProductController;

        $controller = new ProductController();
        $controller->index();
        ?>
        let jsonData = <?php echo $lego;?>;
        document.getElementById("lego").innerHTML = (JSON.stringify(jsonData,null,4));
    </script>
</ul>
</body>
</html>