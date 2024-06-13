<?php

namespace App\UI\REST;

use App\Application\Command\CreateCustomerCommand;
use App\Application\Command\UpdateCustomerCommand;
use App\Application\Handler\CreateCustomerHandler;
use App\Application\Handler\UpdateCustomerHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController
{
    private CreateCustomerHandler $createCustomerHandler;
    private UpdateCustomerHandler $updateCustomerHandler;

    public function __construct(
        CreateCustomerHandler $createCustomerHandler,
        UpdateCustomerHandler $updateCustomerHandler
    ) {
        $this->createCustomerHandler = $createCustomerHandler;
        $this->updateCustomerHandler = $updateCustomerHandler;
    }

    /**
     * @Route("/customers", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $command = new CreateCustomerCommand(
            $data['ssn'],
            $data['firstName'],
            $data['lastName'],
            $data['age'],
            $data['city'],
            $data['state'],
            $data['zipCode'],
            $data['fico'],
            $data['email'],
            $data['phoneNumber']
        );

        $this->createCustomerHandler->handle($command);

        return new JsonResponse(['status' => 'Customer created'], 201);
    }

    /**
     * @Route("/customers/{ssn}", methods={"PUT"})
     */
    public function update(string $ssn, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new UpdateCustomerCommand(
            $ssn,
            $data['firstName'],
            $data['lastName'],
            $data['age'],
            $data['city'],
            $data['state'],
            $data['zipCode'],
            $data['fico'],
            $data['email'],
            $data['phoneNumber']
        );

        $this->updateCustomerHandler->handle($command);

        return new JsonResponse(['status' => 'Customer updated'], 200);
    }
}