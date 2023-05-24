<?php

namespace App\Controller;

use App\Repository\TestUserRepository;
use App\Validation\DTO\UserParamDTO;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * Find users by `is_active`, `is_member`, `last_login_at` (range), `user_type` (multiple values)
     */
    #[Route('/api/users', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns a list of users matches the criteria',
    )]
    #[OA\Response(
        response: 400,
        description: 'Bad request, query parameters cannot be denormalized',
    )]
    #[OA\Parameter(
        name: 'isActive',
        description: 'User active status',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'tinyint'),
    )]
    #[OA\Parameter(
        name: 'isMember',
        description: 'User member status',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'tinyint'),
    )]
    #[OA\Parameter(
        name: 'userTypes[]',
        description: 'List of user types',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'integer')),
    )]
    #[OA\Parameter(
        name: 'lastLoginAt',
        description: 'range of user last login',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'object', properties: [new OA\Property(property: 'lastLoginAt[start]', type: 'date'), new OA\Property(property: 'lastLoginAt[end]', type: 'date')]),
    )]
    public function users(Request $request, TestUserRepository $testUserRepository, SerializerInterface $serializer): JsonResponse|BadRequestHttpException
    {
        try {
            $params = $request->query->all();
            /** @var UserParamDTO $paramDTO */
            $paramDTO = $serializer->deserialize(json_encode($params), UserParamDTO::class, 'json');

            $users = $testUserRepository->findUsersByCriterias(
                isActive: $paramDTO->getIsActive()?->getValue(),
                isMember: $paramDTO?->getIsMember()?->getValue(),
                lastLoginAtStart: $paramDTO->getLastLoginAt()?->getValue()['start'],
                lastLoginAtEnd: $paramDTO->getLastLoginAt()?->getValue()['end'],
                userTypes: $paramDTO->getUserTypes()?->getValue(),
            );

            $usersSerialized = $serializer->serialize(
                $users,
                'json',
                (new ObjectNormalizerContextBuilder())
                    ->withGroups('user')
                    ->toArray(),
            );

            return $this->json(\json_decode($usersSerialized, associative: true));
        } catch (\Exception $e) {
            throw new BadRequestHttpException(message: $e->getMessage());
        }
    }
}