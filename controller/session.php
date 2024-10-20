<?php
$lifetime = 0; // Sesión expira al cerrar el navegador
session_set_cookie_params($lifetime);
session_start();