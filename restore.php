<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('app/Filament'));

$schemaComponents = [
    'Section', 'Grid', 'Group', 'Tabs', 'Wizard', 'Fieldset', 'Callout', 
    'Flex', 'FusedGroup', 'Html', 'Icon', 'Image', 'Text', 'UnorderedList', 'View'
];

foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() == 'php') {
        $c = file_get_contents($file->getPathname());
        
        // 1. Revert ALL Schemas\Components back to Forms\Components
        $newC = str_replace('Filament\Schemas\Components', 'Filament\Forms\Components', $c);
        
        // 2. Change only the specific layout components to Schemas\Components
        foreach ($schemaComponents as $component) {
            $newC = str_replace(
                "Filament\Forms\Components\\$component;", 
                "Filament\Schemas\Components\\$component;", 
                $newC
            );
            $newC = str_replace(
                "Filament\Forms\Components\\$component::", 
                "Filament\Schemas\Components\\$component::", 
                $newC
            );
        }
        
        if ($c !== $newC) {
            file_put_contents($file->getPathname(), $newC);
            echo "Restored " . $file->getPathname() . "\n";
        }
    }
}
