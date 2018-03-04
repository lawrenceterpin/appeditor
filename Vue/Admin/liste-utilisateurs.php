<?php 
foreach ($utilisateurs as $utilisateur):
?>
  <article>
      <header>
          <a href="">
              <h1 class="titreBillet"><?= $this->nettoyer($utilisateur['login']) ?></h1>
          </a>
      </header>
  </article>
  <hr />
<?php endforeach; ?>