<?php
// Set strict types
declare(strict_types=1);

class album {
    /** @var int|null Het ID van de persoon */
    private ?int $id;

    /** @var string De voornaam van de persoon */
    private string $Naam;

    /** @var string De achternaam van de persoon */
    private string $Artiesten;

    /** @var string|null Het telefoonnummer van de persoon */
    private ?string $Release_datum;

    /** @var string|null Het e-mailadres van de persoon */
    private ?string $URL;

    /** @var string|null Eventuele opmerkingen over de persoon */
    private ?string $Afbeelding;
    private ?string $Prijs;

    /**
     * Constructor voor het maken van een Persoon object.
     *
     * @param int|null $id Het ID van de persoon.
     * @param string $Naam De voornaam van de persoon.
     * @param string $Artiesten De achternaam van de persoon.
     * @param string|null $Release_datum Het telefoonnummer van de persoon (optioneel).
     * @param string|null $URL Het e-mailadres van de persoon (optioneel).
     * @param string|null $Afbeelding Eventuele opmerkingen over de persoon (optioneel).
     * @param string|null $prijs Het e-mailadres van de persoon (optioneel).
     */
    public function __construct(?int $id, string $Naam, string $Artiesten, ?string $Release_datum,
                                ?string $URL, ?string $Afbeelding, ?string $prijs)

    {
        $this->id = $id;
        $this->Naam = $Naam;
        $this->Artiesten = $Artiesten;
        $this->Release_datum = $Release_datum;
        $this->URL = $URL;
        $this->Afbeelding = $Afbeelding;
        $this->Prijs = $prijs;
    }

    /**
     * Haalt alle personen op uit de database.
     *
     * @param PDO $db De PDO-databaseverbinding.
     * @return Persoon[] Een array van Persoon-objecten.
     */
    public static function getAll(PDO $db): array
    {
        // Voorbereiden van de query
        $stmt = $db->query("SELECT * FROM album");

        // Array om personen op te slaan
        $albums = [];

        // Itereren over de resultaten en personen toevoegen aan de array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $album = new album(
                $row['ID'],
                $row['Naam'],
                $row['Artiesten'],
                $row['Release_datum'],
                $row['URL'],
                $row['Afbeelding'],
                $row['Prijs']
            );
            $albums[] = $album;
        }

        // Retourneer array met personen
        return $albums;
    }

    /**
     * Zoek personen op basis van id.
     *
     * @param PDO $db De PDO-databaseverbinding.
     * @param int $id Het unieke ID van een persoon waarnaar we zoeken.
     * @return Persoon|null Het gevonden Persoon-object of null als er geen overeenkomstige persoon werd gevonden.
     * */
    public static function findById(PDO $db, int $id): ?album
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("SELECT * FROM album WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Retourneer een persoon als gevonden, anders null
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new album(
                $row['id'],
                $row['Naam'],
                $row['Artiesten'],
                $row['Release_datum'],
                $row['URL'],
                $row['Afbeelding'],
                $row['Prijs']
            );
        } else {
            return null;
        }
    }

    /**
     * Zoek personen op basis van achternaam.
     *
     * @param PDO $db De PDO-databaseverbinding.
     * @param string $Artiesten De achternaam om op te zoeken.
     * @return array Een array van Persoon objecten die aan de zoekcriteria voldoen.
     */
    public static function findByNaam(PDO $db, string $Naam): array
    {
        //Zet de achternaam eerst om naar lowercase letters
        $Naam = strtolower($Naam);

        // Voorbereiden van de query
        $stmt = $db->prepare("SELECT * FROM album WHERE LOWER(Naam) LIKE :Naam");

        // Voeg wildcard toe aan de achternaam
        $Naam = "%$Naam%";

        // Bind de achternaam aan de query en voer deze uit
        $stmt->bindParam(':Naam', $Naam);
        $stmt->execute();

        // Array om personen op te slaan
        $Artiesten = [];

        // Itereren over de resultaten en personen toevoegen aan de array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Artiesten[] = new artiest(
                $row['id'],
                $row['Naam'],
                $row['Artiesten'],
                $row['Release_datum'],
                $row['URL'],
                $row['Afbeelding'],
                $row['Prijs']
            );
        }

        // Retourneer array met personen
        return $Artiesten;
    }

    // Methode om een nieuwe persoon toe te voegen aan de database
    public function save(PDO $db): void
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("INSERT INTO album (Naam, Artiesten, Release_datum, URL, Afbeelding,Prijs) VALUES (:Naam, :Artiesten, :telefoonnummer, :Release_datum, :Afbeelding,:prijs)");
        $stmt->bindParam(':Naam', $this->Naam);
        $stmt->bindParam(':Artiesten', $this->Artiesten);
        $stmt->bindParam(':Release_datum', $this->Release_datum);
        $stmt->bindParam(':URL', $this->URL);
        $stmt->bindParam(':Afbeelding', $this->Afbeelding);
        $stmt->bindParam(':Prijs', $this->Prijs);
        $stmt->execute();
    }

    // Methode om een bestaande persoon bij te werken op basis van ID
    public function update(PDO $db): void
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("UPDATE album SET Naam = :Naam, Artiesten = :Artiesten, Release_datum = :Release_datum, URL = :URL, Afbeelding = :Afbeelding, Prijs = :Prijs WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':Naam', $this->Naam);
        $stmt->bindParam(':Artiesten', $this->Artiesten);
        $stmt->bindParam(':Release_datum', $this->Release_datum);
        $stmt->bindParam(':URL', $this->URL);
        $stmt->bindParam(':Afbeelding', $this->Afbeelding);
        $stmt->bindParam(':Prijs', $this->Prijs);
        $stmt->execute();
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): string
    {
        return $this->Naam;
    }

    public function getArtiesten(): string
    {
        return $this->Artiesten;
    }

    public function getRelease_datum(): ?string
    {
        return $this->Release_datum;
    }

    public function getURL(): ?string
    {
        return $this->URL;
    }
    public function getPrijs(): ?string
    {
        return $this->Prijs;
    }

    public function getAfbeelding(): ?string
    {
        return $this->Afbeelding;
    }

    // Setters
    public function setNaam(string $Naam): void
    {
        $this->voornaam = $Naam;
    }

    public function setArtiesten(string $Artiesten): void
    {
        $this->Artiesten = $Artiesten;
    }

    public function setRelease_datum(string $Release_datum): void
    {
        $this->Release_datum = $Release_datum;
    }

    public function setURL(string $URL): void
    {
        $this->URL = $URL;
    }

    public function setPrijs(string $Prijs): void
    {
        $this->Prijs = $Prijs;
    }
    public function setAfbeelding(string $Afbeelding): void
    {
        $this->Afbeelding = $Afbeelding;
    }
}
