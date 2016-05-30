<? require 'header.php'; ?>

<div id="txt">
    Zoek in 20 koopwoningen
</div>


<div id="main">
    <ul>
        <li class="active">Zoeken</li>
    </ul>

    <form action="overzicht.php">
        <table id="zoeken">
            <tr>
                <td colspan="2"><label>Plaats of postcode <span class="light">- bijv. Tilburg</span></label></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" size="30"/></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="2"><label>Prijsklasse <span class="light">- van/tot</span></label></td>
                <td></td>
            </tr>

            <tr>
                <td><select>
                        <option value="-1">Geen minimum</option>
                        <?
                        for ($i = 25; $i < 1000; $i += 25) {
                            $bedrag = $i * 1000;
                            print "  <option value=\"$bedrag\">€ " . number_format($bedrag, 0, ',', '.') . "</option>\n";
                        }
                        ?>
                    </select></td>

                <td><select>
                        <option value="-1">Geen maximum</option>
                        <?
                        for ($i = 25; $i < 1000; $i += 25) {
                            $bedrag = $i * 1000;
                            print "  <option value=\"$bedrag\">€ " . number_format($bedrag, 0, ',', '.') . "</option>\n";
                        }
                        ?>
                    </select></td>

                <td><input type="submit" value="Zoeken"/></td>
            </tr>

            <tr>
                <td colspan="2"><a class="normal" href="specifiek.php">Specifiek adres</a></td>
                <td></td>
            </tr>
        </table>
    </form>
</div>


</body></html>
