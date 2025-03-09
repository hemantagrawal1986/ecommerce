<?php

namespace Tests\Feature\Action;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Action\OrderAction;
use App\Action\OrderProcessAction;
use Mockery\MockInterface;

class OrderActionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_order_can_be_executed()
    {
        //$response = $this->get('/');
        $this->withoutExceptionHandling();
        //$response->assertStatus(200);
        $OrderAction = $this->spy(OrderAction::class);
        //$OrderAction->shouldReceive("execute")->andReturn(true);
        
        $response=$this->get("/learning/view");
        $response->assertStatus(200);
       // $new=new OrderAction;
       // $order=new OrderAction();
       // $OrderAction->execute();

        $OrderAction->shouldHaveReceived("execute");
        
    }

    public function test_order_can_chained()
    {
        ///$this->withoutExceptionHandling();
        $orderAction = $this->mock(OrderAction::class);
        $orderAction->shouldReceive("foo->bar->done")->andReturnFalse();
        

        $response=$this->get("/learning/chain");
        $response->assertStatus(200);

        

        
    }

    public function test_order_invoice_number_public_property()
    {
        ///$this->withoutExceptionHandling();
        $orderAction = $this->spy(OrderAction::class)->makePartial();

        $response=$this->get("/learning/set");
        $response->assertStatus(200);
        $orderAction->shouldHaveReceived("__set","invoice_number")->once();

        

        
    }
}