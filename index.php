<?php
session_start();

// Session-Speicher initialisieren
if (!isset($_SESSION["speicher"])) {
    $_SESSION["speicher"] = null;
}

// Session-Speicher für die Listbox
if (!isset($_SESSION["ergebnisspeicher"])) {
    $_SESSION["ergebnisspeicher"] = [];
}

$zahl1 = $_POST["zahl1"] ?? "";
$zahl2 = $_POST["zahl2"] ?? "";
$operator = $_POST["operator"] ?? "+";
$ergebnis = $_POST["ergebnis"] ?? "";

/*
 AUSBAUSTUFE 3 – Funktionslogik
*/

// CLEAR (C) → Eingaben & Ergebnis löschen
if (isset($_POST["btnC"])) {
    $zahl1 = $zahl2 = $ergebnis = "";
}

// Rechnen nun ausgelagert (= oder M+) → nur wenn beide Zahlen vorhanden sind
else if (($zahl1 !== "" && $zahl2 !== "") && (isset($_POST["calc"]))) {
    $ergebnis = match ($operator) {
        "+" => $zahl1 + $zahl2,
        "-" => $zahl1 - $zahl2,
        "*" => $zahl1 * $zahl2,
        "/" => ($zahl2 != 0) ? $zahl1 / $zahl2 : "Fehler /0",
    };
    // Nur sinnvolle Ergebnisse in die History übernehmen
    if ($ergebnis !== "Fehler /0") {
        $_SESSION["ergebnisspeicher"][] = $ergebnis;
    }
}

// MEMORY ADD (M+) → Ergebnis wird gespeichert (nur wenn vorhanden!)
if (isset($_POST["btnMplus"]) && $ergebnis !== "" && $ergebnis !== "Fehler /0") {
    $_SESSION["speicher"] = $ergebnis;
}

// MEMORY READ (MR) → gespeicherten Wert in Zahl 1 einfügen und beide anderen Felder leeren
if (isset($_POST["btnMR"]) && $_SESSION["speicher"] !== null) {
    $zahl1 = $_SESSION["speicher"];
    $zahl2 = "";
    $ergebnis = "";
}

/*  RC: Ergebnisliste löschen  */
if (isset($_POST["btnRC"])) {
    $_SESSION["ergebnisspeicher"] = [""];
}


?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>PHP Taschenrechner Ausbaustufe 2</title>

    <style>
        body {
            font-family: Arial;
            text-align: center;
            margin-top: 40px;
        }

        .row {
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: center;
        }

        input,
        select {
            width: 80px;
            text-align: center;
            height: 25px;
        }

        #result {
            background: #d9d9d9;
            border: 1px solid #888;
            width: 120px;
            font-weight: bold;
        }

        .btnrow {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 12px;
        }
    </style>
</head>

<body>

    <h1>PHP Taschenrechner – Ausbaustufe 3</h1>

    <h2>Letzte Ergebnisse</h2>
    <select size="5" style="width: 280px; height: 100px;">
        <?php foreach ($_SESSION["ergebnisspeicher"] as $eintrag): ?>
            <option><?= htmlspecialchars($eintrag) ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <form method="post">

        <div class="row">
            <label>Zahl 1</label>
            <input type="number" name="zahl1" value="<?= $zahl1 ?>">

            <label>Operator</label>
            <select name="operator">
                <option value="+" <?= ($operator === "+") ? "selected" : "" ?>>+</option>
                <option value="-" <?= ($operator === "-") ? "selected" : "" ?>>-</option>
                <option value="*" <?= ($operator === "*") ? "selected" : "" ?>>*</option>
                <option value="/" <?= ($operator === "/") ? "selected" : "" ?>>/</option>
            </select>

            <label>Zahl 2</label>
            <input type="number" name="zahl2" value="<?= $zahl2 ?>">

            <label>Ergebnis</label>
            <input id="result" name="ergebnis" type="text" value="<?= $ergebnis ?>" readonly>

        </div>

        <div class="btnrow">
            <button type="submit" name="calc">=</button>
            <button type="submit" name="btnC">C</button>
            <button type="submit" name="btnMplus">M+</button>
            <button type="submit" name="btnMR">MR</button>
            <button type="submit" name="btnRC">RC</button>
        </div>

    </form>

    <p style="margin-top:25px;font-size:15px;">
        <b>Speicher:</b> <?= $_SESSION["speicher"] !== null ? $_SESSION["speicher"] : "leer" ?>
    </p>

</body>

</html>