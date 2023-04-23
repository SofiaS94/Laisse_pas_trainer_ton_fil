<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Je vérifie si le formulaire est soumis comme d'habitude

   // Securité en php
    // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés (attention ce dossier doit être accessible en écriture)
    $uploadDir = "uploads/"; 
  // Le poids max géré par PHP par défaut est de 2M
    $maxSizeFile = 1000000;
   
      // Je récupère l'extension du fichier
    $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
   // Les extensions autorisées
    $authorizedExtension = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    // création du nom unique pour l'image upload
    $newFileName = uniqid(basename($_FILES['avatar']['name']), $fileExtension);

 // Je sécurise et effectue mes tests

    /****** Si l'extension est autorisée *************/
    if (!in_array($fileExtension, $authorizedExtension)) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
    }

       /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxSizeFile) {
        $errors[] = "Votre fichier doit faire moins de 1Mo !";
    }

    // Sanitization des autres champs du formulaire
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);

    // Validation des champs obligatoires
    if (empty($firstname)) {
        $errors[] = 'Please enter a firstname';
    }

    if (empty($lastname)) {
        $errors[] = 'Please enter a lastname';
    }

    if (empty($age)) {
        $errors[] = 'Please enter your age';
    }
}

// var_dump($errors);
// ?>

<?php
// Affichage des erreurs sous forme d'une liste HTML si il y a des erreurs
if (!empty($errors)) { ?>
<ul>
    <?php foreach ($errors as $error) { ?>
    <li><?= $error ?></li>
    <?php } ?>
</ul>
<?php
}

// ****** Si je n'ai pas d"erreur alors j'upload ************
   

if (isset($filePath)) { ?>
<p> Bonjour <?= $firstname . ' ' . $lastname . ', ' ?>bienvenue sur SpringfieldWild! <br> <br> Vous avez
    <?= $age . 'ans' ?>.<br>
    Ceci est votre avatar : <br> <img src=" <?= $filePath ?> " alt="votre avatar" />.
<p> LICENSE #64209 BIRTH DATE 4-24-56 EXPIRES 4-24-2015 CLASS NONE

    DRIVERS LICENCE

    HOMER SIMPSON
    69 OLD PLUMTREE BLVD
    SPRINGFIELD, IL 62701

    SEX : OK HEIGHT : MEDIUM WEIGHT : 239 HAIR: NONE EYES: OVAL

    X HOMER SIMPSON
    SIGNATURE </p>

<?php
}
?>


<?php // formulaire ?>

<form method="post" enctype="multipart/form-data">
    <label for="firstname"> Votre prénom</label>
    <input type="text" name="firstname" />
    <label for="lastname"> Votre nom</label>
    <input type="text" name="lastname" />
    <label for="age"> Votre age</label>
    <input type="int" name="age" />
    <label for="imageUpload">Votre avatar</label>
    <input type="file" name="avatar" id="imageUpload" />
    <button name="send">Send</button>
</form>