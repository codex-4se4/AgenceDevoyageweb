<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(fields={"login"}, message="There is already an account with this login")
 */
class Utilisateur implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Veuillez saisir votre nom.")
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le nom doit contenir au minimum {{ limit }} caractères.",
     *      maxMessage = "Le nom doit contenir au maximum {{ limit }} caractères."
     * )
     * @Assert\Type(
     *     type="string",
     *     message="La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Veuillez saisir votre prénom.")
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le prénom doit contenir au minimum {{ limit }} caractères.",
     *      maxMessage = "Le prénom doit contenir au maximum {{ limit }} caractères."
     * )
     * @Assert\Type(
     *     type="string",
     *     message="La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank(message="Veuillez saisir votre email.")
     * @Assert\Email(
     *     message = "Le mail '{{ value }}' n'est pas valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=8)
     * @Assert\NotBlank(message="Veuillez saisir votre cin.")
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      exactMessage = "Le cin doit contenir exactement {{ limit }} caractères."
     * )
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank(message="Veuillez saisir votre passeport.")
     * @Assert\Length(
     *      min = 6,
     *      max = 6,
     *      exactMessage = "Le passeport doit contenir exactement {{ limit }} caractères."
     * )
     */
    private $passeport;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Veuillez saisir votre login.")
     * @Assert\Length(
     *      min = 3,
     *      max = 180,
     *      minMessage = "Le login doit contenir au minimum {{ limit }} caractères.",
     *      maxMessage = "Le login doit contenir au maximum {{ limit }} caractères."
     * )
     */
    private $login;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank(message="Veuillez saisir votre mot de passe.")
     * @Assert\Length(
     *      min = 6,
     *      max = 200,
     *      minMessage = "Le mot de passe doit contenir au minimum {{ limit }} caractères.",
     *      maxMessage = "Le mot de passe doit contenir au maximum {{ limit }} caractères."
     * )
     */
    private $mdp;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @var string
     */
    private $photo;

    /**
     * @Vich\UploadableField(mapping="utilisateur_images", fileNameProperty="photo")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getPasseport(): ?string
    {
        return $this->passeport;
    }

    public function setPasseport(string $passeport): self
    {
        $this->passeport = $passeport;

        return $this;
    }


    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->login;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->mdp;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }


    public function setImageFile($image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRoles()
    {
        return array((string)$this->getRole());
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function serialize() {

        return serialize(array(
            $this->id,
            $this->login,
            $this->mdp,
        ));

    }

    public function unserialize($serialized) {

        list (
            $this->id,
            $this->login,
            $this->mdp,
            ) = unserialize($serialized);
    }
}

