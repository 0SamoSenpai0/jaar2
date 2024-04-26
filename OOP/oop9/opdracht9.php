<!-- Auteur Yermaih Waterfort -->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wakken en de IJsberen</title>
    <style>
    /* styling voor wat leuke kleuren en opmaak*/
    body {
        font-family: 'Comic Sans MS', 'Arial', sans-serif;
        background-color: #f0f8ff; 
        color: #333;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff; 
        border: 2px solid #007bff; 
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #e8f4f8;
    }
    form {
        margin-bottom: 20px;
    }
    h3 {
        color: #007bff; 
        font-family: 'Comic Sans MS', 'Arial', sans-serif;
    }
</style>

</head>
<body>
<?php
session_start();

// Spelregels
$regels = [
    1 => ['wakken' => 1, 'ijsberen' => 0, 'pinguins' => 6],
    2 => ['wakken' => 0, 'ijsberen' => 0, 'pinguins' => 0],
    3 => ['wakken' => 1, 'ijsberen' => 2, 'pinguins' => 4],
    4 => ['wakken' => 0, 'ijsberen' => 0, 'pinguins' => 0],
    5 => ['wakken' => 1, 'ijsberen' => 4, 'pinguins' => 2],
    6 => ['wakken' => 0, 'ijsberen' => 0, 'pinguins' => 0]
];

// reset de pagina/spel zelf
if (isset($_POST['reset'])) {
    session_destroy();
    session_start();
    $_SESSION['history'] = [];
    $_SESSION['spelAfgemaakt'] = true;
}

// maakt de spelgeschiedenis
function updateSpelgeschiedenisMetAantalDobbelstenen() {
    foreach ($_SESSION['history'] as $index => $spel) {
        if (!isset($spel['aantalGegooideDobbelstenen'])) {
            $_SESSION['history'][$index]['aantalGegooideDobbelstenen'] = 'Onbekend';
        }
    }
}

// het spel zelf laten werken
function gooiDobbelstenen($aantalDobbelstenen, $regels) {
    $resultaten = ['dobbelstenen' => [], 'wakken' => 0, 'ijsberen' => 0, 'pinguins' => 0];
    for ($i = 0; $i < $aantalDobbelstenen; $i++) {
        $worp = rand(1, 6);
        $resultaten['dobbelstenen'][] = $worp;
        $resultaten['wakken'] += $regels[$worp]['wakken'];
        $resultaten['ijsberen'] += $regels[$worp]['ijsberen'];
        $resultaten['pinguins'] += $regels[$worp]['pinguins'];
    }
    return $resultaten;
}

// Update de geschiedenis
updateSpelgeschiedenisMetAantalDobbelstenen();

// kijkt of er een nieuwe gooi of antwoord actie is
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gooi'])) {
    $_SESSION['resultaten'] = gooiDobbelstenen($_POST['aantalDobbelstenen'], $regels);
    $_SESSION['aantalGegooideDobbelstenen'] = $_POST['aantalDobbelstenen'] ?? ($_SESSION['aantalGegooideDobbelstenen'] ?? 0);
    $_SESSION['fouten'] = 0;
    $_SESSION['spelAfgemaakt'] = true;
}

//  kijkt naar de antwoord van de speler
if (isset($_POST['raden'])) {
    $geradenWakken = $_POST['wakken'];
    $geradenIjsberen = $_POST['ijsberen'];
    $geradenPinguins = $_POST['pinguins'];

    if ($geradenWakken != $_SESSION['resultaten']['wakken'] || 
        $geradenIjsberen != $_SESSION['resultaten']['ijsberen'] || 
        $geradenPinguins != $_SESSION['resultaten']['pinguins']) {
        $_SESSION['fouten']++;
        
        // na 2 fouten krijg je een hint
        if ($_SESSION['fouten'] == 2) {
            $hint = "Denk aan de dieren: Een 1 betekent 1 wak en 6 pinguïns!";
            echo "<p>Hint: {$hint}</p>";
        }
    }
    
    // Vergelijkt de antwoord met de correcte waarde
    if ($geradenWakken == $_SESSION['resultaten']['wakken'] && 
        $geradenIjsberen == $_SESSION['resultaten']['ijsberen'] && 
        $geradenPinguins == $_SESSION['resultaten']['pinguins']) {
        echo "<p>Je hebt het correct geraden!</p>";
        $_SESSION['spelAfgemaakt'] = true;
        array_unshift($_SESSION['history'], [
            'fouten' => $_SESSION['fouten'],
            'afgemaakt' => $_SESSION['spelAfgemaakt'],
            'aantalGegooideDobbelstenen' => $_SESSION['aantalGegooideDobbelstenen'] // hier zitten al de gegooide dobbelstenen in
        ]);
        $_SESSION['history'] = array_slice($_SESSION['history'], 0, 5);

        
        // Reset de resultaten voor het volgende spel
        unset($_SESSION['resultaten']);

    } else {
        echo "<p>Helaas, dat is niet correct.</p>";
        $_SESSION['spelAfgemaakt'] = false;
    }
}

