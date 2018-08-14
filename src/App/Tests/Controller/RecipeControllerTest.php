<?php

declare(strict_types=1);

use App\Controller\RecipeController;
use App\Service\RecipeManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RecipeControllerTest extends TestCase
{
    /**
     * @var RecipeController
     */
    private $recipeController;

    /**
     * @var MockObject
     */
    private $recipeManagerMock;

    public function setUp()
    {
        $this->recipeManagerMock = $this->createMock(RecipeManager::class);

        $this->recipeController = new RecipeController(
            $this->recipeManagerMock
        );
    }

    public function testListAction()
    {
        $response = $this->recipeController->listAction(new Request());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetAction()
    {
        $this->expectException(\Ramsey\Uuid\Exception\InvalidUuidStringException::class);
        $this->recipeController->getAction('1');

        $response = $this->recipeController->getAction((string) Uuid::uuid4());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @dataProvider requestDataProvider
     */
    public function testCreateAction($requestData, $shouldBeSuccessful, $detail)
    {
        if (!$shouldBeSuccessful) {
            $this->expectException(\Symfony\Component\HttpKernel\Exception\BadRequestHttpException::class);
            $this->expectExceptionMessage($detail);
        }

        $response = $this->recipeController->createAction(
            new Request([], $requestData)
        );

        if ($shouldBeSuccessful) {
            $this->assertInstanceOf(JsonResponse::class, $response);
            $this->assertEquals(201, $response->getStatusCode());
        }
    }

    public function testUpdateActionInvalidId()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\BadRequestHttpException::class);
        $this->expectExceptionMessage('[id] This is not a valid UUID');

        $this->recipeController->updateAction(
            new Request([], []),
            '1111'
        );
    }

    /**
     * @dataProvider requestDataProvider
     */
    public function testUpdateAction($requestData, $shouldBeSuccessful, $detail)
    {
        if (!$shouldBeSuccessful) {
            $this->expectException(\Symfony\Component\HttpKernel\Exception\BadRequestHttpException::class);
            $this->expectExceptionMessage($detail);
        }

        $response = $this->recipeController->updateAction(
            new Request([], $requestData),
            (string) Uuid::uuid4()
        );

        if ($shouldBeSuccessful) {
            $this->assertInstanceOf(JsonResponse::class, $response);
            $this->assertEquals(204, $response->getStatusCode());
        }
    }

    public function testDeleteAction()
    {
        $this->expectException(\Ramsey\Uuid\Exception\InvalidUuidStringException::class);
        $this->recipeController->deleteAction('1');

        $response = $this->recipeController->deleteAction((string) Uuid::uuid4());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testRateActionInvalidId()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\BadRequestHttpException::class);
        $this->expectExceptionMessage('[id] This is not a valid UUID');
        $this->recipeController->rateAction(new Request(), '1');
    }

    public function testRateActionInvalidRequest()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\BadRequestHttpException::class);
        $this->expectExceptionMessage('[rate] This field is missing');

        $this->recipeController->rateAction(new Request(), (string) Uuid::uuid4());
    }

    public function testRateActionValidRequest()
    {
        $response = $this->recipeController->rateAction(new Request([], ['rate' => 5]), (string) Uuid::uuid4());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testSearchAction()
    {
        $response = $this->recipeController->searchAction(new Request());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function requestDataProvider()
    {
        return [
            [['name' => 'name', 'prep_time' => 10, 'difficulty' => 1, 'vegetarian' => false], true, null],
            [['prep_time' => 10, 'difficulty' => 1, 'vegetarian' => false], false, '[name] This field is missing'],
            [['name' => 'name', 'difficulty' => 1, 'vegetarian' => false], false, '[prep_time] This field is missing'],
            [['name' => 'name', 'prep_time' => 10, 'vegetarian' => false], false, '[difficulty] This field is missing'],
            [['name' => 'name', 'prep_time' => 10, 'difficulty' => 1], false, '[vegetarian] This field is missing'],
        ];
    }
}
