

<form action="back.php?action=calendar" method="post">
    <select name="months" id="months">
        <?php
        foreach ($allMonths as $key => $value) {
            echo "<option value='$key'>$value</option>";
        }
        ?>
    </select>
    <select name="years" id="years">
        <?php
        foreach ($allYears as $value) {
            echo "<option value='$value'>$value</option>";
        }
        ?>
        </select>

    <input type="submit" value="Valider">
</form>