// kijkt of het spel afgemaakt is door op "geef antwoord" te drukken
if (isset($_POST['oplossing'])) {
    $_SESSION['spelAfgemaakt'] = false;
    echo "<p>De oplossing was: Wakken - {$_SESSION['resultaten']['wakken']}, IJsberen - {$_SESSION['resultaten']['ijsberen']}, Pinguïns - {$_SESSION['resultaten']['pinguins']}</p>";
    array_unshift($_SESSION['history'], [
        'fouten' => $_SESSION['fouten'],
        'afgemaakt' => $_SESSION['spelAfgemaakt'],
        'aantalGegooideDobbelstenen' => $_SESSION['aantalGegooideDobbelstenen']
    ]);
    $_SESSION['history'] = array_slice($_SESSION['history'], 0, 5);
    
    // Reset de resultaten voor het nieuwe spel
    unset($_SESSION['resultaten']);
    unset($_SESSION['fouten']);
    unset($_SESSION['aantalGegooideDobbelstenen']);
}
?>

<!-- hoofdcode voor de html gedeelte... -->
<?php if (!isset($_SESSION['resultaten'])): ?>
    <form method="post">
        <label for="aantalDobbelstenen">hoeveel dobblestenen wilt u gebruiken (3-8): </label>
        <input type="number" id="aantalDobbelstenen" name="aantalDobbelstenen" min="3" max="8" required>
        <button type="submit" name="gooi">Gooi de dobbelstenen</button>
    </form>
<?php else: ?>
    <p>Dobbelstenen geworpen: <br>
        <?php 
        foreach ($_SESSION['resultaten']['dobbelstenen'] as $dobbelsteen) {
            echo '<img src="images/dice'.$dobbelsteen.'.png" alt="dobbelsteen" style="width: 100px; height: 100px;">';
        }
        ?>
    </p>
    <form method="post">
        <input type="number" name="wakken" placeholder="Aantal wakken" required>
        <input type="number" name="ijsberen" placeholder="Aantal ijsberen" required>
        <input type="number" name="pinguins" placeholder="Aantal pinguïns" required>
        <button type="submit" name="raden">antwoord</button>
    </form>
    <form method="post">
        <button type="submit" name="oplossing">Geef het antwoord</button>
    </form>
<?php endif; ?>

<!-- laat huidige spel zien-->
<h3>Huidige spel:</h3>
<table>
    <tr>
        <th>foute antwoorden in huidige spel</th>
    </tr>
    <tr>
        <td><?php echo $_SESSION['fouten'] ?? 0; ?></td>
    </tr>
</table>

<!-- Toon spelgeschiedenis -->
<h3>geschiedenis</h3>
<table>
    <tr>
        <th>Aantal dobbelstenen gegooid</th>
        <th>hoeveel spellen verloren</th>
        <th>hoeveel spellen gewonnen</th>
        
    </tr>
    <?php foreach ($_SESSION['history'] as $spel): ?>
        <tr>
            <td><?php echo $spel['aantalGegooideDobbelstenen']; ?></td>
            <td><?php echo $spel['fouten']; ?></td>
            <td><?php echo $spel['afgemaakt'] ? 'Ja' : 'om antwoord gevraagd'; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<form method="post">
    <button type="submit" name="reset">Reset spel</button>
</form>

</body>
</html>
