<?php

declare(strict_types=1);

use App\Controller\RecipeController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RecipeControllerTest extends TestCase
{
    public function testListAction()
    {
        $controller = new RecipeController();
        $response = $controller->listAction(new Request());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateAction()
    {
        $controller = new RecipeController();
        $response = $controller->createAction(new Request());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testGetAction()
    {
        $controller = new RecipeController();
        $response = $controller->getAction(new Request(), '1');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateAction()
    {
        $controller = new RecipeController();
        $response = $controller->updateAction(new Request(), '1');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteAction()
    {
        $controller = new RecipeController();
        $response = $controller->deleteAction(new Request(), '1');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRateAction()
    {
        $controller = new RecipeController();
        $response = $controller->rateAction(new Request(), '1');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testSearchAction()
    {
        $controller = new RecipeController();
        $response = $controller->searchAction(new Request());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
