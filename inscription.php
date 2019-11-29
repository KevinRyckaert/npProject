<?php
require_once("inc/function.php");
require_once("inc/db.php");
    if(!empty($_POST)){
        $errors=array();
        if(empty($_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['pseudo'])){
            $errors['pseudo'] = "Votre Pseudo n'est pas valide.";
        }else{
            $req = $pdo -> prepare('SELECT id FROM membre WHERE pseudo = ?');
            $req -> execute ([$_POST["pseudo"]]);
            $pseudo = $req -> fetch();
        }
            if($pseudo){
                $errors["pseudo"] = "Ce pseudo est déjà pris ";
        }
        if(empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
            $errors['mail'] = "Adresse e-mail invalide.";            
        }else{
            $req = $pdo -> prepare('SELECT id FROM membre WHERE email= ?');
            $req -> execute ([$_POST["mail"]]);
            $pseudo = $req -> fetch();
        }
            if($pseudo){
                $errors["mail"] = "Ce mail est déjà pris";
        }
        if(empty($_POST['password']) || $_POST['password'] != $_POST['password2']){
            $errors['password'] = "Vous devez rentrer un mot de passe valide";
        }
        if(empty($errors)){        
        $req = $pdo -> prepare ("INSERT INTO membre SET pseudo = ? , nom = ?, prenom = ?, email = ?, password = ?, confirmation_token = ?");
        $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
        $token = str_random(60);
        $req -> execute([$_POST['pseudo'], $_POST['nom'], $_POST['prenom'], $_POST['mail'], $password, $token]);
        $user_id = $pdo -> lastInsertId();
        mail($_POST["mail"], "Confirmation de votre compte","cliquez sur le lien\n\n http://localhost/php/npProject/confirme.php?id=$user_id&$token=$token");
        header("Location: connexion.php");
        exit();
    }  
    }   
?>
<?php require("inc/header.php"); ?>
    <h1>S'inscrire</h1>
    <hr>
<?php if(!empty($errors)): ?>
    <section class="alert alert-danger rounded border border-danger ">
        <p>Vous n'avez pas remplis le formulaire correctement</p>
        <ul>
<?php foreach($errors as $errors):?>
            <li> <?=$errors;?> </li>
<?php endforeach;?>
        </ul>
    </section>
<?php endif; ?>
    <form action="" method="POST">
            <label for="">Pseudo : </label>
            <input type="text" name="pseudo" required>
            <label for="">Nom : </label>
            <input type="text" name="nom" required>
            <label for="">Prénom : </label>
            <input type="text" name="prenom" required>
            <label for="">E-mail : </label>
            <input type="mail" name="mail" required>
            <label for="">Mot de passe : </label>
            <input type="password" name="password" required>
            <label for="">Confirmez votre mot de passe : </label>
            <input type="password" name="password2" required><br>
            <input type="submit" class="btn btn-success rounded-pill border border-success">
    </form>
<?php 
    require("inc/footer.php");
?>