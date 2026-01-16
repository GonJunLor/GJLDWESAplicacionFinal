<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 15/12/2025
*/

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="webroot/media/images/logo.png">
    <link rel="stylesheet" href="webroot/css/fonts.css">
    <link rel="stylesheet" href="webroot/css/estilos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" type="text/css" rel="stylesheet">
    <title>Gonzalo Junquera Lorenzo</title>
</head>
<body>
    <div id="aviso">Login Logoff</div>
    <nav class="<?php echo $estadoBarraNavegacion ?>">
        <form action="" method="post">
            <button name="inicio" class="botonLogo">
                <img src="webroot/media/images/logo.png" alt="logo">
            </button>
        </form>
        <a href="./indexLoginLogoff.php"></a>
        <h2><?php echo $titulo[$_SESSION['paginaEnCurso']]; ?></h2>
        <form action="" method="post">
            <button type="submit" name="idioma" value="ES" id="ES" 
            style="background-color:<?php echo $_COOKIE["idioma"]=="ES"? '#c2bcb9' : 'white';?>">
                <img src="webroot/media/images/banderaEs.png" alt="es">
            </button>
            <button type="submit" name="idioma" value="EN" id="EN"
            style="background-color:<?php echo $_COOKIE["idioma"]=="EN"? '#c2bcb9' : 'white';?>">
                <img src="webroot/media/images/banderaGb.png" alt="en">
            </button>
            <button type="submit" name="idioma" value="FR" id="FR"
            style="background-color:<?php echo $_COOKIE["idioma"]=="FR"? '#c2bcb9' : 'white';?>">
                <img src="webroot/media/images/banderaFr.png" alt="fr">
            </button>
        </form>
        
    <?php require_once $view[$_SESSION['paginaEnCurso']]; ?>
    </main>
    <footer id="pie">
        <div>
            <a href="https://github.com/GonJunLor/GJLDWESLoginLogoff.git" target="_blank">
                <i class="fa-brands fa-github"></i>
            </a>
        </div>
        2025-26 IES LOS SAUCES. &#169;Todos los derechos reservados. 
        <div>
            <a href="https://gonzalojunlor.ieslossauces.es/" target="_blank">
            <address style="display: inline;">Gonzalo Junquera Lorenzo</address>
            </a>
            <time datetime="2025-12-15">15-12-2025.</time>
            <a href="https://mogutable.com/" id="webImitada" target="_blank">Web imitada</a>
        </div>
    </footer>
</body>
</html>