<?php

$width = "";
$height = "";
$units = "";

// validate the user-input unit,
// making it an empty string if it contains anything other than lowercase letters a through z;
// also sanitize user-input width and height
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $units = filter_input(
        INPUT_POST,
        "units",
        FILTER_VALIDATE_REGEXP,
        array("options" => array("regexp" => "/^[a-z]+$/"))
    );

    $width = filter_input(INPUT_POST, "width", FILTER_SANITIZE_SPECIAL_CHARS);
    $height = filter_input(INPUT_POST, "height", FILTER_SANITIZE_SPECIAL_CHARS);
}

// keep selected the dropdown item corresponding to the submitted unit
function selectUnit($unit)
{
    global $units;

    if (isset($units) && $units == $unit) {
        echo "selected";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rectangle properties calculator</title>
</head>

<body>

    <h1>Enter the width and height of a rectangle to calculate its area and perimeter!</h1>

    <!-- submit form to the same page -->
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">

        <label for="units">Choose length units:</label>
        <select id="units" name="units">
            <option value="m" <?php selectUnit("m"); ?>>Meters (m)</option>
            <option value="cm" <?php selectUnit("cm"); ?>>Centimeters (cm)</option>
            <option value="ft" <?php selectUnit("ft"); ?>>Feet (ft)</option>
            <option value="in" <?php selectUnit("in"); ?>>Inches (in)</option>
        </select>
        <br />
        <!--// input units -->

        <label for="width">Width:</label>
        <input type="text" id="width" name="width" required value="<?php echo $width; ?>">
        <br />
        <!--// input width -->

        <label for="height">Height:</label>
        <input type="text" id="height" name="height" required value="<?php echo $height; ?>">
        <br />
        <!--// input height -->

        <input type="submit" name="submit" value="Calculate">
        <!--// submit form -->

    </form>

</body>

</html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // validate lengths, making them empty strings if they are not valid floating-point numbers
    $width = filter_input(INPUT_POST, "width", FILTER_VALIDATE_FLOAT);
    $height = filter_input(INPUT_POST, "height", FILTER_VALIDATE_FLOAT);

    // print an error message if validated lengths are empty strings,
    // otherwise calculate area and perimeter
    if (empty($width) || empty($height)) {
        echo "Please enter a valid width and height of the rectangle!<br />";
    } else {
        $area = $width * $height;
        $perimeter = 2 * $width + 2 * $height;

        // print results title
        echo "The area and perimeter of a ";
        // special wording if square
        if ($width == $height) {
            echo "square with the side length of {$width} {$units}";
        } else {
            echo "rectangle of width {$width} {$units} and height {$height} {$units}";
        }
        echo "<br />";

        // print results
        echo "Area: {$area} {$units}<sup>2</sup><br />";
        echo "Perimeter: {$perimeter} {$units}";
    }
}

?>