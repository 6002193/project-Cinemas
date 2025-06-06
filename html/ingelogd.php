<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>

<?php
// Echo session variables that were set on previous page
echo $_SESSION["username"];
echo "Hallo " . $_SESSION["username"] . ".<br>";
echo "U bent nu ingelogd.";
?>

</body>
</html>