<?php

namespace App\Services\Moip;

use Moip\Moip;

class WebHookService
{

    /**
     * @var Moip
     */
    private $moip;

    /**
     * MoipWebHookService constructor.
     */
    public function __construct()
    {
        $this->moip = \Moip::start();
    }


    /**
     * @return mixed
     */
    public function configure()
    {
        try{
            $notification = $this->moip->notifications();
            $notification->addEvent('ORDER.*')
                         ->addEvent('PAYMENT.*')
                         ->setTarget('https://requestb.in/rkl3f0rk')                        
                         ->create();
            return response()->json($notification, 201);
        }catch (\Exception $e) {
            return response()->json(['error' => $e->__toString()], 400);
        }
    }

}