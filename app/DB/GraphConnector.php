<?php

namespace App\DB;

class GraphConnector 
{
    public function __construct() 
    {

    }

    public static function connect()
    {
        $conn = new \Bolt\connection\Socket('127.0.0.1', 7687);

        $bolt = new \Bolt\Bolt($conn);

        $protocol = $bolt->build();

        $response = $protocol->hello(['scheme' => 'basic', 'principal' => 'neo4j','credentials'=>'neo4j1986','user_agent'=>'Ecommerce/1.0']);//->getResponse();

        return $protocol;
    }
}