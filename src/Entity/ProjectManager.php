<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectManagerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectManagerRepository::class)]
class ProjectManager
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $methodologies = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reportingSystems = null;

    #[ORM\Column(nullable: true)]
    private ?bool $scrum = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethodologies(): ?string
    {
        return $this->methodologies;
    }

    public function setMethodologies(?string $methodologies): static
    {
        $this->methodologies = $methodologies;

        return $this;
    }

    public function getReportingSystems(): ?string
    {
        return $this->reportingSystems;
    }

    public function setReportingSystems(?string $reportingSystems): static
    {
        $this->reportingSystems = $reportingSystems;

        return $this;
    }

    public function isScrum(): ?bool
    {
        return $this->scrum;
    }

    public function setScrum(?bool $scrum): static
    {
        $this->scrum = $scrum;

        return $this;
    }
}
