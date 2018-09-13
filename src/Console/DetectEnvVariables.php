<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <ngugiwjames@gmail.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Console;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class DetectEnvVariables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'detect:env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all usages of the env function in the code';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $results = $this->findTranslations();

        $this->info("Found " . count($results) . " usages so far.");

        $file = base_path('.env.required');

        file_put_contents($file, implode("\n", $results));

        $this->info("All usages stored in " . $file);
    }

    /**
     * @param null $path
     * @return array
     */
    public function findTranslations($path = null)
    {
        $path = $path ?: base_path();
        $groupKeys = array();
        $stringKeys = array();
        $functions = array('env',);

        $groupPattern =                              // See http://regexr.com/392hu
            "[^\w|>]" .                          // Must not have an alphanum or _ or > before real method
            "(" . implode('|', $functions) . ")" .  // Must start with one of the functions
            "\(" .                               // Match opening parenthesis
            "[\'\"]" .                           // Match " or '
            "(" .                                // Start a new group to match:
            "[a-zA-Z0-9_-]+" .               // Must start with group
            "([.|\/][^\1)]+)+" .             // Be followed by one or more items/keys
            ")" .                                // Close group
            "[\'\"]" .                           // Closing quote
            "[\),]";                            // Close parentheses or new parameter

        $stringPattern =
            "[^\w|>]" .                                     // Must not have an alphanum or _ or > before real method
            "(" . implode('|', $functions) . ")" .             // Must start with one of the functions
            "\(" .                                          // Match opening parenthesis
            "(?P<quote>['\"])" .                            // Match " or ' and store in {quote}
            "(?P<string>(?:\\\k{quote}|(?!\k{quote}).)*)" . // Match any string that can be {quote} escaped
            "\k{quote}" .                                   // Match " or ' previously matched
            "[\),]";                                       // Close parentheses or new parameter

        // Find all PHP + Twig files in the app folder, except for storage
        $finder = new Finder();
        $finder->in($path)->exclude('storage')->name('*.php')->name('*.twig')->files();

        /** @var \Symfony\Component\Finder\SplFileInfo $file */
        foreach ($finder as $file) {

            // Search the current file for the pattern
            if (preg_match_all("/$stringPattern/siU", $file->getContents(), $matches)) {

                //if this file has a match, record it
                if (count($matches['string'])) {
                    $stringKeys[] = "\n\n# $file";
                }

                foreach ($matches['string'] as $key) {
                    $stringKeys[] = $key . "=";
                }
            }

        }
        // Remove duplicates
        $groupKeys = array_unique($groupKeys);
        $stringKeys = array_unique($stringKeys);

        return $groupKeys + $stringKeys;
    }
}
