<?php 
$this->titre = "Mon Blog - " . $this->nettoyer($billet['titre']); 

$this->login_actif = $login_actif["login"];
?>

<div class="container">
    <div class="row">

        <article>
            <header>
                <h1 class="titreBillet"><?= $this->nettoyer($billet['titre']) ?></h1>
                <time><?= $this->nettoyer($billet['date']) ?></time>
            </header>
            <p><?= htmlspecialchars_decode($billet['contenu']) ?></p>
        </article>
        <hr />
        <header>
            <h1 id="titreReponses">Réponses à <?= $this->nettoyer($billet['titre']) ?></h1>
        </header>
        <?php foreach ($commentaires as $commentaire): ?>
            <p><?= $this->nettoyer($commentaire['auteur']) ?> dit :</p>
            <p><?= $this->nettoyer($commentaire['contenu']) ?></p>
        <?php endforeach; ?>
        <hr />
        <form method="post" action="billet/commenter">
            <input id="auteur" name="auteur" type="hidden" placeholder="Votre pseudo" 
                   required value="<?php echo $login; ?>"/><br />
            <textarea id="txtCommentaire" class="form-control" name="contenu" rows="4" 
                      placeholder="Votre commentaire" required></textarea><br />
            <input type="hidden" name="id" value="<?= $billet['id'] ?>" />
            <input type="submit" value="Commenter" class="btn btn-primary" />
        </form>

    </div>
</div>
