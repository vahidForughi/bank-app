<?php

namespace Tests\Feature;

use Database\Factories\CardFactory;
use Database\Factories\TransactionFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionApiTest extends TestCase
{
//    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $transaction = TransactionFactory::new()->makeOne([
            'origin_card_id' => $origin_card = CardFactory::new()->createOne(),
            'destination_card_id' => $destination_card = CardFactory::new()->createOne(),
        ]);

        $response = $this->postJson('/api/transactions', [
            'origin_card_number' => $origin_card->number,
            'destination_card_number' => $destination_card->number,
            'cash' => $transaction->cash,
            'type' => $transaction->type,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'status',
                'data' => [
                    "id",
                    "origin_card_id",
                    "destination_card_id",
                    "cash",
                    "type",
                    "status",
                ]
            ]);

        $data = json_decode($response->getContent());

        $this->assertTrue($data->success);
        $this->assertEquals($data->data->origin_card_id, $origin_card->id);
        $this->assertEquals($data->data->destination_card_id, $destination_card->id);
        $this->assertEquals($data->data->cash, $transaction->cash);
        $this->assertEquals($data->data->type, $transaction->type);
    }
}
