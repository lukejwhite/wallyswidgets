<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WidgetTest extends TestCase
{
    /**
     * test that 1 widget will return 1 pack of 250
     *
     * @return void
     */
    public function test_first_test_case()
    {
        $this->seed();

        $response = $this->post('/getWidgets', [
            'widgets' => 1
        ]);

        $response->assertJson([
            [
                'pack_size' => 250
            ]
        ]);
    }

    /**
     * test that 250 widgets will return 1 pack of 250
     *
     * @return void
     */
    public function test_second_test_case()
    {

        $response = $this->post('/getWidgets', [
            'widgets' => 250
        ]);

        $response->assertJson([
            [
                'pack_size' => 250
            ]
        ]);
    }

    /**
     * test that 251 widget will return 1 pack of 500
     *
     * @return void
     */
    public function test_third_test_case()
    {

        $response = $this->post('/getWidgets', [
            'widgets' => 251
        ]);

        $response->assertJson([
            [
                'pack_size' => 500
            ]
        ]);
    }

    /**
     * test that 501 widget will return 1 pack of 500 and 1 pack of 250
     *
     * @return void
     */
    public function test_forth_test_case()
    {

        $response = $this->post('/getWidgets', [
            'widgets' => 501
        ]);

        $response->assertJson([
            [
                'pack_size' => 500
            ],
            [
                'pack_size' => 250
            ]
        ]);
    }

    /**
     * test that 12,001 widget will return:-
     * 2x packs of 5000
     * 1x pack of 2000
     * 1x pack of 250
     *
     * @return void
     */
    public function test_fifth_test_case()
    {

        $response = $this->post('/getWidgets', [
            'widgets' => 12001
        ]);

        $response->assertJson([
            [
                'pack_size' => 5000
            ],
            [
                'pack_size' => 5000
            ],
            [
                'pack_size' => 2000
            ],
            [
                'pack_size' => 250
            ]
        ]);
    }


}
