<?php

namespace Tests\Feature;

use App\Models\CategoryGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CategoryGroupTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function test_category_group_can_be_created()
     {
        $user=User::factory()->create();
        $categoryGroup=CategoryGroup::factory()->make();

        $response=$this->actingAs($user)
                        ->post(route("category_group.store"),[
                            ...$categoryGroup->toArray(),
                        ]);
        
        $response->assertRedirect(route("category_group.view"));
        $this->assertDatabaseHas("category_group",$categoryGroup->toArray());
     }

     public function test_category_group_cannot_be_duplicated()
     {
        $user=User::factory()->create();
        $categoryGroup=CategoryGroup::factory()->make();

        dd($categoryGroup->toArray());
        $response=$this->actingAs($user)
                        ->post(route("category_group.store"),[
                            ...$categoryGroup->toArray(),
                        ]);
        $this->assertDatabaseMissing("category_group",["name"=>$categoryGroup->name]);
        $response->assertRedirect(route("category_group.create"));
     }
}
