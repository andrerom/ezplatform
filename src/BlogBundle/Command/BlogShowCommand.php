<?php

namespace BlogBundle\Command;

use eZ\Publish\API\Repository\Values\Content\Query;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BlogShowCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:show')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_OPTIONAL, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');

        if ($input->getOption('option')) {
            $output->writeln("Option is: " . $input->getOption('option'), OutputInterface::VERBOSITY_VERBOSE);
        }


        $repo = $this->getContainer()->get('ezpublish.api.repository');
        $search = $repo->getSearchService();

        $query = new Query();
        $query->query = new Query\Criterion\FullText($argument);
        $query->filter = new Query\Criterion\LogicalAnd([
            new Query\Criterion\ContentTypeIdentifier('article'),
            new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE),
            //new Query\Criterion\ParentLocationId(2)
        ]);

        $query->sortClauses = [new Query\SortClause\DatePublished(Query::SORT_DESC)];


        $searchResult = $search->findContent($query);

        foreach ($searchResult->searchHits as $searchHit) {
            $output->writeln($searchHit->valueObject->getName());
        }

        $output->writeln("Searched for '{$argument}', found  {$searchResult->totalCount} items");
    }

}
