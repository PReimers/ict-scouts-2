<?php

namespace AppBundle\Command;

use AppBundle\Entity\Postcode;
use AppBundle\Entity\Province;
use Doctrine\Common\Persistence\ObjectManager;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;


class PostcodeUpdateCommand extends ContainerAwareCommand
{
    /** @var SymfonyStyle $symfonyStyle */
    protected $symfonyStyle;

    /** @var ObjectManager $entityManager */
    protected $entityManager;

    protected $provinceRepository;
    protected $postcodeRepository;

    protected function configure()
    {
        $this
            ->setName('postcode:update')
            ->setDescription('Update postcodes via post.ch csv file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->symfonyStyle = new SymfonyStyle($input, $output);
        $this->symfonyStyle->title('Updating postcodes');

        $this->entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $this->provinceRepository = $this->entityManager->getRepository('AppBundle:Province');
        $this->postcodeRepository = $this->entityManager->getRepository('AppBundle:Postcode');

        $error = false;
        try {
            $finder = new Finder();
            $finder->files()->in(__DIR__.'/../../../app/Resources/data/Postcode/')->name('*.csv');

            if (count($finder) === 0) {
                $this->symfonyStyle->error( 'No CSV in app/Resources/data/Postcode/' );
                $error = true;
            }

            foreach ($finder AS $file) {
                $this->processFile($file);
            }
        } catch (\Exception $e) {
            throw $e;
        }

        if (!$error) {
            $this->symfonyStyle->success('Update finished');
        }
    }

    private function processFile(SplFileInfo $file)
    {
        try {
            $csvReader = Reader::createFromPath($file->getRealPath());
        } catch (\Exception $e) {
            throw $e;
        }

        $csvReader->setDelimiter(';');
        $csvReader->addFilter(
            function ($row)
            {
                switch ($row[0]) {
                    case '00':
                        // Info table
                        break;
                    case '01':
                        // Postcodes
                        /** @var Postcode $postcode */
                        $postcode = $this->postcodeRepository->find($row[1]);

                        // Update existing postcode
                        if ($postcode) {
                            $postcode->setPostcode($row[4]);
                            $postcode->setCity($row[7]);

                            /** @var Province $province */
                            $province = $postcode->getProvince();

                            // Province of postcode changed.
                            if ($province->getNameShort() !== $row[9]) {
                                $province->removePostcode($postcode);

                                /** @var Province $prov */
                                $province = $this->provinceRepository->findOneBy(['nameShort' => $row[9]]);

                                // Change Province if still in Switzerland.
                                if ($province) {
                                    $province->addPostcode($postcode);

                                    $this->entityManager->persist($province);
                                    $this->entityManager->persist($postcode->getProvince());
                                } else {
                                    $this->entityManager->remove($postcode);
                                }
                            }

                            $this->entityManager->persist($postcode);

                            // Create new zip.
                        } else {
                            /** @var Postcode $postcode */
                            $postcode = new Postcode($row[1], $row[4], $row[7]);

                            /** @var Province $province */
                            $province = $this->provinceRepository->findOneBy(['nameShort' => $row[9]]);

                            // Set province, if zip is in Switzerland.
                            if ($province) {
                                $province->addPostcode($postcode);
                                $this->entityManager->persist($province);
                            }
                        }

                        $this->symfonyStyle->writeln($postcode->getPostcode().' '.$postcode->getCity(). ($postcode->getProvince() ? ' ('.$postcode->getProvince()->getNameShort().')' : ''));
                        return true;
                        break;
                    case '02':
                        // Alternative names for zips
                        break;
                    case '03':
                        // Political villages
                        break;
                    case '04':
                        // Streets
                        break;
                    case '05':
                        // Alternative names for streets
                        break;
                    case '06':
                        // Building
                        break;
                    case '07':
                        // Alternative names for buildings
                        break;
                    case '08':
                        // Postman information for delivery
                        break;
                    case '12':
                        // Join table between building and political villages
                        break;
                }

                return false;
            }
        );

        $csvReader->fetchAll();

        $this->entityManager->flush();
    }

}
