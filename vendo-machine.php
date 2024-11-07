<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendo Machine</title>
    <style>
        fieldset {
            width: 500px; 
        }
        legend {
            font-weight: bold;
            padding: 0 5px; 
        }
    </style>
</head>
<body>

    <?php 
        
        function getDrinks() {
            return [
                'Coke' => 15,
                'Sprite' => 20,
                'Royal' => 20,
                'Pepsi' => 15,
                'Mountain Dew' => 20
            ];
        }

        function getSizes() {
            return [
                'Regular' => 0,
                'Up-Size' => 5,
                'Jumbo' => 10
            ];
        }

        function renderDrinksOptions($drinks) {
            foreach ($drinks as $key => $value) {
                echo "<input type='checkbox' name='chkDrinks[]' id='chkDrink{$key}' value='{$key}'>";
                echo "<label for='chkDrink{$key}'>{$key} - ₱{$value}</label><br>";
            }
        }

        function renderSizeOptions($sizes) {
            foreach ($sizes as $key => $value) {
                $additionalCost = $value > 0 ? " (add ₱{$value})" : "";
                echo "<option value='{$key}'>{$key}{$additionalCost}</option>";
            }
        }

        function calculatePurchaseSummary($drinksChoosen, $size, $quantity, $drinks, $sizes) {
            $total = 0;
            $totalItems = 0;
            echo "<hr><h1>Purchase Summary: </h1><ul>";

            foreach ($drinksChoosen as $drink) {
                $cost = ($drinks[$drink] + $sizes[$size]) * $quantity;
                $total += $cost;
                $totalItems += $quantity;
                echo "<li>{$quantity} " . ($quantity > 1 ? 'pieces' : 'piece') . " of {$size} {$drink} amounting to ₱{$cost}</li>";
            }

            echo "</ul>";
            echo "<b>Total Number of Items: {$totalItems}</b><br>";
            echo "<b>Total Amount: ₱{$total}</b>";
        }
    ?>

    <form method="post">
        <h1>Vendo Machine</h1>

        <fieldset>
            <legend>Products: </legend>
            <?php renderDrinksOptions(getDrinks()); ?>
        </fieldset>

        <fieldset>
            <legend>Options: </legend>
            <label for="drpSizes">Size</label>
            <select name="drpSizes" id="drpSizes">
                <?php renderSizeOptions(getSizes()); ?>
            </select>

            <label for="noQuantity">Quantity</label>
            <input type="number" name="noQuantity" id="noQuantity" min="1" value="1">
            <button type="submit" name="btnCheck">Check out</button>
        </fieldset>
    </form>

    <?php
        if (isset($_POST['btnCheck'])) {
            $drinks = getDrinks();
            $sizes = getSizes();

            if (empty($_POST['chkDrinks'])) {
                echo "<h1>No Selected Item, Try Again.</h1>";
            } else {
                $drinksChoosen = $_POST['chkDrinks'];
                $size = $_POST['drpSizes'];
                $quantity = $_POST['noQuantity'];

                calculatePurchaseSummary($drinksChoosen, $size, $quantity, $drinks, $sizes);
            }
        }
    ?>

</body>
</html>
