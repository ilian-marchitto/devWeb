<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php
include '../classes/Menu.php';

$menu = new Menu();

echo $menu -> showMenu()


?>

<section id="Communaute">
<h1> COMMU </h1>
    <p> blablablabla </p>
</section>
<section id="Description">
    <h1> DES </h1>
    <p> blablablabla </p>
</section>
<section id="Albums">
    <h1> ALBUMS </h1>
    <section>
        <figure>
            <img src="images/photo1.jpg" alt="Photo 1">
            <figcaption>Photo 1 : description</figcaption>
        </figure>

        <figure>
            <img src="images/photo2.jpg" alt="Photo 2">
            <figcaption>Photo 2 : description</figcaption>
        </figure>

        <figure>
            <img src="images/photo3.jpg" alt="Photo 3">
            <figcaption>Photo 3 : description</figcaption>
        </figure>

        <figure>
            <img src="images/photo1.jpg" alt="Photo 4">
            <figcaption>Photo 4 : description</figcaption>
        </figure>

        <figure>
            <img src="images/photo2.jpg" alt="Photo 5">
            <figcaption>Photo 5 : description</figcaption>
        </figure>

        <figure>
            <img src="images/photo3.jpg" alt="Photo 6">
            <figcaption>Photo 6 : description</figcaption>
        </figure>
    </section>
</section>
<section id="Actualite">
    <h1> ACTU </h1>
</section>

<?php
include '../classes/Footer.php';
$footer = new Footer();
$footer -> render();?>

</body>

</html>