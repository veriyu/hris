<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('app/Filament'));
foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() == 'php') {
        $c = file_get_contents($file->getPathname());
        $newC = str_replace(
            ['Filament\Forms\Components', 'Forms\Components\TextInput', 'Forms\Components\DatePicker'],
            ['Filament\Schemas\Components', 'Filament\Schemas\Components\TextInput', 'Filament\Schemas\Components\DatePicker'],
            $c
        );
        if ($c !== $newC) {
            file_put_contents($file->getPathname(), $newC);
            echo "Updated " . $file->getPathname() . "\n";
        }
    }
}
