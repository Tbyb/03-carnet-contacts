<?php
session_start();

if(isset($_POST['username']&& isset($_POST['password'])){
    if($_POST['username']==='admin' && $_POST['password']==="passer123"){
        $_session['logged_in'] = true;
        header('Location: index.php');
        exit();
    }else{
        $error = "Identifiants invalides";
    }
}
?>

<!DOCTYPE html>
<html lang = "fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <?php if (isset($error)){
        echo "<p style = 'color:red;'>$error</p>";
    }
    ?>
    <fieldset>
        <legend>Connexion</legend>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required> <br>
             <input type="password" name="password" placeholder="******" required> <br>
             <button type="submit">Se connecter</button>
        </form>
    </fieldset>
</body>

</html>