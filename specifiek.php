<? require 'header.php'; ?>

<?php
if (!empty($_POST)) {
    include_once 'overzicht.php';
    die();
} else {
    session_start();
    $_SESSION['SortingVals'] = [];
    session_destroy();
}
?>

<div id="specifiek" style="width: 300px; margin-left: 30px;">
    <form method="post">
        <fieldset>
            Soort woning:
            <input type="radio" name="woning" value="bestaand" id="bestaand"/>
            <label for="bestaand">Bestaande bouw</label>
            <input type="radio" name="woning" value="nieuwbouw" id="nieuwbouw"/>
            <label for="nieuwbouw">Nieuwbouw</label>
            <br/>

            Vul (een deel van) het adres in dat u zoekt.<br/>

            <table>
                <tr>
                    <td><label for="straatnaam">Straatnaam</label></td>
                    <td><input type="text" name="straatnaam" size="50" id="straatnaam"/></td>
                </tr>
                <tr>
                    <td><label for="huisnummer">Huisnummer</label></td>
                    <td>
                        <input type="text" name="huisnummer" size="7" id="huisnummer"/>
                        <label for="toevoeging"> Toevoeging </label>
                        <input type="text" name="toevoeging" size="3" id="toevoeging"/>
                    </td>
                </tr>
                <tr>
                    <td><label for="pc">Postcode</label></td>
                    <td><input type="text" name="postcode" size="7" id="pc"/></td>
                </tr>
                <tr>
                    <td><label for="plaatsnaam">Plaatsnaam</label></td>
                    <td><input type="text" name="plaatsnaam" size="50" id="plaatsnaam"/></td>
                </tr>
            </table>

            <input type="submit" value="Zoek koopaanbod"/>
        </fieldset>
    </form>
</div>

</body></html>