<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\TesterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TesterRepository::class)]
class Tester
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $testingSystems = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reportingSystems = null;

    #[ORM\Column(nullable: true)]
    private ?bool $selenium = null;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $userId;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestingSystems(): ?string
    {
        return $this->testingSystems;
    }

    public function setTestingSystems(?string $testingSystems): static
    {
        $this->testingSystems = $testingSystems;

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

    public function isSelenium(): ?bool
    {
        return $this->selenium;
    }

    public function setSelenium(?bool $selenium): static
    {
        $this->selenium = $selenium;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->userId->contains($userId)) {
            $this->userId->add($userId);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        $this->userId->removeElement($userId);

        return $this;
    }

}
