<?php

class NumeralConverter
{
    private $roman_numerals = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    ];

    public function RomanToInteger($roman)
    {
        $result = 0;
        foreach ($this->roman_numerals as $key => $value) {
            while (strpos($roman, $key) === 0) {
                $result += $value;
                $roman = substr($roman, strlen($key));
            }
        }
        return $result;
    }

    public function IntegerToRoman($integer)
    {
        $result = '';
        foreach ($this->roman_numerals as $key => $value) {
            while ($integer >= $value) {
                $result .= $key;
                $integer -= $value;
            }
        }
        return $result;
    }
}

// Tester function
function tester()
{
    $converter = new NumeralConverter();

    $testCases = [
        'V' => 5,
        'X' => 10,
        'Iv' => 4,
        // Mixed case
        'MCMXC' => 1990,
        'IX' => 9,
        '1' => 'I',
        '4' => 'IV',
        '90' => 'XC',
        'ABC' => 'Invalid',
        // Number too large for Roman numeral conversion
        '' => 'Invalid',
        // Empty string
        '0' => '' // Zero is not representable in Roman numerals
    ];

    foreach ($testCases as $input => $expected) {
        $output = '';
        if (preg_match("/^[IVXLCDM]+$/i", strtoupper($input))) {
            $output = $converter->RomanToInteger(strtoupper($input));
        } elseif (preg_match("/^\d+$/", $input)) {
            $output = $converter->IntegerToRoman((int) $input);
        } else {
            $output = "Invalid";
        }

        if ($output == $expected) {
            echo "Test case {$input} passed. Output: {$output}<br>";
        } else {
            echo "<span style='color:red;'>Test case {$input} failed. Expected: {$expected}, Got: {$output}</span><br>";
        }
    }
}

tester();

if (isset($_FILES['filename']) && $_FILES['filename']['size'] > 0) {
    $name = $_FILES['filename']['name'];
    move_uploaded_file($_FILES['filename']['tmp_name'], $name);
    echo $name;
    $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    // Check if file is a .txt file
    if ($fileType != "txt") {
        die("Sorry, only .txt files are allowed.");
    }
    if (!file_exists($name)) {
        die("Error: File was not uploaded successfully.");
    }

    // Read the file content
    $content = file_get_contents($name);
    echo "File Content: " . $content . "<br>";

    // Split the content by commas
    $values = explode(',', $content);

    echo "Here are the values: " . implode(', ', $values) . "<br>";

    // Use the converter class
    $converter = new NumeralConverter();
    $results = [];

    foreach ($values as $value) {
        $value = trim($value); // Remove any whitespace
        if (preg_match("/^[IVXLCDM]+$/i", strtoupper($value))) {
            $results[] = $converter->RomanToInteger(strtoupper($value));
        } elseif (preg_match("/^\d+$/", $value)) {
            $results[] = $converter->IntegerToRoman((int) $value);
        } else {
            $results[] = "Invalid";
        }
    }

    echo "Converted values: " . implode(', ', $results);
    unlink($name);

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP Form Upload</title>
</head>

<body>
    <p>Form</p>
    <form method='post' action='RomanIntConverter.php' enctype='multipart/form-data'>
        Upload file:
        <input type='file' name='filename' size='10'>
        <input type='submit' value='Upload'>
    </form>
</body>

</html>