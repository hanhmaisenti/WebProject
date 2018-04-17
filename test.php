<?php
//assign an array of stuff to the array variable $tilly
$tilly = array("Blah blah", "gfdgdgdg", "gfgfgfgfdggdghtyu");
$somestring = "Some Random Text with html <strong>formatting</strong>";

echo $somestring;

echo "<p>for debugging we can use print_r()</p>";
echo "<pre>";
print_r($tilly);
echo "</pre>";

echo "<p>or we can use var_dump() for arrays etc</p>";
var_dump($tilly);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            .outline {
            border: 1px solid #646360;
            border-radius: 5px;
            padding: 10px 10px;
            margin: 4%;
            }
            .outline_grey {
                background-color:rgb(196, 190, 190);
            }
            .outline_yellow {
                background-color:#f3f3b4;
            }
</style>
    </head>

    <body>
        <div class="outline outline_grey">
            <p>We can access data from the PHP section inside the HTML section like this:</p>
            <?php var_dump($tilly);?>
            <p>Note: This uses a little bit of CSS to format this area.</p>
        </div>

        <form class="outline outline_yellow" action="test.php">
            <p>
                For Forms, we can submit data for processing by itself, or other pages
                This example submits firstname and lastname into the url of this page (take a look)
            </p>
            First name:
            <br>
            <input type="text" name="firstname">

            <br> Last name:
            <br>
            <input type="text" name="lastname">

            <br>
            <br>
            <input type="submit" value="Submit">
        </form>
    </body>

    </html>