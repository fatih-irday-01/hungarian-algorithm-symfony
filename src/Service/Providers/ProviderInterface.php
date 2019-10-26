<?php


namespace App\Service\Providers;


interface ProviderInterface
{
    // NOTE : __construct'a client ile verileri al
    public function __construct();



    // NOTE :  getData'da veri cikisi ver
    /*
     * [
     *  [
     *      'name'=>??,
     *      'level'=>??,
     *      'duration'=>??,
     *  ]
     * ]
     *
     */
    public function getData(): array;
}