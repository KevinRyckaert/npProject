<?php 
    require("inc/header.php"); 
    require("inc/db.php");
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
        $req = $pdo -> prepare ("INSERT INTO membre SET pseudo = ? , nom = ?, prenom = ?, email = ?, password = ?");
        $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
        $req -> execute([$_POST['pseudo'], $_POST['nom'], $_POST['prenom'], $_POST['mail'], $password]);
        }  
    }   
?>
    <h1>S'inscrire</h1>
<?php 
    if(!empty($errors)): 
?>
    <section class="alert alert-danger">
        <p>Vous n'avez pas remplis le formulaire correctement</p>
        <ul>
<?php 
    foreach($errors as $errors):
?>
    <li> <?=$errors;?> </li>
<?php 
    endforeach;
?>
    </ul>
    </section>
<?php 
    endif; 
?>
    <form action="" method="POST">
        <section>
            <label for="">Pseudo</label>
            <input type="text" name="pseudo" required>
            <label for="">Nom</label>
            <input type="text" name="nom" required>
            <label for="">Prénom</label>
            <input type="text" name="prenom" required>
            <label for="">E-mail</label>
            <input type="mail" name="mail" required>
            <label for="">Mot de passe</label>
            <input type="password" name="password" required>
            <label for="">Confirmez votre mot de passe</label>
            <input type="password" name="password2" required>
            <button>S'inscrire</button>
    </form>
<?php 
    require("inc/footer.php");
?>