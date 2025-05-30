<?php

/**
 * An array consisting of implementations of middlewares for a middleware stack to be registered
 *
 * ```
 *  'stackname' => [
 *      'middleware-identifier' => [
 *         'target' => classname or callable
 *         'before/after' => array of dependencies
 *      ]
 *   ]
 * ```
 */
return [
    'backend' => [
        /** internal: do not use or reference this middleware in your own code */
        'typo3/cms-core/normalized-params-attribute' => [
            'target' => \TYPO3\CMS\Core\Middleware\NormalizedParamsAttribute::class,
        ],
        'typo3/cms-backend/locked-backend' => [
            'target' => \TYPO3\CMS\Backend\Middleware\LockedBackendGuard::class,
            'after' => [
                'typo3/cms-core/normalized-params-attribute',
            ],
        ],
        'typo3/cms-backend/https-redirector' => [
            'target' => \TYPO3\CMS\Backend\Middleware\ForcedHttpsBackendRedirector::class,
            'after' => [
                'typo3/cms-core/normalized-params-attribute',
                'typo3/cms-backend/locked-backend',
            ],
        ],
        'typo3/cms-backend/csp-report' => [
            'target' => \TYPO3\CMS\Backend\Middleware\ContentSecurityPolicyReporter::class,
            'after' => [
                'typo3/cms-core/normalized-params-attribute',
                'typo3/cms-backend/https-redirector',
            ],
            'before' => [
                'typo3/cms-backend/backend-routing',
            ],
        ],
        'typo3/cms-backend/backend-routing' => [
            'target' => \TYPO3\CMS\Backend\Middleware\BackendRouteInitialization::class,
            'after' => [
                'typo3/cms-backend/https-redirector',
            ],
        ],
        'typo3/cms-core/request-token-middleware' => [
            'target' => \TYPO3\CMS\Core\Middleware\RequestTokenMiddleware::class,
            'after' => [
                'typo3/cms-backend/backend-routing',
            ],
            'before' => [
                'typo3/cms-backend/authentication',
            ],
        ],
        'typo3/cms-backend/authentication' => [
            'target' => \TYPO3\CMS\Backend\Middleware\BackendUserAuthenticator::class,
            'after' => [
                'typo3/cms-backend/backend-routing',
            ],
        ],
        'typo3/cms-backend/backend-module-validator' => [
            'target' => \TYPO3\CMS\Backend\Middleware\BackendModuleValidator::class,
            'after' => [
                'typo3/cms-backend/authentication',
            ],
        ],
        'typo3/cms-backend/sudo-mode-interceptor' => [
            'target' => \TYPO3\CMS\Backend\Middleware\SudoModeInterceptor::class,
            'after' => [
                'typo3/cms-backend/backend-module-validator',
            ],
        ],
        'typo3/cms-backend/site-resolver' => [
            'target' => \TYPO3\CMS\Backend\Middleware\SiteResolver::class,
            'after' => [
                'typo3/cms-backend/sudo-mode-interceptor',
            ],
        ],
        /** internal: do not use or reference this middleware in your own code */
        'typo3/cms-backend/output-compression' => [
            'target' => \TYPO3\CMS\Backend\Middleware\OutputCompression::class,
            'after' => [
                'typo3/cms-backend/authentication',
            ],
        ],
        /** internal: do not use or reference this middleware in your own code */
        'typo3/cms-backend/csp-headers' => [
            'target' => \TYPO3\CMS\Backend\Middleware\ContentSecurityPolicyHeaders::class,
            'after' => [
                'typo3/cms-backend/output-compression',
            ],
        ],
        /** internal: do not use or reference this middleware in your own code */
        'typo3/cms-backend/response-headers' => [
            'target' => \TYPO3\CMS\Backend\Middleware\AdditionalResponseHeaders::class,
            'after' => [
                'typo3/cms-backend/csp-headers',
            ],
        ],
        /** internal: do not use or reference this middleware in your own code */
        'typo3/cms-core/response-propagation' => [
            'target' => \TYPO3\CMS\Core\Middleware\ResponsePropagation::class,
            'after' => [
                'typo3/cms-backend/response-headers',
            ],
        ],
    ],
];
