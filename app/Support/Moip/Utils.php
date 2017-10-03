<?php

namespace App\Support\Moip;


class Utils
{

    /**
     * Status order
     *
     * @var array
     */
    public static $ORDER_STATUS = [
        'CREATED' => 'Pedido Criado',
        'WAITING' => 'Aguardando Pagamento',
        'PAID'    => 'Pago',
        'NOT_PAID'=> 'Cancelado',
        'RECERTED'=> 'Reembolsado'
    ];


    /**
     * Status payment
     */
    public static $PAYMENT_STATUS = [
        'CREATED' => 'Criado',
        'WAITING' => 'Aguardando Confirmação',
        'IN_ANALYSIS' => 'Aguardando Análise',
        'PRE_AUTHORIZED' => 'Pré-Autorizado',
        'AUTHORIZED'  => 'Autorizado',
        'CANCELLED' => 'Cancelado',
        'REFUNDED'  => 'Reembolsado',
        'REVERSED' => 'Revertido',
        'SETTLED'  => 'Liquidado'
    ];

    /**
     * Format amount to real
     *
     * @param $amount
     * @return string
     */
    public static function formatAmount($amount)
    {
        return number_format(
            (float)chunk_split($amount, strlen($amount)-2, '.'),
            2,
            ',',
            '.'
        );
    }

    /**
     * Format status order and get
     *
     * @param $status
     * @return string
     */
    public static function formatOrderStatus($status)
    {
        if(!array_key_exists($status, self::$ORDER_STATUS)) {
            return 'NÃO RECONHECIDO';
        }

        return self::$ORDER_STATUS[$status];
    }

    /**
     * Format status payment and get
     *
     * @param $status
     * @return string
     */
    public static function formatPaymentStatus($status)
    {
        if(!array_key_exists($status, self::$PAYMENT_STATUS)) {
            return 'NÃO RECONHECIDO';
        }

        return self::$PAYMENT_STATUS[$status];
    }

    /**
     * Format date to Carbon
     * @param $timestamp
     * @return \Carbon\Carbon
     */
    public static function formatDate($timestamp)
    {
        \Carbon\Carbon::setLocale('pt_BR');

        if(is_string($timestamp)) {
            return \Carbon\Carbon::parse($timestamp);
        }

        return \Carbon\Carbon::createFromTimestamp($timestamp);
    }
}