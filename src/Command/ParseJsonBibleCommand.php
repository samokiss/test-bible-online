<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\Chapter;
use App\Entity\Testament;
use App\Entity\Verse;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ParseJsonBibleCommand extends Command
{
    const BIBLE_JSON_DIR = __DIR__ . '/../../public/bible-json';


    protected static $defaultName = 'app:parse-bible';

    private $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->container->get('doctrine');
        foreach (scandir(self::BIBLE_JSON_DIR) as $file) {
            if (array_key_exists('extension', pathinfo($file)) && pathinfo($file)['extension'] === 'json') {
                $jsonData = file_get_contents(self::BIBLE_JSON_DIR . '/' . $file);
                $data = json_decode($jsonData, true);
                $testaments = $data['Testaments'];
                foreach ($testaments as $key => $testament) {
                    $__testament = $em->getRepository(Testament::class)->findOneBy(['name' => $testament['Text']]) ?? new Testament();
                    if ($__testament instanceof Testament && $__testament->getId() === null) {
                        $__testament->setName($testament['Text']);
                        $em->getManager()->persist($__testament);
                    }
                    foreach ($testament['Books'] as $book) {
                        $__book = $em->getRepository(Book::class)->findOneBy(['name' => $book['Text'], 'testament' => $__testament]) ?? new Book();
                        if ($__book instanceof Book && $__book->getId() === null) {
                            $__book->setName($book['Text'])
                                ->setTestament($__testament);
                            $em->getManager()->persist($__book);
                        }
                        foreach ($book['Chapters'] as $c => $chapter) {
                            $__chapter = $em->getRepository(Chapter::class)->findOneBy(['name' => $c, 'book' => $__book]) ?? new Chapter();
                            if ($__chapter instanceof Chapter && $__chapter->getId() === null) {
                                $__chapter->setName($c)
                                    ->setNumber($c + 1)
                                    ->setBook($__book);
                                $em->getManager()->persist($__chapter);
                            }
                            foreach ($chapter['Verses'] as $v => $verse) {
                                $__verse = $em->getRepository(Verse::class)->findOneBy(['content' => $verse['Text'], 'chapterr' => $__chapter]) ?? new Verse();
                                if ($__verse instanceof Verse && $__verse->getId() === null) {
                                    $__verse->setContent($verse['Text'])
                                        ->setChapterr($__chapter)
                                        ->setNumber($v + 1);
                                    $em->getManager()->persist($__verse);
                                }
                            }
                            $em->getManager()->flush();
                        }
                    }
                }
            }
        }

        return Command::SUCCESS;
    }

    private function deleteBOM(): void
    {
        foreach (scandir(self::BIBLE_JSON_DIR) as $file) {
            if (array_key_exists('extension', pathinfo($file)) && pathinfo($file)['extension'] === 'json') {
                $jsonData = file_get_contents(self::BIBLE_JSON_DIR . '/' . $file);
                $jsonData = str_replace("\xEF\xBB\xBF", '', $jsonData);
                $newFile = fopen(self::BIBLE_JSON_DIR . '/' . $file, 'w');
                fwrite($newFile, $jsonData);
                fclose($newFile);
            }
        }
    }

    private function deleteLineBreak(): void
    {
        foreach (scandir(self::BIBLE_JSON_DIR) as $file) {
            if (array_key_exists('extension', pathinfo($file)) && pathinfo($file)['extension'] === 'json') {
                $json = file_get_contents(self::BIBLE_JSON_DIR . '/' . $file);
                $data = str_replace("\n", " ", $json);
                $newFile = fopen(self::BIBLE_JSON_DIR . '/' . $file, 'w');
                fwrite($newFile, $data);
                fclose($newFile);
            }
        }
    }

    private function fixKeyInJsonFile($file): void
    {
        $search = [
            'UseCurrentLanguage:',
            'Abbreviation:',
            'Language:',
            'Introduction:',
            'Source:',
            'VersionDate:',
            'IsCompressed:',
            'IsProtected:',
            'UseCurrentLanguage:',
            'Guid:',
            'Testaments:',
            'Books:',
            'Chapters:',
            'Verses:',
            'Text:',
            'ID:',
            'Description:',
            'Copyright:',
            'Style:',
            'Body:',
            'TextAlignment:',
            'Publisher:',
        ];

        $replace = [
            '"UseCurrentLanguage":',
            '"Abbreviation":',
            '"Language":',
            '"Introduction":',
            '"Source":',
            '"VersionDate":',
            '"IsCompressed":',
            '"IsProtected":',
            '"UseCurrentLanguage":',
            '"Guid":',
            '"Testaments":',
            '"Books":',
            '"Chapters":',
            '"Verses":',
            '"Text":',
            '"ID":',
            '"Description":',
            '"Copyright":',
            '"Style":',
            '"Body":',
            '"TextAlignment":',
            '"Publisher":',
        ];

        $json = file_get_contents(self::BIBLE_JSON_DIR . '/' . $file);
        $data = str_replace($search, $replace, $json);
        $newFile = fopen(self::BIBLE_JSON_DIR . '/' . $file, 'w');
        fwrite($newFile, $data);
        fclose($newFile);
    }
}
