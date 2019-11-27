<?php require('inc/header.php');?>


<?php
    //require 'recapcha.php';
    if(!empty($_POST))
    {
        $errors=array();
        var_dump($_POST);

        //$captcha = new Recaptcha('6Lek7cQUAAAAAHwEzQzyNceEhqcYE3tstdoAk3sF');
        //$captcha -> checkCode($_POST["g-recaptcha-response"]);

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

    if(!empty($errors))
    {
        require_once('inc/db.php');
        $req = $pdo -> prepare("INSERT INTO membre SET pseudo = ?, nom = ?, prenom = ?, email = ?, password = ?");
        $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
        $req -> execute($_POST['pseudo'], $_POST['nom'], $_POST['prenom'], $_POST['Mail'], $password);
            echo "Votre compte a bien été créé";
    }
    

?>
    <form action="" method="post">
        <section>
            <label for="">Pseudo</label>
            <input type="text" name="pseudo">
            <label for="">Nom</label>
            <input type="text" name="nom">
            <label for="">Prénom</label>
            <input type="text" name="prenom" >
            <label for="">E-mail</label>
            <input type="mail" name="mail" >
            <label for="">Mot de passe</label>
            <input type="password" name="password">
            <label for="">Confirmez votre mot de passe</label>
            <input type="password" name="password2">
        </section>
        <section class="g-recaptcha" data-sitekey="6Lek7cQUAAAAAEtDj_SwR089NnZPVPZta9W9W-QD"></section>
        <button>S'inscrire</button>
    </form>

<?php require("inc/footer.php")?>