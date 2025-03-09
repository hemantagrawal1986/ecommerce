<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\CreatesApplication;

class ItemTest extends TestCase
{
    use RefreshDatabase;
    //use CreatesApplication;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
        $user=User::factory()->create();
        $this->user=$user;
    }

    public function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_item_can_be_viewed()
    {
        $response=$this->actingAs($this->user)->get("item/view");

        $response->assertStatus(200);
    }

    public function test_item_view_can_be_paginated()
    {
        $item=Item::factory()
                    ->count(30)
                    ->state(new Sequence(
                        ["deleted_at"=>now()],
                        ["deleted_at"=>null],
                    ))
                    ->create();
        $this->items=Item::orderBy("name")->paginate(config("appconfig.paging.size"));           
        $response=$this->actingAs($this->user)->get("item/view");

        $response->assertViewHas("items",function($items)
        {
            return $items->total() === $this->items->total();
        });
    }

    public function test_item_deleted_cannot_be_viewed()
    {
        $item=Item::factory()
                    ->count(30)
                    ->state(new Sequence(
                        ["deleted_at"=>now()],
                    ))
                    ->create();
        $this->items=Item::orderBy("name")->paginate(config("appconfig.paging.size"));          
        $response=$this->actingAs($this->user)->get("item/view");

        $response->assertViewHas("items",function($items)
        {
            
            return $items->total() === $this->items->total();
        });
    }

    public function test_item_can_be_created()
    {
        $item=Item::factory()->make();
        $response=$this->actingAs($this->user)->post(route("item.store"),$item->toArray());

        //$response->assertSuccessful();
        $response->assertRedirect(route("item.view"));

        $this->assertDatabaseHas("items",$item->toArray());
    }

    public function test_item_duplicate_cannot_be_created()
    {
        $item=Item::factory()->create();
        $response=$this->actingAs($this->user)->post(route("item.store"),$item->toArray());

        //$response->assertSuccessful();
        $response->assertInvalid(["name"=>"The name has already been taken."]);

       // $this->assertDatabaseHas("items",$item->toArray());
    }

    public function test_item_can_be_updated()
    {
        $item=Item::factory()->create();
        $new_item_for_update=Item::factory()->make();
        $item->name=$new_item_for_update->name;
        $response=$this->actingAs($this->user)->put(route("item.update",$item->id),$item->toArray());

        //$response->assertSuccessful();
        $response->assertRedirect(route("item.view"));

        $this->assertDatabaseHas("items",["name"=>$item->name,"id"=>$item->id]);
    }

    public function test_item_duplicate_cannot_be_updated()
    {
        $item=Item::factory()->create();
        $item_other=Item::factory()->create();

        $item->name=$item_other->name;
        
        $response=$this->actingAs($this->user)->put(route("item.update",$item->id),$item->toArray());

        //$response->assertSuccessful();
        $response->assertInvalid(["name"=>"The name has already been taken."]);
    }

    public function test_item_can_be_trashed()
    {
        $item=Item::factory()->create();
       
        $response=$this->actingAs($this->user)->delete(route("item.delete",$item->id));

        //$response->assertSuccessful();
        $response->assertRedirect(route("item.view"));

        $item->refresh();

        $this->assertDatabaseHas("items",[
                                            "id"=>$item->id,
                                            "deleted_at"=>$item->deleted_at,
                                        ]);

        $this->assertIsBool($item->trashed());
    }

    public function test_item_trashed_cannot_be_duplicated_via_create()
    {   
        $item_create=Item::factory()->make();

        $item_other=Item::factory()->create();

        $item_create->name=$item_other->name;

        $item_other->delete();

        $response=$this->actingAs($this->user)->post(route("item.store"),$item_create->toArray());

        $response->assertInvalid([
            "name"=>"The name has already been taken."
        ]);
    }

    public function test_item_trashed_cannot_be_duplicated_via_update()
    {   
        $item_create=Item::factory()->create();

        $item_other=Item::factory()->create();

        $item_create->name=$item_other->name;

        $item_other->delete();

        $response=$this->actingAs($this->user)->put(route("item.update",$item_create->id),$item_create->toArray());

        $response->assertInvalid([
            "name"=>"The name has already been taken."
        ]);
    }

    public function test_item_trashed_can_be_updated()
    {   
        $item_create=Item::factory()->create();
        $item_create->delete();
        $response=$this->actingAs($this->user)->get(route("item.edit",$item_create->id),$item_create->toArray());

        $response->assertStatus(200);
        $response->assertViewIs("item.edit");
    }

}
