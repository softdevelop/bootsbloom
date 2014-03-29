<?php
if ($cities) {
    foreach ($cities as $id => $city) {
        ?>
        <option value="<?php echo $id; ?>"><?php echo $city; ?></option>
        <?php
    }
}
?>