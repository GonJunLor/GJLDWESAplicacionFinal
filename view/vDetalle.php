<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 17/12/2025
*/

?>
<form action="" method="post">
    <button name="cerrarSesion" class="boton">
        <span>Cerrar Sesión</span>
    </button>
</form>
</nav>
<main>
<form action="" method="post">
    <button name="volver" class="boton"><span>Volver</span></button>
</form>
<div class="detalle">
    <?php
    //Contenido de la variable $_SESSION-------------------------------------------------------
    echo '<br><br><h3>Contenido de la variable $_SESSION</h3><br>';
    echo '<table >';
    echo '<tr><th>Variable</th><th>Valor</th></tr>';
    if (!empty($_SESSION)) {
        foreach ($_SESSION as $variable => $resultado) {
            echo "<tr>";
            echo '<td>$_SESSION[' . $variable . ']</td>';
            echo "<td><pre>" . print_r($resultado, true) . "</pre></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'><em>La variable \$_SESSION está vacía.</em></td></tr>";
    }
    echo "</table>";

    //Contenido de la variable $_COOKIE---------------------------------------------------
    echo '<br><br><h3>Contenido de la variable $_COOKIE</h3><br>';
    echo '<table >';
    echo '<tr><th>Variable</th><th>Valor</th></tr>';
    if (!empty($_COOKIE)) {
        foreach ($_COOKIE as $variable => $resultado) {
            echo "<tr>";
            echo '<td>$_COOKIE[' . $variable . ']</td>';
            echo "<td><pre>" . $resultado . "</pre></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'><em>La variable \$_COOKIE está vacía.</em></td></tr>";
    }
    echo "</table>";


    //Contenido de la variable $_SERVER-----------------------------------------------
    echo '<h3>Contenido de la variable $_SERVER</h3>';
    echo '<table >';
    echo '<tr><th>Variable</th><th>Valor</th></tr>';
    if (!empty($_SERVER)) {
        foreach ($_SERVER as $variable => $resultado) {
            echo "<tr>";
            echo '<td>$_SERVER[' . $variable . ']</td>';
            echo "<td><pre>" . print_r($resultado, true) . "</pre></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'><em>La variable \$_SERVER está vacía.</em></td></tr>";
    }
    echo "</table>";

    //Contenido de la variable $_ENV -----------------------------------------------
    echo '<h3>Contenido de la variable $_ENV</h3>';
    echo '<table >';
    echo '<tr><th>Variable</th><th>Valor</th></tr>';
    if (!empty($_ENV)) {
        foreach ($_ENV as $variable => $resultado) {
            echo "<tr>";
            echo '<td>$_SERVER[' . $variable . ']</td>';
            echo "<td><pre>" . print_r($resultado, true) . "</pre></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'><em>La variable \$_ENV está vacía.</em></td></tr>";
    }
    echo "</table>";

    //Contenido de la variable $_REQUEST -----------------------------------------------
    echo '<h3>Contenido de la variable $_REQUEST</h3>';
    echo '<table >';
    echo '<tr><th>Variable</th><th>Valor</th></tr>';
    if (!empty($_REQUEST)) {
        foreach ($_REQUEST as $variable => $resultado) {
            echo "<tr>";
            echo '<td>$_SERVER[' . $variable . ']</td>';
            echo "<td><pre>" . print_r($resultado, true) . "</pre></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'><em>La variable \$_REQUEST está vacía.</em></td></tr>";
    }
    echo "</table>";

    //Contenido de la variable $_GET -----------------------------------------------
    echo '<h3>Contenido de la variable $_GET</h3>';
    echo '<table >';
    echo '<tr><th>Variable</th><th>Valor</th></tr>';
    if (!empty($_GET)) {
        foreach ($_GET as $variable => $resultado) {
            echo "<tr>";
            echo '<td>$_SERVER[' . $variable . ']</td>';
            echo "<td><pre>" . print_r($resultado, true) . "</pre></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'><em>La variable \$_GET está vacía.</em></td></tr>";
    }
    echo "</table>";

    //Contenido de la variable $_POST -----------------------------------------------
    echo '<h3>Contenido de la variable $_POST</h3>';
    echo '<table >';
    echo '<tr><th>Variable</th><th>Valor</th></tr>';
    if (!empty($_POST)) {
        foreach ($_POST as $variable => $resultado) {
            echo "<tr>";
            echo '<td>$_SERVER[' . $variable . ']</td>';
            echo "<td><pre>" . print_r($resultado, true) . "</pre></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'><em>La variable \$_POST está vacía.</em></td></tr>";
    }
    echo "</table>";

    //Contenido de la variable $_FILES -----------------------------------------------
    echo '<h3>Contenido de la variable $_FILES</h3>';
    echo '<table >';
    echo '<tr><th>Variable</th><th>Valor</th></tr>';
    if (!empty($_FILES)) {
        foreach ($_FILES as $variable => $resultado) {
            echo "<tr>";
            echo '<td>$_SERVER[' . $variable . ']</td>';
            echo "<td><pre>" . print_r($resultado, true) . "</pre></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'><em>La variable \$_FILES está vacía.</em></td></tr>";
    }
    echo "</table>";

            echo '<div id="phpinfo">'; // Contenedor para phpinfo()
    phpinfo();
    echo '</div>';
    ?>
</div>
