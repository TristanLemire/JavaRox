<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();
require './elements/header.php';
?>
<?php
$topic = Entity\Bdd::getOneTopic($_GET['idTopic']);
$post = Entity\Bdd::getOnePost($_GET['idTopic']);
$createur = Entity\Bdd::getUserById($topic->idUser());
$comments = Entity\Bdd::getAllComments($post->id());
?>

<p>Publier par <?php echo $createur->pseudo() ?> le <?php echo $post->date() ?></p>
<?php
if (isset($_GET['message'])) {
  ?>
  <p><?php echo $_GET['message']; ?></p>
<?php
}
?>
<form action="aimerAction.php" method="POST">
  <input type="submit" value="J'aime" name="aimer">
  <input type="hidden" name="idPost" value="<?php echo $post->id() ?>">
  <input type="hidden" name="idTopic" value="<?php echo $_GET['idTopic'] ?>">
</form>
<div>
  <h2><?php
      echo $topic->title() ?></h2>
  <p><?php echo $post->content(); ?></p>
</div>

<form action="createComment.php" method="POST">
  <textarea name="content" id="content" cols="30" rows="10" placeholder="contenu du commentaires"></textarea>
  <input type="hidden" name="idPost" value="<?php echo $post->id() ?>">
  <input type="hidden" name="idTopic" value="<?php echo $_GET['idTopic'] ?>">
  <input type="submit" name="Publier" value="Publier">
</form>

<?php
foreach ($comments as $comment) {
  $user = Entity\Bdd::getUserById($comment->idUser());
  ?>
  <div>
    <h2><?php echo $user->pseudo(); ?> le <?php echo $comment->date() ?></h2>
    <P><?php echo $comment->content(); ?></p>
    <?php
    if (isset($_GET['message' . $comment->id()])) {
      ?>
      <p><?php echo $_GET['message' . $comment->id()]; ?></p>
    <?php
  }
  ?>
    <form action="likerAction.php" method="POST">
      <input type="submit" value="J'aime" name="aimer">
      <input type="hidden" name="idComment" value="<?php echo $comment->id() ?>">
      <input type="hidden" name="idTopic" value="<?php echo $_GET['idTopic'] ?>">
    </form>
    <?php
    if (isset($_GET['nbLike' . $comment->id()])) {
      ?>
      <p><?php echo $_GET['nbLike' . $comment->id()] ?></p>
    <?php
  }
  ?>
  </div>
<?php
}
?>