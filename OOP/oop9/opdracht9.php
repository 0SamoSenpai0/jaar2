<!DOCTYPE html>
<html lang="nl">
<!--Stijlen voor de leesbaarheid en het uiterlijk van de tabel en formulieren -->
<style>
        /* Stijlen voor de leesbaarheid en het uiterlijk van de tabel en formulieren */
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #e8f4f8; }
        form { margin-bottom: 20px; }
        h3 { color: #333; }
    </style>
<head>
    <meta charset="UTF-8">
    <title>Wakken en de IJsberen</title>
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



// Reset het spel en voorgaande puntentelling
if (isset($_POST['reset'])) {
    session_destroy();
    session_start();
    $_SESSION['history'] = [];
    $_SESSION['spelAfgemaakt'] = true;
}

// Geeft een spelgeschiedenis met een consistent formaat
function updateSpelgeschiedenisMetAantalDobbelstenen() {
    foreach ($_SESSION['history'] as $index => $spel) {
        if (!isset($spel['aantalGegooideDobbelstenen'])) {
            $_SESSION['history'][$index]['aantalGegooideDobbelstenen'] = 'Onbekend';
        }
    }
}

// Functie om het spel te spelen
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

// Update de geschiedenis indien nodig
updateSpelgeschiedenisMetAantalDobbelstenen();

// Check voor een nieuwe worp of een raden actie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gooi'])) {
    $_SESSION['resultaten'] = gooiDobbelstenen($_POST['aantalDobbelstenen'], $regels);
    $_SESSION['aantalGegooideDobbelstenen'] = $_POST['aantalDobbelstenen'] ?? ($_SESSION['aantalGegooideDobbelstenen'] ?? 0);
    $_SESSION['fouten'] = 0;
    $_SESSION['spelAfgemaakt'] = true;
}

// Verwerkt een gok van de gebruiker
if (isset($_POST['raden'])) {
    $geradenWakken = $_POST['wakken'];
    $geradenIjsberen = $_POST['ijsberen'];
    $geradenPinguins = $_POST['pinguins'];

    if ($geradenWakken != $_SESSION['resultaten']['wakken'] || 
        $geradenIjsberen != $_SESSION['resultaten']['ijsberen'] || 
        $geradenPinguins != $_SESSION['resultaten']['pinguins']) {
        $_SESSION['fouten']++;
        
        // Als er drie fouten zijn, geef een hint
        if ($_SESSION['fouten'] == 3) {
            $hint = "Denk aan de dieren: Een 1 betekent 1 wak en 6 pinguïns!";
            echo "<p>Hint: {$hint}</p>";
        }
    }
    
    // Vergelijk met de daadwerkelijke waarden
    if ($geradenWakken == $_SESSION['resultaten']['wakken'] && 
        $geradenIjsberen == $_SESSION['resultaten']['ijsberen'] && 
        $geradenPinguins == $_SESSION['resultaten']['pinguins']) {
        echo "<p>Je hebt het correct geraden!</p>";
        $_SESSION['spelAfgemaakt'] = true;
        array_unshift($_SESSION['history'], [
            'fouten' => $_SESSION['fouten'],
            'afgemaakt' => $_SESSION['spelAfgemaakt'],
            'aantalGegooideDobbelstenen' => $_SESSION['aantalGegooideDobbelstenen'] // Dit zal het aantal gegooide dobbelstenen bevatten
        ]);
        $_SESSION['history'] = array_slice($_SESSION['history'], 0, 5);

        
        // Reset de resultaten voor het volgende spel
        unset($_SESSION['resultaten']);

    } else {
        echo "<p>Helaas, dat is niet correct.</p>";
        $_SESSION['spelAfgemaakt'] = false;
    }
}

    // Markeer het spel als niet afgemaakt
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

<!-- HTML voor het spel hier... -->
<?php if (!isset($_SESSION['resultaten'])): ?>
    <form method="post">
        <label for="aantalDobbelstenen">Kies het aantal dobbelstenen wat je wilt gebruiken (3-8): </label>
        <input type="number" id="aantalDobbelstenen" name="aantalDobbelstenen" min="3" max="8" required>
        <button type="submit" name="gooi">Gooi dobbelstenen</button>
    </form>
<?php else: ?>
    <p>Dobbelstenen geworpen: <?php echo implode(', ', $_SESSION['resultaten']['dobbelstenen']); ?></p>
    <form method="post">
        <input type="number" name="wakken" placeholder="Aantal wakken" required>
        <input type="number" name="ijsberen" placeholder="Aantal ijsberen" required>
        <input type="number" name="pinguins" placeholder="Aantal pinguïns" required>
        <button type="submit" name="raden">Raad</button>
    </form>
    <form method="post">
        <button type="submit" name="oplossing">Geef oplossing</button>
    </form>
<?php endif; ?>

<!-- Toon huidige spelstatus -->
<h3>Huidige spel:</h3>
<table>
    <tr>
        <th>Aantal fout geraden in dit spel</th>
    </tr>
    <tr>
        <td><?php echo $_SESSION['fouten'] ?? 0; ?></td>
    </tr>
</table>

<!-- Toon spelgeschiedenis -->
<h3>Spelgeschiedenis</h3>
<table>
    <tr>
        <th>Aantal gegooide dobbelstenen</th>
        <th>Aantal fouten</th>
        <th>Spel gewonnen?</th>
        
    </tr>
    <?php foreach ($_SESSION['history'] as $spel): ?>
        <tr>
            <td><?php echo $spel['aantalGegooideDobbelstenen']; ?></td>
            <td><?php echo $spel['fouten']; ?></td>
            <td><?php echo $spel['afgemaakt'] ? 'Ja' : 'Nee, om antwoorden gevraagd'; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<form method="post">
    <button type="submit" name="reset">Reset spel</button>
</form>

</body>
</html>