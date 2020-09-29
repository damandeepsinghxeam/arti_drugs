<?php

namespace Tests\Feature;

use App\DmsCategory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Auth;

class DmsCategoryTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDmsCategoryIndex()
    {
        $user = User::first();
        $response = $this->actingAs($user)->get('/dms-categories');

        //to get the response headers
//        $response->dumpHeaders();

        //to get the response data
//        $response->dump();

        $response->assertSuccessful();
    }

    public function testDmsCategoryCreateFormvalidate()
    {
        $this->assertEquals([
            'name' => 'required',
        ]);
    }

    public function testDmsCategoryCreate()
    {
        $dmsCategory = factory('App\DmsCategory')->create();

        //When user submits user request to create endpoint
        $response = $this->post('dms-categories',$dmsCategory->toArray()); // your route to create user

        //It gets stored in the database
//        $this->assertEquals(4,DmsCategory::all()->count());
        $response->assertStatus(302);
    }

    public function testDmsCategoryUpdate()
    {
        $user = User::first();
        $dmsCategory = factory('App\DmsCategory')->create();
        $this->assertDatabaseHas('dms_categories',['id'=> $dmsCategory->id]);
        $response = $this->actingAs($user)
            ->patch('dms-categories/'.$dmsCategory->id, [
                'document_category'    => 'Updated Category',
            ]);
        $response->assertStatus(302);
    }

    public function testDmsCategoryDelete()
    {
        $user = User::first();
        $dmsCategory = DmsCategory::latest()->first();
        $this->assertDatabaseHas('dms_categories',['id'=> $dmsCategory->id]);

        $response = $this->actingAs($user)
            ->delete('dms-categories/'.$dmsCategory->id);

        $response->assertStatus(302);
    }

}
