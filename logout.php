<?php
    setcookie('Elogin', strtolower($user_login),time()-3600);
    header('Location: http://eve.kean.edu/~blondebr/CPS5740/index.html');
?>