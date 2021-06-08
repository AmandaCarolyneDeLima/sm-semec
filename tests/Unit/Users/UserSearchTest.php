<?php

namespace Tests\Unit\Users;

use Tests\TestCase;
use App\Models\User;

class UserSearchTest extends TestCase
{
     /** @var array */
    protected $users;

    public function setUp(): void
    {
        parent::setUp();
        $this->users[] = User::factory()->create(['name' => 'Diego Marczal']);
        $this->users[] = User::factory()->create(['name' => 'Andres Jesse']);
        $this->users[] = User::factory()->create(['name' => 'Eduarda Lara']);
        $this->users[] = User::factory()->create(['name' => 'Amanda Carolyne de Lima']);
        $this->users[] = User::factory()->create(['name' => 'Thais Michele Hryssai da Luz']);
    }

    public function testSearchByNamePassingOneLetterThatShouldReturnAllUsers(): void
    {
        $searchResult = User::search('a');
        $expectedUsers = collect($this->users);

        $this->assertEquals(5, $searchResult->count());
        $this->assertEmpty($searchResult->diff($expectedUsers));
    }

    public function testSearchByNameThatShouldReturnOnlyOneUser(): void
    {
        $searchResult = User::search('Diego Marczal');
        $expectedUsers = collect([ $this->users[0] ]);

        $this->assertEquals(1, $searchResult->count());
        $this->assertEmpty($searchResult->diff($expectedUsers));
    }
}
