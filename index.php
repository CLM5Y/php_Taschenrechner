<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Taschenrechner</title>

<style>
    body{
        font-family: Arial;
        text-align:center;
        margin-top: 50px;
    }

    .row {
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    input {
        width: 80px;
        height: 25px;
        text-align: center;
    }

    #result {
        background: #dedede;
        border: 1px solid gray;
        width: 120px;
        height: 25px;
    }

    button {
        margin-top: 20px;
        padding: 5px 15px;
    }
</style>
</head>
<body>

<h1>Taschenrechner</h1>

<form method="post">

<div class="row">
    <label>Zahl 1</label>
    <input type="number" name="zahl1" required>

    <label>Operator</label>
    <select name="operator">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
    </select>

    <label>Zahl 2 </label>
    <input type="number" name="zahl2" required>

    <label>Ergebnis</label>

    <!-- 
    1. Formular wird abgeschickt (POST)
    2. PHP prüft: if(isset($_POST['calc']))
    3. Falls gerechnet wurde → PHP berechnet $res
    4. Das Ergebnis wird in das value="" geschrieben → erscheint im Feld -->

    <input id="result" type="text" value="<?php
        if(isset($_POST['calc'])){
            $a=$_POST['zahl1']; $b=$_POST['zahl2']; $op=$_POST['operator'];
            $ergebnis = match($op){
                "+" => $a+$b,
                "-" => $a-$b,
                "*" => $a*$b,
                "/" => ($b!=0)?$a/$b:"Fehler /0",
            };
            echo $ergebnis;
        }
    ?>" disabled>
</div>

<button name="calc">Berechnen</button>

</form>
</body>
</html>
