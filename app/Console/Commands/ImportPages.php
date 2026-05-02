<?php

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;

class ImportPages extends Command
{
    protected $signature = 'pages:import {file : Path to the MySQL SQL dump file}';

    protected $description = 'Import pages data from a MySQL SQL dump file into the pages table';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return 1;
        }

        $this->info("Reading SQL dump: {$file}");
        $content = file_get_contents($file);
        $this->info('File size: ' . number_format(strlen($content)) . ' bytes');

        // Find all INSERT INTO `pages` statements using a state-machine approach
        $insertStatements = $this->extractInsertStatements($content, 'pages');

        if (empty($insertStatements)) {
            $this->error('No INSERT INTO `pages` statements found in the dump.');
            return 1;
        }

        $this->info('Found ' . count($insertStatements) . ' INSERT statements.');

        // Clear existing pages
        $existingCount = Page::count();
        if ($existingCount > 0 && $this->confirm("There are {$existingCount} existing pages. Delete them before importing?", true)) {
            Page::truncate();
            $this->info('Existing pages deleted.');
        }

        $imported = 0;
        $errors = 0;

        foreach ($insertStatements as $stmt) {
            $values = $this->parseValuesFromInsert($stmt);

            if ($values === null || count($values) < 5) {
                $this->warn('Could not parse values. Got ' . ($values ? count($values) : 0) . ' fields.');
                $errors++;
                continue;
            }

            $id = (int) $values[0];
            $name = $values[1];
            $data = $values[2];
            $sidebar = $values[3];
            $script = $values[4];

            $thumbnail = '/assets/media/' . $name . '.jpg';

            try {
                Page::updateOrCreate(
                    ['name' => $name],
                    [
                        'data' => $data,
                        'sidebar' => $sidebar,
                        'script' => $script,
                        'thumbnail' => $thumbnail,
                    ]
                );
                $imported++;
                $this->line("  [{$imported}] Imported: {$name}");
            } catch (\Exception $e) {
                $this->error("  Failed to import {$name}: " . $e->getMessage());
                $errors++;
            }
        }

        $this->newLine();
        $this->info("Import complete: {$imported} pages imported, {$errors} errors.");
        $this->info('Total pages in database: ' . Page::count());

        return 0;
    }

    /**
     * Extract INSERT statements for a given table using a state machine
     * that properly handles quoted strings with escaped characters.
     */
    private function extractInsertStatements(string $content, string $table): array
    {
        $statements = [];
        $marker = "INSERT INTO `{$table}`";
        $pos = 0;
        $len = strlen($content);

        while (($start = strpos($content, $marker, $pos)) !== false) {
            // Find the end of this statement (semicolon outside of quotes)
            $i = $start;
            $inString = false;

            while ($i < $len) {
                $ch = $content[$i];

                if ($inString) {
                    if ($ch === '\\') {
                        $i += 2; // skip escaped character
                        continue;
                    }
                    if ($ch === '\'') {
                        $inString = false;
                    }
                } else {
                    if ($ch === '\'') {
                        $inString = true;
                    } elseif ($ch === ';') {
                        // Found end of statement
                        $statements[] = substr($content, $start, $i - $start + 1);
                        $pos = $i + 1;
                        break;
                    }
                }
                $i++;
            }

            if ($i >= $len) {
                break; // reached end of file
            }
        }

        return $statements;
    }

    /**
     * Parse the VALUES clause from an INSERT statement into an array of field values.
     */
    private function parseValuesFromInsert(string $stmt): ?array
    {
        // Find "VALUES" keyword
        $valuesPos = strpos($stmt, 'VALUES');
        if ($valuesPos === false) {
            $valuesPos = strpos($stmt, 'values');
        }
        if ($valuesPos === false) {
            return null;
        }

        // Find the opening parenthesis after VALUES
        $openParen = strpos($stmt, '(', $valuesPos);
        if ($openParen === false) {
            return null;
        }

        // Find the matching closing parenthesis (the last `)` before `;`)
        $closeParen = strrpos($stmt, ')');
        if ($closeParen === false || $closeParen <= $openParen) {
            return null;
        }

        // Extract the content between parentheses
        $valuesStr = substr($stmt, $openParen + 1, $closeParen - $openParen - 1);

        return $this->parseMySQLValues($valuesStr);
    }

    /**
     * Parse MySQL VALUES string into individual field values.
     * Properly handles escaped quotes and special characters within strings.
     */
    private function parseMySQLValues(string $str): array
    {
        $values = [];
        $i = 0;
        $len = strlen($str);

        while ($i < $len) {
            // Skip whitespace and newlines
            while ($i < $len && in_array($str[$i], [' ', "\n", "\r", "\t"])) {
                $i++;
            }

            if ($i >= $len) break;

            if ($str[$i] === '\'') {
                // Quoted string value
                $i++; // skip opening quote
                $value = '';
                while ($i < $len) {
                    if ($str[$i] === '\\') {
                        // MySQL backslash escape
                        $i++;
                        if ($i < $len) {
                            switch ($str[$i]) {
                                case '\'': $value .= '\''; break;
                                case '"': $value .= '"'; break;
                                case '\\': $value .= '\\'; break;
                                case 'n': $value .= "\n"; break;
                                case 'r': $value .= "\r"; break;
                                case 't': $value .= "\t"; break;
                                case '0': $value .= "\0"; break;
                                default: $value .= $str[$i]; break;
                            }
                            $i++;
                        }
                    } elseif ($str[$i] === '\'') {
                        // Could be '' (SQL-style escaped quote) or end of string
                        if ($i + 1 < $len && $str[$i + 1] === '\'') {
                            $value .= '\'';
                            $i += 2;
                        } else {
                            $i++; // skip closing quote
                            break;
                        }
                    } else {
                        $value .= $str[$i];
                        $i++;
                    }
                }
                $values[] = $value;
            } else {
                // Unquoted value (number or NULL)
                $value = '';
                while ($i < $len && $str[$i] !== ',') {
                    $value .= $str[$i];
                    $i++;
                }
                $values[] = trim($value);
            }

            // Skip comma separator
            while ($i < $len && ($str[$i] === ' ' || $str[$i] === "\n" || $str[$i] === "\r")) {
                $i++;
            }
            if ($i < $len && $str[$i] === ',') {
                $i++;
            }
        }

        return $values;
    }
}
