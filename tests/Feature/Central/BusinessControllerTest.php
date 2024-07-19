<?php

namespace Tests\Feature\Central;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BusinessControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_can_render_business_settings_page(): void
    {
        $response = $this->login()->withDomain()->get(route('business'));

        $response->assertStatus(200);
    }

    public function test_can_update_business_info(): void
    {
        Storage::fake('public');

        $response = $this->login()->withDomain()->post(route('business'), [
            'logo' => UploadedFile::fake()->image('logo.png'),
            'brand_name' => 'test brand',
            'brand_description' => 'test description',
        ]);

        $this->tenant->fresh();

        $response->assertRedirect();
        Storage::disk('public')->assertExists($this->tenant->logo);
        $this->assertEquals($this->tenant->brand_name, 'test brand');
        $this->assertEquals($this->tenant->brand_description, 'test description');
    }


}
