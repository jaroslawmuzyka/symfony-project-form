<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\DeveloperRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
class Developer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ide = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $programmingLanguages = null;

    #[ORM\Column(nullable: true)]
    private ?bool $mysql = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIde(): ?string
    {
        return $this->ide;
    }

    public function setIde(?string $ide): static
    {
        $this->ide = $ide;

        return $this;
    }

    public function getProgrammingLanguages(): ?string
    {
        return $this->programmingLanguages;
    }

    public function setProgrammingLanguages(?string $programmingLanguages): static
    {
        $this->programmingLanguages = $programmingLanguages;

        return $this;
    }

    public function isMysql(): ?bool
    {
        return $this->mysql;
    }

    public function setMysql(?bool $mysql): static
    {
        $this->mysql = $mysql;

        return $this;
    }
}
