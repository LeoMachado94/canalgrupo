<?php

namespace Tests\Concerns;

trait AssertsGolden
{
    protected function assertGoldenJson(string $name, $actual): void
    {
        if (is_string($actual)) {
            $actual = json_decode($actual, true);
        }

        $this->assertGolden(
            $name.'.json',
            json_encode($actual, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n"
        );
    }

    protected function assertGoldenHtml(string $name, string $html): void
    {
        $this->assertGolden($name.'.html', $this->normalizeHtml($html));
    }

    protected function assertGolden(string $file, string $actual): void
    {
        $path = base_path('tests/golden/'.$file);

        if (getenv('GOLDEN_UPDATE')) {
            if (! is_dir(dirname($path))) {
                mkdir(dirname($path), 0777, true);
            }
            file_put_contents($path, $actual);
        }

        if (getenv('GOLDEN_ACTUAL')) {
            $actualPath = base_path('tests/golden-actual/'.$file);
            if (! is_dir(dirname($actualPath))) {
                mkdir(dirname($actualPath), 0777, true);
            }
            file_put_contents($actualPath, $actual);
            $this->addToAssertionCount(1);

            return;
        }

        $this->assertFileExists($path, "Golden ausente: {$file} (gere com GOLDEN_UPDATE=1 na versão antiga)");
        $this->assertSame(file_get_contents($path), $actual, "Golden divergente: {$file}");
    }

    protected function normalizeHtml(string $html): string
    {
        $html = preg_replace('/(name="_token" value=")[^"]*"( autocomplete="off")?/', '$1TOKEN"', $html);
        $html = preg_replace('/(name="csrf-token" content=")[^"]*/', '$1TOKEN', $html);
        $html = preg_replace('/("_token"\s*:\s*")[^"]*/', '$1TOKEN', $html);
        $html = preg_replace("/('_token'\s*:\s*')[^']*/", '$1TOKEN', $html);
        // Whitespace between tags is not significant and Blade's compiler output changed across versions.
        $html = preg_replace('/>\s+</', '><', $html);
        $html = preg_replace('/\s+/', ' ', $html);

        return trim($html)."\n";
    }
}
