<?php

namespace App\Component\ElasticSearch\Indexer;

use App\Component\ElasticSearch\Converter;
use App\Component\ElasticSearch\Model\FullAccountModel;
use App\Component\ElasticSearch\Model\FullProductModel;
use App\Component\ElasticSearch\Model\ProductModel;
use App\Entity\Account;
use App\Repository\AccountRepository;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Configuration\ConfigManager;
use FOS\ElasticaBundle\Configuration\IndexConfig;
use FOS\ElasticaBundle\Elastica\Index;
use FOS\ElasticaBundle\Index\AliasProcessor;
use FOS\ElasticaBundle\Index\MappingBuilder;

class Indexer
{
    private const DATE_FORMAT = 'Y_m_d_H_i_s';
    private const INDEX_NAME_PATTERN = '%s_%s';

    public function __construct(
        protected readonly string                 $accountAlias,
        protected readonly string                 $productAlias,
        protected readonly ConfigManager          $configManager,
        protected readonly MappingBuilder         $mappingBuilder,
        protected readonly Index                  $accountIndex,
        protected readonly Index                  $productIndex,
        protected readonly EntityManagerInterface $entityManager,
        private readonly Converter                $converter,
        protected readonly AliasProcessor         $aliasProcessor,
    )
    {

    }

    public function indexCreate(DateTimeInterface $now): array
    {
        $indexes = [];

        foreach ($this->getAvailableIndexes() as $index) {
            $newIndexName = $this->generate($index, $now);

            $fosIndex = $this->getIndex($index);
            $fosIndex->overrideName($newIndexName);

            $configurationIndexName = $this->getIndexConfigurationKey($index);
            $indexConfig = $this->configManager->getIndexConfiguration($configurationIndexName);
            $mapping = $this->mappingBuilder->buildIndexMapping($indexConfig);

            $fosIndex->create($mapping);

            $indexes[$configurationIndexName] = $fosIndex;
        }

        return $indexes;
    }

    public function indexAll(Index $accountIndex, Index $productIndex): void
    {
        /** @var AccountRepository $repository */
        $repository = $this->entityManager->getRepository(Account::class);
        $max = $repository->getMaxId();

        $batchSize = 20;
        $idList = [];

        for ($i = 1; $i <= $max; ++$i) {

            $idList[] = $i;
            if (($i % $batchSize) === 0) {
                $this->index($accountIndex, $productIndex, $idList);
                $this->entityManager->clear();
                $idList = [];
            }
        }
        $this->index($accountIndex, $productIndex, $idList);
        $this->entityManager->clear();
    }

    public function index(Index $accountIndex, Index $productIndex, array $idList): void
    {
        if (!$idList) {
            return;
        }

        $accountsEntities = $this->entityManager->getRepository(Account::class)->findByIdList($idList);
        if (!$accountsEntities) {
            return;
        }

        $fullAccountsModels = [];
        foreach ($accountsEntities as $accountsEntity) {
            $fullAccountsModels[] = $this->converter->entityToModel($accountsEntity);
        }

        $fullAccountsDocuments = [];
        $fullProductsDocuments = [];
        /** @var FullAccountModel $fullAccountsModel */
        foreach ($fullAccountsModels as $fullAccountsModel) {
            $fullAccountsDocuments[] = new Document($fullAccountsModel->getId(), $fullAccountsModel->toArray());
            /** @var ProductModel $product */
            foreach ($fullAccountsModel->getProducts() as $product) {
                $fullProductsDocuments[] = new Document(
                    $product->getId(),
                    (new FullProductModel($product, $fullAccountsModel->getAccount()))->toArray()
                );
            }
        }
        $accountIndex->addDocuments($fullAccountsDocuments);
        $productIndex->addDocuments($fullProductsDocuments);
    }

    private function generate(string $indexName, DateTimeInterface $timestamp): string
    {
        return sprintf(self::INDEX_NAME_PATTERN, $indexName, $timestamp->format(self::DATE_FORMAT));
    }

    private function getAvailableIndexes(): array
    {
        return [
            $this->productAlias,
            $this->accountAlias,
        ];
    }

    private function getIndex(string $index): Index
    {
        return match ($index) {
            $this->productAlias => clone $this->productIndex,
            $this->accountAlias => clone $this->accountIndex,
            default => throw new \RuntimeException('Invalid model name "' . $index . '" provided'),
        };
    }

    private function getIndexConfigurationKey(string $index): string
    {
        return match ($index) {
            $this->productAlias => 'products',
            $this->accountAlias => 'accounts',
            default => throw new \RuntimeException('Invalid index name "' . $index . '" provided'),
        };
    }

    public function indexSwitch(DateTimeInterface $now): void
    {
        foreach ($this->getAvailableIndexes() as $index) {
            $newIndexName = $this->generate($index, $now);

            $fosIndex = $this->getIndex($index);
            $fosIndex->overrideName($newIndexName);

            $configurationIndexName = $this->getIndexConfigurationKey($index);
            $indexConfig = $this->configManager->getIndexConfiguration($configurationIndexName);

            if (!$indexConfig instanceof IndexConfig) {
                throw new \InvalidArgumentException('Invalid index configuration');
            }

            $this->aliasProcessor->switchIndexAlias(
                indexConfig: $indexConfig,
                index: $fosIndex,
                force: true,
                delete: true
            );
        }
    }

}
