<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case PIX = 'pix';
    case BOLETO = 'boleto';
    case CREDIT_CARD = 'credit_card';

    public function label(): string
    {
        return match ($this) {
            self::PIX => 'Pix',
            self::BOLETO => 'Boleto',
            self::CREDIT_CARD => 'Cartão de Crédito',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn ($item) => $item->value, self::cases());
    }
}
