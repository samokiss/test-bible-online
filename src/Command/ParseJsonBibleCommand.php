<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseJsonBibleCommand extends Command
{
    const BIBLE_JSON_DIR = __DIR__ . '/../../public/bible-json';

    protected static $defaultName = 'app:parse-bible';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach (scandir(self::BIBLE_JSON_DIR) as $file) {
            if (array_key_exists('extension', pathinfo($file)) && pathinfo($file)['extension'] === 'json') {
                $jsonData = file_get_contents(self::BIBLE_JSON_DIR . '/' . $file);
                var_dump(json_decode($jsonData, true));
            }
        }

        return Command::SUCCESS;
    }

    private function deleteBOM(): void
    {
        foreach (scandir(self::BIBLE_JSON_DIR) as $file) {
            if (array_key_exists('extension', pathinfo($file)) && pathinfo($file)['extension'] === 'json') {
                $jsonData = file_get_contents(self::BIBLE_JSON_DIR . '/' . $file);
                $jsonData = str_replace("\xEF\xBB\xBF",'',$jsonData);
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
