<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=League+Script&display=swap" rel="stylesheet">
</head>

<?php
require './bootstrap.php';
require './elements/header.php';
?>

<main>
    <h1>Acceuil</h1>

    <?php $allTopics = Entity\Bdd::getAllTopics();
    if (isset($_GET['message'])) {
        ?>
        <p><?php echo $_GET['message']; ?></p>
    <?php
    }
    foreach ($allTopics as $Topics) {

        ?>
        <div>
            <a href="./topic.php?idTopic=<?php echo $Topics->id(); ?>">
                <h2><?php echo $Topics->title(); ?></h2>
                <p><?php
                    $user = Entity\Bdd::getUserById($Topics->idUser());
                    echo 'Poster par ' . $user->pseudo();
                    ?></p>
            </a>
            <?php
            if ($_SESSION['user']->id() == $Topics->idUser() or $_SESSION['user']->pseudo() == "admin") {
                ?>
                <form action="deleteTopics.php" method="POST">
                    <input type="submit" value="Supprimer" name="Supprimer">
                    <input type="hidden" name="idTopic" value="<?php echo $Topics->id() ?>">
                </form>
            <?php
        }
        ?>
        </div>
    <?php
    }
    ?>
</main>
<?php require './elements/footer.php' ?>