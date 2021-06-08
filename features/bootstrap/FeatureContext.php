<?php

use Behat\Behat\Context\Context;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Illuminate\Contracts\Console\Kernel;

class FeatureContext extends TestCase implements Context

{
    use DatabaseMigrations;

    /**
     * @var
     */
    protected $content;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
//        putenv('DB_CONNECTION=sqlite');
//        putenv('DB_DATABASE=:memory:');
        parent::setUp();
    }
    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        $this->artisan('migrate');
        $this->app[Kernel::class]->setArtisan(null);
    }

    /** @AfterScenario */
    public function after(AfterScenarioScope $scope)
    {
        $this->artisan('migrate:rollback');
    }

    /**
     * @Given a user called :user exists
     */
    public function aUserCalledExists($user)
    {
        $user = User::factory()
            ->state([
                'name' => $user
            ])
            ->create();
    }

    /**
     * @Given I am logged in as :user
     */
    public function iAmLoggedInAs($user)
    {
        $user = User::where('name', $user)->first();
        $this->be($user);
    }

    /**
     * @Given I visit the path :path
     */
    public function iVisitThePath($path)
    {
        $response = $this->get($path);
        $this->assertEquals(200, $response->getStatusCode());
        $this->content = $response->getContent();
    }

    /**
     * @Then I should see the text :text
     */
    public function iShouldSeeTheText($text)
    {
        $this->assertStringContainsString($text, $this->content);
    }
}
