<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetByActivityRequest;
use App\Http\Requests\GetByBuildingRequest;
use App\Http\Requests\GetByNameRequest;
use App\Http\Requests\GetWithinRadiusRequest;
use App\Http\Requests\IndexOrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Info(title: 'Organization API', version: '1.0')]
#[OA\Server(url: '/api', description: 'API Server')]
#[OA\SecurityScheme(securityScheme: 'ApiKeyAuth', type: 'apiKey', in: 'header', name: 'X-API-KEY')]
#[OA\Tag(name: 'Organizations', description: 'Read-only доступ к организациям')]
class OrganizationController extends Controller
{
    public function __construct(
        protected readonly OrganizationService $service
    ) {
    }

    #[OA\Get(
        path: '/organizations',
        tags: ['Organizations'],
        summary: 'Список организаций (поиск по имени, зданию, виду деятельности)',
        security: [['ApiKeyAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'building_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'activity_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'name', in: 'query', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer', default: 15)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Organization'))),
        ]
    )]
    public function index(IndexOrganizationRequest $request): JsonResponse
    {
        $filters = $request->only(['building_id', 'activity_id', 'name']);
        $perPage = (int) $request->input('per_page', 15);
        $result = $this->service->getAll($filters, $perPage);

        return response()->json(OrganizationResource::collection($result));
    }

    #[OA\Get(
        path: '/organizations/{id}',
        tags: ['Organizations'],
        summary: 'Получить организацию по ID',
        security: [['ApiKeyAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK', content: new OA\JsonContent(ref: '#/components/schemas/Organization')),
            new OA\Response(response: 404, description: 'Не найдено'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        return response()->json(new OrganizationResource($this->service->find($id)));
    }

    #[OA\Get(
        path: '/organizations/activity/{activityId}',
        tags: ['Organizations'],
        summary: 'Поиск по виду деятельности (с учетом вложенности до 3 уровней)',
        security: [['ApiKeyAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'activityId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer', default: 15)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Organization'))),
        ]
    )]
    public function getByActivity(GetByActivityRequest $request, int $activityId): JsonResponse
    {
        $filters = ['activity_id' => $activityId];

        $result = $this->service->getAll($filters, $request->input('per_page', 15));

        return response()->json(OrganizationResource::collection($result));
    }

    #[OA\Get(
        path: '/organizations/building/{buildingId}',
        tags: ['Organizations'],
        summary: 'Организации в здании',
        security: [['ApiKeyAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'buildingId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer', default: 15)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Organization'))),
        ]
    )]
    public function getByBuilding(GetByBuildingRequest $request, int $buildingId): JsonResponse
    {
        $result = $this->service->getAll(
            ['building_id' => $buildingId],
            $request->input('per_page', 15)
        );

        return response()->json(OrganizationResource::collection($result));
    }

    #[OA\Get(
        path: '/organizations/search-by-name',
        tags: ['Organizations'],
        summary: 'Поиск по названию организации',
        security: [['ApiKeyAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'name', in: 'query', required: true, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer', default: 15)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Organization'))),
        ]
    )]
    public function getByName(GetByNameRequest $request): JsonResponse
    {
        $result = $this->service->getAll(
            ['name' => $request->validated()['name']],
            $request->input('per_page', 15)
        );

        return response()->json(OrganizationResource::collection($result));
    }

    #[OA\Get(
        path: '/organizations/within-radius',
        tags: ['Organizations'],
        summary: 'Поиск организаций в радиусе координат',
        security: [['ApiKeyAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'latitude', in: 'query', required: true, schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'longitude', in: 'query', required: true, schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'radius', in: 'query', required: true, schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer', default: 15)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Organization'))),
        ]
    )]
    public function getWithinRadius(GetWithinRadiusRequest $request): JsonResponse
    {
        $v = $request->validated();
        $result = $this->service->searchWithinRadius(
            $v['latitude'],
            $v['longitude'],
            $v['radius'],
            $request->input('per_page', 15)
        );

        return response()->json(OrganizationResource::collection($result));
    }
}
