<?php 
    require('inc/header.php');

    if(!empty($_POST))
    {
        $errors=array();

        if(empty($_POST['formPseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['formPseudo']))
        {
            $errors['formPseudo'] = "Votre Pseudo n'est pas valide.";
        }
        else
        {

        }

        if(empty($_POST['formMail']) || !filter_var($_POST['formMail'], FILTER_VALIDATE_EMAIL))
        {
            $errors['formMail'] = "Adresse e-mail invalide.";
            
        }
        if(empty($_POST['formPassword']) || $_POST['formPassword'] != $_POST['formPassword2'])
        {
            $errors['formPassword'] = "Vous devez rentrer un mot de passe valide";
        }
        debug($errors);
    }
    if(empty($errors))
    {
        require_once('inc/db.php');
        $req = $pdo -> prepare("INSERT INTO membre SET pseudo = ?, nom = ?, prenom = ?, email = ?, password = ?, ");
        $password = password_hash($_POST['formPassword'],PASSWORD_BCRYPT);
        $req-> execute($_POST['formPseudo'], $_POST['formNom'], $_POST['formPrenom'], $_POST['formMail'], $password);
            die("Notre compte a bien été créé");
    }

?>
<form action="" method="post">
    <label for="">Pseudo</label>
    <input type="text" name="formPseudo" required>
    <label for="">Nom</label>
    <input type="text" name="formNom" required>
    <label for="">Prénom</label>
    <input type="text" name="formPrenom" required >
    <label for="">E-mail</label>
    <input type="mail" name="formMail" required >
    <label for="">Mot de passe</label>
    <input type="password" name="formPassword" required>
    <label for="">Confirmez votre mot de passe</label>
    <input type="password" name="formPassword2" required>
    <button>S'inscrire</button>
</form>

<?php require("inc/footer.php")?>