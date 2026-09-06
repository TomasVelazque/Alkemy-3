<?php

namespace App\DTO;

class StoreOrdenDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly int $carrito_id,
        public readonly string $direccion_envio,
        public readonly string $metodo_pago,
    )
    {}

    public function toArray(): array 
    {
        return [
            'carrito_id' => $this->carrito_id,
            'direccion_envio' => $this->direccion_envio,
            'metodo_pago' => $this->metodo_pago,
        ];
    }

    public static function fromArray(array $data): self 
    {
        return new self (
            carrito_id: (int) $data['carrito_id'],
            direccion_envio: (string) $data['direccion_envio'],
            metodo_pago: (string) $data['metodo_pago'],
        );
    } 
}
