<?php
session_start();
session_destroy();

echo 'Cargando...';
echo '<script> window.location="../index.php"; </script>';
?>