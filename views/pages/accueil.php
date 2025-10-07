<!-- Contenu de la page -->
<section id="Communaute">
    <h1> COMMU </h1>
    <p class="effectifTeamJul"> Effectif de la team Jul : </p>
    <p> Créer un compte pour faire augmenter le compteur !</p>
    <p class="compteur"> <?php echo $numberUser?> </p>
</section>
<section id="Description">
    <h1> DESCRIPTION </h1>
    <p> Bienvenue sur **Fan2Jul**, le site entièrement dédié à l’univers de **Jul**, l’artiste marseillais qui a marqué le rap français par son style unique et son énergie incomparable.
        Ici, tu pourras découvrir ses albums, suivre l’actualité de sa carrière, et rejoindre la communauté des fans qui partagent la même passion pour sa musique.

        Ce site a été réalisé dans le cadre d’un **projet étudiant à l’IUT d’Informatique d’Aix-en-Provence**.
        Notre objectif : créer une plateforme moderne, interactive et fidèle à l’esprit de Jul, tout en mettant en pratique nos compétences en développement web — du design de l’interface à la gestion de base de données.

        **Fan2Jul**, c’est avant tout un projet de passion et de technique : une vitrine de notre travail d’étudiants, mais aussi un espace convivial pour tous les fans du J.
    </p>
</section>
<section id="Albums">
  <h1>ALBUMS</h1>

  <div class="album-grid">
  <?php foreach ($pageAlbums as $album): ?>
    <figure>
      <a href="<?= htmlspecialchars($album['link']) ?>" target="_blank" rel="noopener">
        <img src="<?= htmlspecialchars($album['img']) ?>" alt="<?= htmlspecialchars($album['title']) ?>">
      </a>
      <figcaption><?= htmlspecialchars($album['title']) ?></figcaption>
    </figure>
  <?php endforeach; ?>
</div>


  <div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <a href="?page=home&p=<?= $i ?>#Albums" class="<?= $i == $page ? 'active' : '' ?>">
         <?= $i ?>
        </a>
    <?php endfor; ?>
  </div>
</section>
<section id="Actualite">
    <h1> ACTU </h1>
</section>


