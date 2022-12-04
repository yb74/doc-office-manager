<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\OpenApi;

class OpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(private OpenApiFactoryInterface $decorated) {

    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this-> decorated->__invoke($context);
        /** @var PathItem $path */
        foreach($openApi->getPaths()->getPaths() as $key => $path) {
            if ($path->getGet() && $path->getGet()->getSummary() == "hidden") {
                $openApi->getPaths()->addPath($key, $path->withGet(null));
            };
        }

        $schemas = $openApi->getComponents()->getSecuritySchemes();
        $schemas['cookieAuth'] = new \ArrayObject([
            'type' => 'apiKey',
            'in' => 'cookie',
            'name' => 'PHPSESSID'
        ]);
        // $openApi = $openApi->withSecurity(['cookieAuth' => []]);

        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Credentials'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'myLogin1',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'myPassword1',
                ]
            ]
        ]);

        $pathItem = new PathItem(
            post: new Operation(
                operationId: 'postApiLogin',
                tags: ['Auth'],
                responses: [
                    '200' => [
                        'description' => 'Utilisateur Connecté',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/User-read.user'
                                ]
                            ]
                        ]
                    ]
                ],
                requestBody: new RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials'
                            ]
                        ]
                    ])
                )
            )
        );

        $openApi->getPaths()->addPath('/api/login', $pathItem);


        $pathItem = new PathItem(
            post: new Operation(
                operationId: 'postApiLogout',
                tags: ['Auth'],
                responses: [
                    '204' => []
                ],
            )
        );

        $openApi->getPaths()->addPath('/logout', $pathItem);

        return $openApi;
    }
}
