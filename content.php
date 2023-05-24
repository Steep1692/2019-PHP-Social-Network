<?php
session_start();
include "connect.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>

  <?php
    include "head.php";
  ?>
  <title>Файлотека - corner.ua</title>

</head>
<body>

<?php
include "header.php";
?>

<div class="container">

  <p class='title'><img src='img/files.png' alt="Иконка"> Категории</p>

  <ul class="categories-ul">
  </ul>

  <?php
  include "footer.php";
  ?>

</div>
<script type="text/javascript">
  get_categories();
</script>
</body>
</html>
