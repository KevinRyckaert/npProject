<?php require('inc/header.php');?>


<?php
    if(!empty($_POST))
    {
        $errors=array();

        if(empty($_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['pseudo']))
        {
            $errors['pseudo'] = "Votre Pseudo n'est pas valide.";
        }
        if(empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
        {
            $errors['mail'] = "Adresse e-mail invalide.";
            
        }
        if(empty($_POST['password']) || $_POST['password'] != $_POST['password2'])
        {
            $errors['password'] = "Vous devez rentrer un mot de passe valide";
        }
        debug($errors);
    }

    if(empty($errors))
    {
        require_once('inc/db.php');
        $req = $pdo -> prepare("INSERT INTO membre SET pseudo = ?, nom = ?, prenom = ?, email = ?, password = ?");
        $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
        $req -> execute($_POST['pseudo'], $_POST['nom'], $_POST['prenom'], $_POST['Mail'], $password);
            echo "Notre compte a bien été créé";
    }
    

?>
<form action="" method="post">
    <label for="">Pseudo</label>
    <input type="text" name="pseudo" required>
    <label for="">Nom</label>
    <input type="text" name="nom" required>
    <label for="">Prénom</label>
    <input type="text" name="prenom" required >
    <label for="">E-mail</label>
    <input type="mail" name="mail" required >
    <label for="">Mot de passe</label>
    <input type="password" name="password" required>
    <label for="">Confirmez votre mot de passe</label>
    <input type="password" name="password2" required>
    <button>S'inscrire</button>
</form>

<?php require("inc/footer.php")?>