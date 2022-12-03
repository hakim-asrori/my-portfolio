<?php

namespace App\Console\Commands;

use App\Http\Traits\CreateFile;
use App\Http\Traits\NameSpaceFixer;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Repository extends Command
{
    use NameSpaceFixer;

    protected $basePath = 'App\Http\Repositories';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name : The name of repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make repository';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $repositoryName = $this->argument('name');
        if ($repositoryName === '' || is_null($repositoryName) || empty($repositoryName)) {
            $this->error('Name Invalid..!');
        }

        $isInterfaceCreated = $this->createInterface($repositoryName);
        if (!$isInterfaceCreated) {
            return;
        }

        $this->createRepository($repositoryName);
    }

    protected function createInterface($name)
    {
        if (!File::exists($this->getBaseDirectory('Interfaces\\' . $name))) {
            File::makeDirectory($this->getBaseDirectory('Interfaces\\' . $name), 0775, true);
        }

        $title = title($name) . "Interface";
        $baseName = $this->getBaseFileName($name) . "Interface";

        $interfacePath = 'app/Http/Repositories/Interfaces/' . $title;
        $filePath = $interfacePath . '.php';
        $interfaceNameSpacePath = $filePath;

        $stubProperties = [
            "{interfaceName}" => $baseName
        ];

        if (!File::exists($filePath)) {
            $fileContent = __DIR__ . "/stub/repository-interface.stub";

            new CreateFile(
                $stubProperties,
                $interfaceNameSpacePath,
                $fileContent
            );

            $this->info('Interface Created Successfully.');
            return true;
        } else {
            $this->error('Interface Already Exists.');
            return false;
        }
    }

    public function createRepository($class)
    {
        if (!File::exists($this->getBaseDirectory($class))) {
            File::makeDirectory($this->getBaseDirectory($class), 0775, true);
        }

        $titleInterface = title($class) . "Interface";
        $interface = $this->getBaseFileName($class) . "Interface";

        $interfacePath = 'app/Http/Repositories/Interfaces/' . $titleInterface;
        $interfaceNameSpace = Str::ucfirst($this->getNameSpace($interfacePath));

        $title = $this->getBaseFileName($class);
        $titleRepository = title($class) . "Repository";
        $baseName = $this->getBaseFileName($class) . "Repository";

        $repoPath = 'app/Http/Repositories/' . $titleRepository;
        $filePath = $repoPath . '.php';

        $repositoryNamespacePath = $filePath;

        $stubProperties = [
            "{interfaceName}" => $interface,
            "{repositoryName}" => $baseName,
            "{model}" => $title,
            "{modelVariable}" => Str::camel($title),
        ];

        if (!File::exists($filePath)) {
            $fileContent = __DIR__ . "/stub/repository.stub";

            new CreateFile(
                $stubProperties,
                $repositoryNamespacePath,
                $fileContent
            );

            $this->info('Repository Created Successfully.');
            return true;
        } else {
            $this->error('Repository Already Exists.');
            return false;
        }
    }
}
