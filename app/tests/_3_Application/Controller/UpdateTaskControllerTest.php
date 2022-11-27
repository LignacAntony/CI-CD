<?php

namespace App\Tests\_3_Application\Controller;

use DateTime;
use App\Tests\_3_Application\AbstractApiTest;

class UpdateTaskControllerTest extends AbstractApiTest
{
	public function setUp(): void
	{
		parent::setUp();

		$this->iri = '/api/tasks/2';
		$this->validPayload = [
			'title' => $this->faker->sentence(),
			'startDate' => null,
			'endDate' => null,
			'dueDate' => (new DateTime())->format('Y-m-d\TH:i:s\Z'),
			'todolist' => '/api/todolists/2',
			'tags' => [
				'/api/tags/2',
				[
					'name' => $this->faker->sentence(2),
					'color' => $this->faker->safeColorName()
				]
			],
		];
	}

	public function test_update_without_authentication(): void
	{
		parent::test_endpoint_without_authentication('PATCH');
	}

	public function test_update_with_a_valid_payload(): void
	{
		parent::test_update_with_a_valid_payload();

		$this->assertArrayHasKey('title', $this->responseContent);
		$this->assertSame($this->responseContent['title'], $this->validPayload['title']);
		$this->assertCount(count($this->validPayload['tags']), $this->responseContent['tags']);
	}

	public function test_update_with_an_invalid_payload_duplicate_title(): void
	{
		$this->invalidPayload = $this->validPayload;
		$this->invalidPayload['title'] = 'Acheter un vase pour les poireaux';

		parent::test_update_with_an_invalid_payload();
	}
}
