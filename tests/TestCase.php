<?php
//test
namespace Tests;

use App\Helpers\FileHandler;
use App\Helpers\ImageHandler;
use App\Repositories\Salesforce\SalesforceRepository;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Services\MailService;
use Config;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Notification;
use Mockery\Mock;
use ReflectionObject;
use Storage;

class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    public $baseUrl = 'http://localhost';
    
    public function setUp()
    {
        parent::setUp();
        $this->baseUrl = config('app.url');
        
        if (config('database.default') != 'sqlite_testing') {
            dd('Unit testing can only run on testing environment');
        }
        
        $this->mockStorage();
        $this->mockImage();
        $this->mockFile();
        $this->mockMailService();
        $this->mockSalesforce();
    }
    
    protected function tearDown()
    {
        parent::tearDown();
        
        $reference = new ReflectionObject($this);
        foreach ($reference->getProperties() as $prop) {
            if (! $prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
    }
    
    protected function mockStorage()
    {
        Storage::extend('mock', function () {
            return \Mockery::spy(\Illuminate\Contracts\Filesystem\Filesystem::class);
        });
        Config::set('filesystems.disks.mock', ['driver' => 'mock']);
        Config::set('filesystems.default', 'mock');
        Config::set('filesystems.disks.local.driver', 'mock');
        Config::set('filesystems.disks.public.driver', 'mock');
        Config::set('filesystems.disks.files.driver', 'mock');
        Notification::fake();
    }
    
    protected function mockImage()
    {
        \App::singleton(ImageHandler::class, function () {
            return \Mockery::spy(ImageHandler::class);
        });
    }
    
    protected function mockFile()
    {
        \App::singleton(FileHandler::class, function () {
            $mock = \Mockery::spy(FileHandler::class);
            $mock->shouldReceive('getContent')->andReturnValues(['test']);
            $mock->shouldReceive('getRemoteSize')->andReturnValues([123]);
            
            return $mock;
        });
    }
    
    protected function mockMailService()
    {
        $this->app->singleton(MailService::class, function () {
            return \Mockery::spy(MailService::class);
        });
    }
    
    protected function getMockedMailService()
    {
        return \App::make(MailService::class);
    }
    
    protected function mockSalesforce()
    {
        $this->app->singleton('salesforce.live', function () {
            return \Mockery::spy(SalesforceRepository::class);
        });
        
        $this->app->singleton('salesforce.sandbox', function () {
            return \Mockery::spy(SalesforceRepository::class);
        });
    }
    
    /**
     * @return SalesforceRepository|Mock|null
     */
    protected function getMockedSalesforceRepository()
    {
        return SalesforceRepositoryFactory::get();
    }
    
    public function attachFile($prefix)
    {
        return [
            $prefix . '_url'      => 'images/blank.png',
            $prefix . '_filename' => 'filename',
            $prefix . '_id'       => 12345,
            $prefix . '_action'   => 'new',
        ];
    }
    
    public function getFirstAttribute($selector, $attribute)
    {
        return $this->crawler->filter($selector)->getNode(0)->getAttribute($attribute);
    }
}
