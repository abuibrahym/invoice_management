<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]

#[UniqueEntity(
    fields: ['invoice_number'],
    message: 'The invoice with this number already exists..',
)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:'Add invoice number!!')]
    // #[Assert\Unique(message:'Invoice with this NUmber already exists..')]
    private ?int $invoice_number = null;

    #[Assert\NotBlank(message:'Add invoice name!!')]
    #[ORM\Column(length: 100)]
    private ?string $invoice_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(nullable: true)]
    private ?int $phone_number = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:'Amount Field can\'t be empty')]
    private ?float $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceNumber(): ?int
    {
        return $this->invoice_number;
    }

    public function setInvoiceNumber(int $invoice_number): static
    {
        $this->invoice_number = $invoice_number;

        return $this;
    }

    public function getInvoiceName(): ?string
    {
        return $this->invoice_name;
    }

    public function setInvoiceName(string $invoice_name): static
    {
        $this->invoice_name = $invoice_name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(int $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }
}
