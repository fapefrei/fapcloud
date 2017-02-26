<!-- Search -->
<form id="search" method="post" action="../search/result.php" novalidate>
    <input id="live-input" autocomplete="off" class="search-bar" type="text" name="text" value="<?php if(isset($_POST["text"])){echo $_POST["text"];}elseif(isset($_GET["text"])){echo $_GET["text"]; } ?>" placeholder="Recherchez des matières">
    <i id="search-delete" class="material-icons">close</i>
    <div id="live-result"><ul></ul></div>
</form>