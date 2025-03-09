<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Item;
class GraphDBSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graph:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Bolt(bolt://localhost:7687

        // $conn = new \Bolt\connection\Socket('127.0.0.1', 7687);

        // $bolt = new \Bolt\Bolt($conn);

        // $protocol = $bolt->build();

        // $response = $protocol->hello(['scheme' => 'basic', 'principal' => 'neo4j','credentials'=>'neo4j1986','user_agent'=>'Example/4.1.0']);//->getResponse();
        
        $protocol = \App\DB\GraphConnector::connect();
       
        //$response = $response->logon(['scheme' => 'basic', 'principal' => 'neo4j', 'credentials' => 'neo4j']);

        $orders=Order::with(["invoice","invoice.user","items","items.category"])
                    ->where("created_at",'>=',date("Y-m-d 00:00:00",strtotime(date("Y-m-d 00:00:00")." -1 day")))
                    ->where("created_at",'<=',date("Y-m-d 23:59:59"))
                    ->get();

      
        
        //echo $orders->count();

        foreach($orders as $order)
        {
         
          $query=" MERGE (user:User {name:\"".$order->invoice->user->name."\",id:".$order->invoice->user->id."}) ";
          $query.=" MERGE (item:Item {name:\"".$order->items->name."\",id:".$order->items->id.",category:".$order->items->category->id."} ) ";
          $query.=" MERGE ";
          $query.=" (user)-[p:PURCHASE {date:datetime('".date("Y-m-d\TH:i:s",strtotime($order->invoice->created_at))."')}]->(item) ";
      
          $protocol
          ->run($query)
          ->pull();

           // Fetch waiting server responses for pipelined messages.
        foreach ($protocol->getResponses() as $response) {
            
            var_dump($response);
            
         }
        }

       
       
        return Command::SUCCESS;
    }
}
