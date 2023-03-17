<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php
// AGREGANDO ALERTAS 
include_once __DIR__ . "/../templates/alertas.php";

?>

<!-- FORMULARIO DE LOGIN -->
<form class="formulario" method="post" action="/">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu Email">
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Tu Contraseña">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">


</form>
<!-- FIN FORMULARIO DE LOGIN -->

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crea Una </a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>