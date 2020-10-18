<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"question_browse"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $character_owner_hash;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"question_browse"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"question_browse"})
     */
    private $eve_character_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"question_browse"})
     */
    private $portrait;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="user")
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="user")
     */
    private $answer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $banned;

    /**
     * @ORM\OneToMany(targetEntity=Suggest::class, mappedBy="user")
     */
    private $suggests;

    /**
     * @ORM\ManyToMany(targetEntity=SolarSystem::class, mappedBy="user")
     */
    private $solarSystems;

    public function __construct()
    {
        $this->question = new ArrayCollection();
        $this->answer = new ArrayCollection();
        $this->suggests = new ArrayCollection();
        $this->solarSystems = new ArrayCollection();
    }

    public function __toString() {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacterOwnerHash(): ?string
    {
        return $this->character_owner_hash;
    }

    public function setCharacterOwnerHash(string $character_owner_hash): self
    {
        $this->character_owner_hash = $character_owner_hash;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->character_owner_hash;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEveCharacterId(): ?int
    {
        return $this->eve_character_id;
    }

    public function setEveCharacterId(int $eve_character_id): self
    {
        $this->eve_character_id = $eve_character_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPortrait(): ?string
    {
        return $this->portrait;
    }

    public function setPortrait(string $portrait): self
    {
        $this->portrait = $portrait;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->question->contains($question)) {
            $this->question[] = $question;
            $question->setUser($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->question->contains($question)) {
            $this->question->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getUser() === $this) {
                $question->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswer(): Collection
    {
        return $this->answer;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answer->contains($answer)) {
            $this->answer[] = $answer;
            $answer->setUser($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answer->contains($answer)) {
            $this->answer->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getUser() === $this) {
                $answer->setUser(null);
            }
        }

        return $this;
    }

    public function getBanned(): ?bool
    {
        return $this->banned;
    }

    public function setBanned(bool $banned): self
    {
        $this->banned = $banned;

        return $this;
    }

    /**
     * @return Collection|Suggest[]
     */
    public function getSuggests(): Collection
    {
        return $this->suggests;
    }

    public function addSuggest(Suggest $suggest): self
    {
        if (!$this->suggests->contains($suggest)) {
            $this->suggests[] = $suggest;
            $suggest->setUser($this);
        }

        return $this;
    }

    public function removeSuggest(Suggest $suggest): self
    {
        if ($this->suggests->contains($suggest)) {
            $this->suggests->removeElement($suggest);
            // set the owning side to null (unless already changed)
            if ($suggest->getUser() === $this) {
                $suggest->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SolarSystem[]
     */
    public function getSolarSystems(): Collection
    {
        return $this->solarSystems;
    }

    public function addSolarSystem(SolarSystem $solarSystem): self
    {
        if (!$this->solarSystems->contains($solarSystem)) {
            $this->solarSystems[] = $solarSystem;
            $solarSystem->addUser($this);
        }

        return $this;
    }

    public function removeSolarSystem(SolarSystem $solarSystem): self
    {
        if ($this->solarSystems->contains($solarSystem)) {
            $this->solarSystems->removeElement($solarSystem);
            $solarSystem->removeUser($this);
        }

        return $this;
    }
}
