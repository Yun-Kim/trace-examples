<?php

namespace App\Http\Controllers;

use App\Custom\AddTen;
use App\Custom\MultiplyByTwo;
use Illuminate\Http\Response;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    public function pipelineAction()
    {
        $pipes = [
            new AddTen(),
            new MultiplyByTwo(),
        ];

        /** @var Pipeline $pipeline */
        $pipeline = App::make(Pipeline::class);

        $pipeline
            ->send(10)
            ->through($pipes)
            ->then(function ($result) {
                echo "Final result of (10 + 10) * 2 is $result\n";
            });
        return new Response();
    }

    public function pdoAction()
    {
        $pdo = new \PDO('mysql:host=mysql;dbname=test', 'test', 'test');
        $stmt = $pdo->prepare("SELECT * from information_schema.tables LIMIT 1");
        $stmt->execute();
        $res = $stmt->fetch();
        return new Response();
    }
}
