<!-- Contenu de la page -->
<section id="Communaute">
    <h1> COMMU </h1>
    <p> blablablabla </p>
</section>
<section id="Description">
    <h1> DES </h1>
    <p> blablablabla </p>
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


