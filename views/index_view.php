<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albumlijst</title>
    <link rel="stylesheet" href="public/css/simple.css">
</head>
<body>
<h1>Albumlijst</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Albumnaam</th>
        <th>Artiest</th>
        <th>Release datum</th>
        <th>Link</th>
        <th>Prijs</th>
        <th>Albumcover</th>
    </tr>
    <?php foreach ($albums as $album): ?>
        <tr>
            <td><?= $album->getId() ?></td>
            <td><?= $album->getNaam() ?></td>
            <td><?= $album->getArtiesten() ?></td>
            <td><?= $album->getRelease_datum() ?></td>
            <td><a href="<?= $album->getURL() ?>"><?= $album->getURL() ?></a></td>
            <td><?= $album->getPrijs() ?></td>
            <td><img src="<?= $album->getAfbeelding() ?>" alt="" height="60px"></td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="notice">
    <h2>Album Toevoegen:</h2>
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="toevoegen.php" method="post">
        <label for="Naam">Albumnaam:</label>
        <input type="text" id="Naam" name="Naam" value="<?= $formValues['Naam'] ?? '' ?>" required>
        <?php if (isset($errors['Naam'])): ?>
            <span style="color: red;"><?= $errors['Naam'] ?></span>
        <?php endif; ?><br>

        <label for="Artiesten">Artiest:</label>
        <input type="text" id="Artiesten" name="Artiesten" value="<?= $formValues['Artiesten'] ?? '' ?>" required>
        <?php if (isset($errors['Artiesten'])): ?>
            <span style="color: red;"><?= $errors['Artiesten'] ?></span>
        <?php endif; ?><br>

        <label for="Release_datum">Release datum:</label>
        <input type="date" id="Release_datum" name="Release_datum" value="<?= $formValues['Release_datum'] ?? '' ?>"><br>

        <label for="URL">Link:</label>
        <input type="url" id="URL" name="URL" value="<?= $formValues['URL'] ?? '' ?>"><br>

        <label for="Afbeelding">Afbeelding:</label>
        <input type="text" id="Afbeelding" name="Afbeelding" value="<?= $formValues['Afbeelding'] ?? '' ?>"><br>

        <label for="Prijs">Prijs:</label>
        <input type="text" id="Prijs" name="Prijs" value="<?= $formValues['Prijs'] ?? '' ?>"><br>

        <input type="submit" value="Toevoegen">
    </form>
</div>

</body>
</html>
