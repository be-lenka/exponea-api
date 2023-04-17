<?php

namespace belenka\ExponeaApi\Catalog;

use stdClass;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use belenka\ExponeaApi\Exception\Internal\MissingResponseFieldException;
use belenka\ExponeaApi\Exception\UnexpectedResponseSchemaException;
use belenka\ExponeaApi\Interfaces\CatalogInterface;
use belenka\ExponeaApi\Interfaces\CatalogItemInterface;
use belenka\ExponeaApi\Interfaces\CreateCatalogInterface;
use belenka\ExponeaApi\Traits\ApiContainerTrait;
use belenka\ExponeaApi\Catalog\Response\CatalogName;
use belenka\ExponeaApi\Catalog\Response\CatalogItem;
use belenka\ExponeaApi\Catalog\Response\CatalogItems;
use belenka\ExponeaApi\Catalog\Response\CreateCatalog;
use belenka\ExponeaApi\Catalog\Response\AllCatalogs;

/**
 * Methods contained inside Catalog API
 * @package belenka\ExponeaApi\Catalog
 */
class Methods
{
    use ApiContainerTrait;

    protected function getMethodUri(string $method): string
    {
        return '/data/v2/projects/' . $this->getClient()->getProjectToken() . $method;
    }

    /**
     * Get all catalogs
     *
     * Promise resolves to Response\AllCatalogs object
     * @return PromiseInterface
     */
    public function getAllCatalogs(): PromiseInterface
    {
        $request = new Request(
            'GET',
            '/data/v2/projects/{projectToken}/catalogs'
        );
        return $this->getClient()->call($request)->then(function (ResponseInterface $response) use ($request) {
            try {
                return new AllCatalogs(json_decode($response->getBody()->getContents(), true));
            } catch (MissingResponseFieldException $e) {
                throw new UnexpectedResponseSchemaException(
                    $e->getMessage(),
                    $request,
                    $response,
                    $e
                );
            }
        });
    }

    /**
     * Get catalog name
     *
     * Promise resolves to Response\CatalogName object
     * @param CatalogInterface $catalog
     * @return PromiseInterface
     */
    public function getCatalogName(CatalogInterface $catalog): PromiseInterface
    {
        $request = new Request(
            'GET',
            '/data/v2/projects/{projectToken}/catalogs/' . $catalog->getID()
        );
        return $this->getClient()->call($request)->then(function (ResponseInterface $response) use ($request) {
            try {
                return new CatalogName(json_decode($response->getBody()->getContents(), true));
            } catch (MissingResponseFieldException $e) {
                throw new UnexpectedResponseSchemaException(
                    $e->getMessage(),
                    $request,
                    $response,
                    $e
                );
            }
        });
    }

    /**
     * Get catalog items
     *
     * Promise resolves to Response\CatalogName object
     * @param CatalogInterface $catalog
     * @return PromiseInterface
     */
    public function getCatalogItems(CatalogInterface $catalog): PromiseInterface
    {
        $request = new Request(
            'GET',
            '/data/v2/projects/{projectToken}/catalogs/' . $catalog->getID() . '/items?' . http_build_query($catalog->getQueryParameters())
        );
        return $this->getClient()->call($request)->then(function (ResponseInterface $response) use ($request) {
            try {
                return new CatalogItems(json_decode($response->getBody()->getContents(), true));
            } catch (MissingResponseFieldException $e) {
                throw new UnexpectedResponseSchemaException(
                    $e->getMessage(),
                    $request,
                    $response,
                    $e
                );
            }
        });
    }

    /**
     * Get catalog items
     *
     * Promise resolves to Response\CatalogItem object
     * @param CatalogInterface $catalog
     * @return PromiseInterface
     */
    public function getCatalogItem(CatalogInterface $catalog): PromiseInterface
    {
        $request = new Request(
            'GET',
            '/data/v2/projects/{projectToken}/catalogs/' . implode('/', [
                $catalog->getID(),
                'items',
                $catalog->getItemID()
            ]). '?' . http_build_query($catalog->getQueryParameters())
        );
        return $this->getClient()->call($request)->then(function (ResponseInterface $response) use ($request) {
            try {
                return new CatalogItem(json_decode($response->getBody()->getContents(), true));
            } catch (MissingResponseFieldException $e) {
                throw new UnexpectedResponseSchemaException(
                    $e->getMessage(),
                    $request,
                    $response,
                    $e
                );
            }
        });
    }

    /**
     * Create catalog
     *
     * Promise resolves to Response\CreateCatalog object
     * @param CreateCatalogInterface $catalog
     * @return PromiseInterface
     */
    public function createCatalog(CreateCatalogInterface $catalog): PromiseInterface
    {
        $request = new Request(
            'POST',
            '/data/v2/projects/{projectToken}/catalogs',
            [],
            json_encode($catalog) ?: '{}'
        );
        
        return $this->getClient()->call($request)->then(function (ResponseInterface $response) use ($request) {
            try {
                return new CreateCatalog(json_decode($response->getBody()->getContents(), true));
            } catch (MissingResponseFieldException $e) {
                throw new UnexpectedResponseSchemaException(
                    $e->getMessage(),
                    $request,
                    $response,
                    $e
                );
            }
        });
    }

    /**
     * Create catalog item
     *
     * Promise resolves to Response\CatalogItem object
     * @param CatalogInterface $catalogItem
     * @return PromiseInterface
     */
    public function createCatalogItem(CatalogItemInterface $catalogItem): PromiseInterface
    {
        $request = new Request(
            'PUT',
            '/data/v2/projects/{projectToken}/catalogs/' . implode('/', [
                $catalogItem->getCatalogID(),
                'items',
                $catalogItem->getID()
            ]),
            [],
            json_encode($catalogItem) ?: '{}'
        );
        
        return $this->getClient()->call($request)->then(function ($e) {
            return $e->getStatusCode() == 200;
        });
    }

    /**
     * Catalog item - Partial update
     * 
     * @param CatalogItemInterface $catalogItem
     * @return PromiseInterface
     */
    public function updateCatalogItem(CatalogItemInterface $catalogItem)
    {
        $request = new Request(
            'POST',
            '/data/v2/projects/{projectToken}/catalogs/' . implode('/', [
                $catalogItem->getCatalogID(),
                'items',
                $catalogItem->getID(),
                'partial-update'
            ]),
            [],
            json_encode($catalogItem) ?: '{}'
        );
        
        return $this->getClient()->call($request)->then(function ($e) {
            return $e->getStatusCode() == 200;
        });
    }
}
