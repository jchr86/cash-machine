<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 26/08/19
 * Time: 10:47
 */

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    use TimestampableEntity;

    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=150, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="smallint")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotBlank()
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=30)
     *
     * @Assert\NotBlank()
     */
    private $externalNum;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $internalNum;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank()
     */
    private $suburb;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank()
     */
    private $town;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank()
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=5)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="5")
     */
    private $postalCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Account", mappedBy="client", orphanRemoval=true)
     */
    private $accounts;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->accounts = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFullname();
    }

    /**
     * Returns the gender list.
     *
     * @return array
     */
    public static function getGenderList(): array
    {
        return [
            'gender_male' => self::GENDER_MALE,
            'gender_female' => self::GENDER_FEMALE,
        ];
    }

    /**
     * @return string
     */
    public function getFullname(): string
    {
        return sprintf('%s %s', $this->getName(), $this->getLastname());
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Client
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return Client
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Client
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getGender(): ?int
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     *
     * @return Client
     */
    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string $street
     *
     * @return Client
     */
    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalNum(): ?string
    {
        return $this->externalNum;
    }

    /**
     * @param string $externalNum
     *
     * @return Client
     */
    public function setExternalNum(string $externalNum): self
    {
        $this->externalNum = $externalNum;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInternalNum(): ?string
    {
        return $this->internalNum;
    }

    /**
     * @param string|null $internalNum
     *
     * @return Client
     */
    public function setInternalNum(?string $internalNum): self
    {
        $this->internalNum = $internalNum;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSuburb(): ?string
    {
        return $this->suburb;
    }

    /**
     * @param string $suburb
     *
     * @return Client
     */
    public function setSuburb(string $suburb): self
    {
        $this->suburb = $suburb;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTown(): ?string
    {
        return $this->town;
    }

    /**
     * @param string $town
     *
     * @return Client
     */
    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return Client
     */
    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     *
     * @return Client
     */
    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return Collection|Account[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    /**
     * @param Account $account
     *
     * @return Client
     */
    public function addAccount(Account $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
            $account->setClient($this);
        }

        return $this;
    }

    /**
     * @param Account $account
     *
     * @return Client
     */
    public function removeAccount(Account $account): self
    {
        if ($this->accounts->contains($account)) {
            $this->accounts->removeElement($account);
            // set the owning side to null (unless already changed)
            if ($account->getClient() === $this) {
                $account->setClient(null);
            }
        }

        return $this;
    }
}
