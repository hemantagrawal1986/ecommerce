<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\User;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    public function test_category_can_be_viewed()
    {
        $user=User::factory()->create();
        $category=Category::factory()->create();

        $response=$this->actingAs($user)->get(route("category.view"));
        $response->assertStatus(200);
    }

    

}
