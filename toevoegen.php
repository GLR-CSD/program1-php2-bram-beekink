<?php
// Start de sessie
session_start();

// Controleer of het verzoek via POST is gedaan
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Valideer de ingediende gegevens
    $errors = [];
    $formValues = [
        'Naam' => $_POST['Naam'] ?? '',
        'Artiesten' => $_POST['Artiesten'] ?? '',
        'Release_datum' => $_POST['Release_datum'] ?? '',
        'URL' => $_POST['URL'] ?? '',
        'Afbeelding' => $_POST['Afbeelding'] ?? '',
        'Prijs' => $_POST['Prijs'] ?? '',
    ];

    // Valideer Naam
    if (empty($_POST['Naam'])) {
        $errors['Naam'] = "Naam is verplicht.";
    }

    // Valideer Artiesten
    if (empty($_POST['Artiesten'])) {
        $errors['Artiesten'] = "Artiesten is verplicht.";
    }

    // Als er geen validatiefouten zijn, voeg het album toe aan de database
    if (empty($errors)) {
        require_once 'db.php';
        require_once 'classes/album.php';

        // Maak een nieuw album object met de ingediende gegevens
        $album = new album(
            null,
            $_POST['Naam'],
            $_POST['Artiesten'],
            $_POST['Release_datum'],
            $_POST['URL'],
            $_POST['Afbeelding'],
            $_POST['Prijs']
        );

        // Voeg het album toe aan de database
        $album->save($db);

    } else {
        // Sla de fouten en formulier waarden op in sessievariabelen
        $_SESSION['errors'] = $errors;
        $_SESSION['formValues'] = $formValues;
    }

    // Stuur de gebruiker terug naar de index.php
    header("Location: index.php");
    exit;

} else {
    header("Location: index.php");
}
