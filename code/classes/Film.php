<?php
require_once 'Database.php';

class Film extends Database {
    private int $id;
    private string $naam;
    private int $rating;
    private ?int $room;
    private int $seats;
    private ?string $fotoUrl;

    public function __construct(
        int $id,
        string $naam,
        int $rating,
        ?int $room,
        int $seats,
        ?string $fotoUrl
    ) {
        $this->id = $id;
        $this->naam = $naam;
        $this->rating = $rating;
        $this->room = $room;
        $this->seats = $seats;
        $this->fotoUrl = $fotoUrl;
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getNaam(): string { return $this->naam; }
    public function getRating(): int { return $this->rating; }
    public function getRoom(): ?int { return $this->room; }
    public function getSeats(): int { return $this->seats; }
    public function getFotoUrl(): ?string { return $this->fotoUrl; }

    // Setters (optioneel, afhankelijk van je use-case)
    public function setRoom(?int $room): void { $this->room = $room; }
    public function setSeats(int $seats): void { $this->seats = $seats; }

    // Static factory voor DB-records
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['naam'],
            $data['rating'],
            $data['room'] ?? null,
            $data['seats'],
            $data['foto_url'] ?? null
        );
    }
}

class FilmRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /** @return Film[] */
    public function getAll(): array
    {
        $result = $this->conn->query("SELECT * FROM movies");
        $films = [];
        while ($row = $result->fetch_assoc()) {
            $films[] = Film::fromArray($row);
        }
        return $films;
    }

    public function add(string $naam, int $rating, ?int $room, int $seats, ?string $fotoUrl): bool
    {
        $stmt = $room === null
            ? $this->conn->prepare("INSERT INTO movies (naam, rating, room, seats, foto_url) VALUES (?, ?, NULL, ?, ?)")
            : $this->conn->prepare("INSERT INTO movies (naam, rating, room, seats, foto_url) VALUES (?, ?, ?, ?, ?)");
        if ($room === null) {
            $stmt->bind_param("siis", $naam, $rating, $seats, $fotoUrl);
        } else {
            $stmt->bind_param("siiis", $naam, $rating, $room, $seats, $fotoUrl);
        }
        return $stmt->execute();
    }

    public function deleteByName(string $naam): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM movies WHERE naam = ?");
        $stmt->bind_param("s", $naam);
        return $stmt->execute();
    }
}