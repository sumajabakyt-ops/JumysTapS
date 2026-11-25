
<?php
$getResult = "";
$postResult = "";

// GET арқылы мәлімет қабылдау
if ($_SERVER["REQUEST_METHOD"] === "GET"
    && isset($_GET["search"])) {

    $search = trim($_GET["search"]);

    if ($search === "") {
        $getResult = "Іздеу өрісін толтырыңыз!";
    } else {
        $getResult = "Сіз іздеген жұмыс: " .
            htmlspecialchars($search, ENT_QUOTES, "UTF-8");
    }
}

// POST арқылы мәлімет қабылдау
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");

    if ($name === "") {
        $postResult = "Атыңызды енгізіңіз!";
    } elseif (mb_strlen($name) < 2) {
        $postResult = "Атыңыз кемінде 2 таңбадан тұруы керек!";
    } else {
        $postResult = "Сәлеметсіз бе, " .
            htmlspecialchars($name, ENT_QUOTES, "UTF-8") .
            "! Мәлімет қабылданды.";
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP формаларын тексеру</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container section">

    <h1>PHP формаларын тексеру</h1>

    <h2>1. GET формасы</h2>

    <form method="GET" action="form-test.php">
        <input
            type="text"
            name="search"
            placeholder="Жұмыс атауын енгізіңіз"
        >

        <button class="btn btn-primary" type="submit">
            Іздеу
        </button>
    </form>

    <p><?php echo $getResult; ?></p>

    <hr>

    <h2>2. POST формасы</h2>

    <form method="POST" action="form-test.php">

        <input
            type="text"
            name="name"
            placeholder="Атыңызды енгізіңіз"
        >

        <button class="btn btn-primary" type="submit">
            Жіберу
        </button>

    </form>

    <p><?php echo $postResult; ?></p>

    <a href="index.php">Басты бетке оралу</a>

</div>

</body>
</html>
