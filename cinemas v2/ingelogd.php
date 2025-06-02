<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>

<?php
// Echo session variables that were set on previous page
echo "Hallo " . $_SESSION["username"] . ".<br>";
echo "U bent nu ingelogd.";
?>

</body>
</html>