<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\Api\Product\Purchase\DTO\PurchaseProductDto;
use App\Controller\ApiController;
use App\Entity\Product;
use App\Form\Product\PurchaseForm;
use App\Model\Payment\Factory\PaymentInfoModelFactory;
use App\Model\Payment\PaymentInfoModel;
use App\Service\Payment\PaymentProviderService;
use App\Validator\CouponCode\CouponCodeConstraint;
use App\Validator\TaxNumber\TaxNumberConstraint;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/api/product')]
class ProductController extends ApiController
{
    #[Route(path: '/{id}/{taxNumber?null}/{couponCode?null}', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Response(ref: PaymentInfoModel::class, response: 200, description: 'Возвращает информацию по оплате за продукт')]
    #[OA\Response(response: 400, description: 'Ошибка в параметрах запроса')]
    #[OA\Response(response: 404, description: 'Продукт не найден')]
    #[OA\Tag(name: 'Product')]
    public function getPaymentInfoAction(
        Product $product,
        ValidatorInterface $validator,
        PaymentInfoModelFactory $paymentInfoModelFactory,
        PaymentProviderService  $paymentProviderService,
        ?string $taxNumber = null,
        ?string $couponCode = null,
    ): Response {
        $errorMessages = [];
        $taxNumberErrors = $validator->validate($taxNumber, new TaxNumberConstraint());
        if ($taxNumberErrors->count() > 0) {
            foreach ($taxNumberErrors as $error) {
                $errorMessages[] = $error->getMessage();
            }
        }

        $couponCodeErrors = $validator->validate($couponCode, new CouponCodeConstraint());
        if ($couponCodeErrors->count() > 0) {
            foreach ($couponCodeErrors as $error) {
                $errorMessages[] = $error->getMessage();
            }
        }

        if (!empty($errorMessages)) {
            return $this->apiErrorResponse(Response::HTTP_BAD_REQUEST, $errorMessages);
        }

        $price = $paymentProviderService->calculatePrice($product->getPrice(), $taxNumber, $couponCode);
        $model = $paymentInfoModelFactory->fromParameters($product->getTitle(), $price);

        return $this->json($model);
    }

    #[Route(path: '/purchase', name: 'api.product.purchase.post', methods: ['POST'])]
    #[OA\Parameter(name: 'json', in: 'query', ref: PurchaseForm::class)]
    #[OA\Response(ref: PaymentInfoModel::class, response: 200, description: 'Покупка продукта прошла успешно')]
    #[OA\Response(response: 400, description: 'Указаны неверные параметры для покупки')]
    #[OA\Tag(name: 'Product')]
    public function purchaseAction(
        Request $request,
        PaymentProviderService $paymentProviderService,
        PaymentInfoModelFactory $paymentInfoModelFactory
    ): Response {
        $dto = new PurchaseProductDto();
        $form = $this->createForm(PurchaseForm::class, $dto);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            try {
                $price = $paymentProviderService->providePayment(
                    $data->getProduct(),
                    $data->getPaymentProcessor(),
                    $data->getTaxNumber(),
                    $data->getCouponCode(),
                );
                $product = $data->getProduct();
                $model = $paymentInfoModelFactory->fromParameters($product->getTitle(), $price);

                return $this->json($model);
            } catch (\Throwable $e) {
                return $this->errorResponse(
                    new \RuntimeException($e->getMessage(), $e->getCode(), $e),
                    Response::HTTP_BAD_REQUEST,
                );
            }
        }

        return $this->json($this->gatherFormErrors($form), Response::HTTP_BAD_REQUEST);
    }
}