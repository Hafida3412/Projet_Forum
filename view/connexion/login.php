<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <h1>Se connecter</h1>
        <form action="index.php?ctrl=security&action=login"method="post"><!--STRUCTURE DE L'URL POUR DECLENCHER UNE ACTION: INDEX.PHP?CTRL ACTION= METHOD= ID= -->
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="micka@exemple.com"><br>

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" value="aaaaa"><br>

            <input type="submit" name="submitLogin" value="Se connecter">
        </form>
    </body>
    </html>