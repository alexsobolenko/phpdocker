<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ApiException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiController extends AbstractController
{
    /**
     * @param Throwable $exception
     * @param int $status
     * @param array $headers
     * @return Response
     */
    protected function errorResponse(Throwable $exception, int $status, array $headers = []): Response
    {
        if ($exception instanceof ApiException) {
            return $this->json($exception->toArray(), $status, $headers);
        }

        $data = [
            'message' => $exception->getMessage(),
        ];

        return $this->json($data, $status, $headers);
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    protected function gatherFormErrors(FormInterface $form): array
    {
        if (!$form->isSubmitted()) {
            $errors['message'] = 'Empty input';

            return $errors;
        }

        $errors = [];
        foreach ($form->getErrors(true) as $formError) {
            $path = $formError->getOrigin()->getName();
            $form = $formError->getOrigin();
            if (!$path && $form->isRoot()) {
                $errors[] = [
                    'propertyName' => null,
                    'message' => $formError->getMessage(),
                ];
            } else {
                while ($form->getParent() && !$form->getParent()->isRoot()) {
                    $form = $form->getParent();
                    $path = sprintf('%s.%s', $form->getName(), $path);
                }
                $errors[] = [
                    'propertyName' => $path,
                    'message' => $formError->getMessage(),
                ];
            }
        }

        return [
            'message' => 'Error validation request',
            'errors' => $errors,
        ];
    }

    /**
     * @param int $status
     * @param array $headers
     * @return Response
     */
    protected function emptyResponse(int $status = Response::HTTP_OK, array $headers = []): Response
    {
        return $this->json(null, $status, $headers);
    }

    /**
     * @param int $status
     * @param array $errors
     * @return Response
     */
    protected function apiErrorResponse(int $status, array $errors = []): Response
    {
        return $this->json($errors, $status);
    }
}
