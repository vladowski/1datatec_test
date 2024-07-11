<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Events\SubmissionSaved;
use Illuminate\Support\Facades\Event;

class SubmitControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSubmitValidData()
    {
        Event::fake();

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.',
        ];

        $response = $this->postJson('/api/submit', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('submissions', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.',
        ]);

        Event::assertDispatched(SubmissionSaved::class, function (SubmissionSaved $event) use ($data) {
            return $event->getSubmission()->name === $data['name'] &&
                $event->getSubmission()->email === $data['email'];
        });
    }

    public function testSubmitInvalidData()
    {
        $data = [
            'name' => '',
            'email' => 'invalid_email',
            'message' => '',
        ];

        $response = $this->postJson('/api/submit', $data);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['name', 'email', 'message']);
    }
}
